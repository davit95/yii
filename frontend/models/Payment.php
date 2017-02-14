<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%payments}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $transaction_id
 * @property string $state
 * @property double $amount
 * @property string $currency
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Users $user
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%payments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount'], 'number'],
            [['transaction_id', 'state', 'currency'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transaction_id' => 'Transaction ID',
            'product_id' => 'Product ID',
            'state' => 'State',
            'amount' => 'Amount',
            'currency' => 'Currency',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
