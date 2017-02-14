<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;

/**
 * Model for reseller fee
 *
 * This model may be used to apply discounts resellers.
 */
class ResellerFee extends ActiveRecord
{

    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%resellers_fees}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'required'],
            ['id', 'exist', 'targetClass' => self::className(), 'targetAttribute' => 'id'],
            ['percent', 'number', 'min' => 0, 'max' => '100'],
            ['amount', 'number', 'min' => 0],
            ['user_id', 'required'],
            ['user_id', 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id'],
            ['status', 'required'],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated']
                ]
            ],
        ];
    }

    /**
     * Returns fee
     *
     * @param  User   $user
     * @return ResellerFee
     */
    public static function findByUser(User $user)
    {
        return static::find()
            ->where(['user_id' => $user->id])
            ->andWhere(['status' => self::STATUS_ACTIVE])
            ->orderBy(['created' => SORT_DESC])
            ->one();
    }

    /**
     * Applies discount to price.
     *
     * @param  float $price
     * @return float price with discount
     */
    public function applyDiscount($price)
    {
        return round($price - ($price * ($this->percent / 100) + $this->amount), 2);
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
}
