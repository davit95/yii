<?php

namespace common\models;

use Yii;
use yii\db\Query;
use yii\db\ActiveRecord;
use yii\base\InvalidParamException;

/**
 * Model for user's funds transactions
 */
class Transaction extends ActiveRecord
{
    const SCENARIO_CREATE = 'CREATE';
    const SCENARIO_UPDATE = 'UPDATE';
    const SCENARIO_DELETE = 'DELETE';

    const TYPE_INCOMING = 'INCOMING';
    const TYPE_OUTGOING = 'OUTGOING';

    const CURRENCY_USD = 'USD';
    const CURRENCY_EUR = 'EUR';
    const CURRENCY_BTC = 'BTC';

    const CURRENCY_SYM_USD = '$';
    const CURRENCY_SYM_EUR = '€';
    const CURRENCY_SYM_BTC = '฿';

    private $transactionData = null;

    /**
     * @inheritdoc
     */
    public static function tableName ()
    {
        return '{{%transactions}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors ()
    {
        return [
            [
                'class' => 'yii\behaviors\AttributeBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'data',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'data',
                ],
                'value' => [$this, 'getSerializedData']
            ],
            [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['timestamp']
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Transaction id',
            'user_id' => 'User id',
            'amount' => 'Amount',
            'currency' => 'Currency',
            'type' => 'Transaction type',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'required'],
            ['id', 'exist', 'targetClass' => self::className(), 'targetAttribute' => 'id'],
            ['user_id', 'required'],
            ['user_id', 'exist', 'targetClass' => 'common\models\User', 'targetAttribute' => 'id'],
            ['amount', 'required'],
            ['amount', 'number', 'min' => 0],
            ['currency', 'required'],
            ['curreny', 'in', 'range' => [self::CURRENCY_USD, self::CURRENCY_EUR, self::CURRENCY_BTC]],
            ['type', 'required'],
            ['type', 'in', 'range' => [self::TYPE_INCOMING, self::TYPE_OUTGOING]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['user_id', 'amount', 'currency', 'type'],
            self::SCENARIO_UPDATE => ['id', 'user_id', 'amount', 'currency', 'type'],
            self::SCENARIO_DELETE => ['id']
        ];
    }

    /**
     * Returns user
     *
     * @return User
     */
    public function getUser ()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Returnes currency symbol fir given currency
     *
     * @param  string $currency
     * @return string
     */
    public static function getCurrencySym ($currency)
    {
        switch ($currency) {
            case self::CURRENCY_USD:
                return self::CURRENCY_SYM_USD;
            case self::CURRENCY_EUR:
                return self::CURRENCY_SYM_EUR;
            case self::CURRENCY_BTC:
                return self::CURRENCY_SYM_BTC;
            default:
                return null;
        }
    }

    /**
     * Returns transaction amount with prepended or appended currency symbol
     *
     * @param  boolean $prepend
     * @return string
     */
    public function getAmountWithCurrencySym ($prepend = true)
    {
        if ($prepend) {
            return static::getCurrencySym($this->currency).$this->amount;
        } else {
            return $this->amount.static::getCurrencySym($this->currency);
        }
    }

    /**
     * Returns formated transaction timestamp
     *
     * @return string
     */
    public function getFormattedTimestamp()
    {
        return Yii::$app->formatter->asDate($this->timestamp, 'php:d.m.Y');
    }

    /**
     * Returns total transaction (of givent type) ammount per month by user
     *
     * @param  User   $user
     * @param  string $type transaction type
     * @param  integer $startDate
     * @param  integer $endDate
     * @param  boolean $incCurr true to add currency symbol before amount
     * @return array
     */
    public static function getTotalAmountPerMonthByUser (User $user, $type, $startDate = null, $endDate = null, $incCurr = true)
    {
        $amountQuery = new Query();
        $amountQuery->select('MIN(timestamp) AS min_timestamp, MAX(timestamp) AS max_timestamp, SUM(amount) AS total, currency');
        $amountQuery->from(static::tableName());
        $amountQuery->where(['user_id' => $user->id]);
        $amountQuery->andWhere(['type' => $type]);
        if ($startDate != null) {
            $amountQuery->andWhere(['>=', 'timestamp', $startDate]);
        }
        if ($endDate != null) {
            $amountQuery->andWhere(['>=', 'timestamp', $endDate]);
        }
        $amountQuery->groupBy(['currency','YEAR(DATE(FROM_UNIXTIME(timestamp)))','MONTH(DATE(FROM_UNIXTIME(timestamp)))']);

        $amounts = array();
        foreach ($amountQuery->each() as $amount) {
            $amounts[Yii::$app->formatter->asDate($amount['min_timestamp'], 'php:F Y')] = static::getCurrencySym($amount['currency']).$amount['total'];
        }

        return $amounts;
    }

    /**
     * Returns unserialized transaction
     *
     * @return array
     */
    public function getUnserializedData()
    {
        if (($data = @unserialize($this->data)) === false) {
            return [];
        }
        return $data;
    }

    /**
     * Serializes transaction data
     *
     * @return string
     */
    public function getSerializedData()
    {
        if ($this->transactionData === null) {
            return ($this->data == null) ? serialize([]) : $this->data;
        }
        return serialize($this->transactionData);
    }

    /**
     * Adds transaction data
     *
     * @param string $name
     * @param mixed $value
     */
    public function addTransactionData($name, $value)
    {
        if (!is_string($name) || (!is_string($value) && !is_numeric($value) && !is_null($value) && !is_array($value))) {
            throw new InvalidParamException('Invalid data name or value.');
        }
        if ($this->transactionData === null) {
            $this->transactionData = $this->getUnserializedData();
        }
        $this->transactionData[$name] = $value;
    }

    /**
     * Returns transaction data. If value is null or not set [[$defult]] is returned
     *
     * @param  string $name
     * @param  mixed $default Default value
     * @return mixed
     */
    public function getTransactionData($name, $default = null)
    {
        if ($this->transactionData === null) {
            $this->transactionData = $this->getUnserializedData();
        }

        if (!isset($this->transactionData[$name]) || $this->transactionData[$name] == null) {
            return $default;
        }

        return $this->transactionData[$name];
    }
}
