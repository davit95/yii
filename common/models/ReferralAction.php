<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Model for referral action
 */
class ReferralAction extends ActiveRecord
{
    const SCENARIO_CREATE = 'CREATE';
    const SCENARIO_UPDATE = 'UPDATE';

    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%referral_actions}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Referral action id',
            'name' => 'Name',
            'description' => 'Description',
            'points' => 'Award points granted',
            'status' => 'Status'
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
            ['name', 'required'],
            ['name', 'string', 'min' => 1, 'max' => 50],
            ['description', 'required'],
            ['description', 'string', 'min' => 1, 'max' => 255],
            ['points', 'required'],
            ['points', 'number', 'min' => 0],
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
            self::SCENARIO_CREATE => ['name', 'description', 'points', 'status'],
            self::SCENARIO_UPDATE => ['id', 'name', 'description', 'points', 'status'],
        ];
    }

    /**
     * Finds and returns referral action by name
     *
     * @param  string $name
     * @return common\models\ReferralAction
     */
    public static function findByName($name)
    {
        return static::find()->where(['name' => $name])->one();
    }

    /**
     * Returns true if action is active
     *
     * @return boolean
     */
    public function isActive()
    {
        return ($this->status == self::STATUS_ACTIVE);
    }
}
