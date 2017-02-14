<?php

namespace service\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Model that represents service instance
 */
class Instance extends ActiveRecord
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%instances}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['uid', 'required'],
            ['uid', 'string', 'min' => 1, 'max' => 10],
            ['name', 'required'],
            ['name', 'string', 'min' => 1, 'max' => 100],
            ['storing_enabled', 'required'],
            ['storing_enabled', 'boolean', 'trueValue' => 1, 'falseValue' => 0],
            ['proxy_enabled', 'required'],
            ['proxy_enabled', 'boolean', 'trueValue' => 1, 'falseValue' => 0],
            ['status', 'required'],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id' => 'id',
            'uid' => 'uid',
            'name' => 'name',
            'storing_enabled' => 'storing_enabled',
            'status' => 'status'
        ];
    }

    /**
     * Returns true if service status is ACTIVE
     *
     * @return boolean
     */
    public function isActive()
    {
        return ($this->status == self::STATUS_ACTIVE);
    }

    /**
     * Returns true if content storing is enabled globaly
     *
     * @return boolean
     */
    public function isStoringEnabled()
    {
        return ((int)$this->storing_enabled === 1);
    }

    /**
     * Returns true if using proxy is enabled globaly
     *
     * @return boolean
     */
    public function isProxyEnabled()
    {
        return ((int)$this->proxy_enabled === 1);
    }
}
