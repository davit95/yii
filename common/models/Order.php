<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;
use common\models\Product;
use common\models\Voucher;

/**
 * Model for orders
 */
class Order extends ActiveRecord
{
    const STATUS_COMPLETED = 'COMPLETED';
    const STATUS_PENDING = 'PENDING';
    const STATUS_PAUSED = 'PAUSED';
    const STATUS_ERROR = 'ERROR';
    const STATUS_CANCELED = 'CANCELED';

    const SCENARIO_CREATE = 'CREATE';
    const SCENARIO_UPDATE = 'UPDATE';

    private $orderData = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%orders}}';
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated']
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'required'],
            ['id', 'exist', 'targetClass' => static::className(), 'targetAttribute' =>  'id'],
            ['user_id', 'required'],
            ['user_id', 'exist', 'targetClass' => User::className(), 'targetAttribute' =>  'id'],
            ['cost', 'required'],
            ['cost', 'number'],
            ['currency', 'required'],
            ['currency', 'string', 'min' => 3, 'max' => 3],
            ['description', 'required'],
            ['description', 'string'],
            ['product_id', 'required'],
            ['product_id', 'exist', 'targetClass' => Product::className(), 'targetAttribute' =>  'id'],
            ['voucher_id', 'exist', 'targetClass' => Voucher::className(), 'targetAttribute' =>  'id'],
            ['status', 'required'],
            ['status', 'in', 'range' => [self::STATUS_COMPLETED, self::STATUS_PENDING, self::STATUS_PAUSED, self::STATUS_ERROR, self::STATUS_CANCELED]],
            ['notification_data', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['user_id', 'cost', 'currency', 'description', 'product_id', 'voucher_id', 'status', 'notification_data'],
            self::SCENARIO_UPDATE => ['id', 'user_id', 'cost', 'currency', 'description', 'product_id', 'voucher_id', 'status', 'notification_data'],
        ];
    }

    /**
     * Return order owner
     *
     * @return User
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Returns ordered product
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
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
        if ($this->orderData === null) {
            return ($this->data == null) ? serialize([]) : $this->data;
        }
        return serialize($this->orderData);
    }

    /**
     * Adds transaction data
     *
     * @param string $name
     * @param mixed $value
     */
    public function addOrderData($name, $value)
    {
        if (!is_string($name) || (!is_string($value) && !is_numeric($value) && !is_null($value) && !is_array($value))) {
            throw new InvalidParamException('Invalid data name or value.');
        }
        if ($this->orderData === null) {
            $this->orderData = $this->getUnserializedData();
        }
        $this->orderData[$name] = $value;
    }

    /**
     * Returns order data. If value is null or not set [[$defult]] is returned
     *
     * @param  string $name
     * @param  mixed $default Default value
     * @return mixed
     */
    public function getOrderData($name, $default = null)
    {
        if ($this->orderData === null) {
            $this->orderData = $this->getUnserializedData();
        }

        if (!isset($this->orderData[$name]) || $this->orderData[$name] == null) {
            return $default;
        }

        return $this->orderData[$name];
    }
}
