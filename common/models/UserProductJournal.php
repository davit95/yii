<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Model for user's products journal
 */
class UserProductJournal extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users_products_journal}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors ()
    {
        return [
            [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['timestamp'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['timestamp']
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
            ['user_id', 'required'],
            ['user_id', 'exist', 'targetClass' => User::className(), 'targetAttribute' =>  'id'],
            ['product_id', 'required'],
            ['product_id', 'exist', 'targetClass' => Product::className(), 'targetAttribute' =>  'id']
        ];
    }

}
