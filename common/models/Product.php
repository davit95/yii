<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Model for products
 */
class Product extends ActiveRecord
{
    const TYPE_LIMITED = 'LIMITED';
    const TYPE_DAILY = 'DAILY';

    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products}}';
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
            ['name', 'required'],
            ['name', 'string'],
            ['description', 'required'],
            ['description', 'string'],
            ['type', 'required'],
            ['type', 'in', 'range' => [self::TYPE_LIMIT, self::TYPE_DAYS]],
            ['limit', 'number'],
            ['days', 'number'],
            ['status', 'required'],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['name', 'description', 'type', 'limit', 'days', 'status'],
            self::SCENARIO_UPDATE => ['id', 'name', 'description', 'type', 'limit', 'days', 'status'],
        ];
    }

    /**
     * Returns products of given type
     *
     * @param  string $type
     * @return ActiveQuery
     */
    public static function findByType($type)
    {
        return static::find()->where(['type' => $type]);
    }
}
