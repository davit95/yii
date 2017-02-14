<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Product;

/**
 * Voucher model
 */
class Voucher extends ActiveRecord
{
    const SCENARIO_CREATE = 'CREATE';
    const SCENARIO_UPDATE = 'UPDATE';
    const SCENARIO_DELETE = 'DELETE';

    const STATUS_NOT_USED = 'NOT USED';
    const STATUS_USED = 'USED';
    const STATUS_SUSPENDED = 'SUSPENDED';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vouchers}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Voucher id',
            'voucher' => 'Voucher',
            'product_id' => 'Product',
            'issuer_id' => 'Issuer',
            'user_id' => 'User',
            'is_payed' => 'Payed',
            'created' => 'Created',
            'used' => 'Used',
            'status' => 'Status'
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'voucher' => 'voucher',
            'issuer' => function () {
                return $this->issuer->email;
            },
            'product' => function () {
                return "{$this->product->name} ({$this->product->description})";
            },
            'payed' => function () {
                return ($this->is_payed) ? 'yes' : 'no';
            },
            'created' => function () {
                return Yii::$app->formatter->asDate($this->created, 'php:Y-m-d H:i:s');
            },
            'used' => function () {
                return ($this->used != null) ? Yii::$app->formatter->asDate($this->used, 'php:Y-m-d H:i:s') : '-';
            },
            'status' => 'status'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'required'],
            ['id', 'exist', 'targetClass' => static::className(), 'targetAttribute' => 'id'],
            ['product_id', 'required'],
            ['product_id', 'exist', 'targetClass' => Product::className(), 'targetAttribute' => 'id'],
            ['issuer_id', 'required'],
            ['issuer_id', 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id'],
            ['user_id', 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id', 'when' => function ($model) {
                return $model->user_id != null;
            }],
            ['is_payed', 'boolean'],
            ['status', 'required'],
            ['status', 'in', 'range' => [self::STATUS_NOT_USED, self::STATUS_USED, self::STATUS_SUSPENDED]]
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['product_id', 'issuer_id', 'user_id', 'is_payed', 'status'],
            self::SCENARIO_UPDATE => ['id', 'product_id', 'issuer_id', 'user_id', 'is_payed', 'status'],
            self::SCENARIO_DELETE => ['id']
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created']
                ]
            ],
            [
                'class' => 'yii\behaviors\AttributeBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'voucher',
                ],
                'value' => [$this, 'generateVoucher']
            ]
        ];
    }

    /**
     * Returns vouchers by issuer
     *
     * @param  User $issuer
     * @return Voucher[]
     */
    public static function findByIssuer($issuer)
    {
        return static::find()->where(['issuer_id' => $issuer->id])->all();
    }

    /**
     * Returns voucher by code
     *
     * @param  string $voucherCode
     * @return Voucher
     */
    public static function findByCode($voucherCode)
    {
        return static::find()->where(['voucher' => $voucherCode])->one();
    }

    /**
     * Returns voucher by code
     *
     * @param  string $voucherCode
     * @param  User   $issuer
     * @return Voucher
     */
    public static function findByCodeAndIssuer($voucherCode, User $issuer)
    {
        return static::find()->where(['voucher' => $voucherCode, 'issuer_id' => $issuer->id])->one();
    }

    /**
     * Returns product attached to this voucher
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * Returns voucher issuer
     *
     * @return User
     */
    public function getIssuer()
    {
        return $this->hasOne(User::className(), ['id' => 'issuer_id']);
    }

    /**
     * Returns user who used this voucher
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->user_id != null) {
            return User::findOne($this->user_id);
        }

        return null;
    }

    /**
     * Generates new voucher
     *
     * @return string
     */
    public function generateVoucher()
    {
        return sha1($this->issuer_id.$this->product_id.$this->created.uniqid('', true));
    }
}
