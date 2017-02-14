<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Model for referal link
 */
class ReferralLink extends ActiveRecord
{
    const SCENARIO_CREATE = 'CREATE';
    const SCENARIO_UPDATE = 'UPDATE';
    const SCENARIO_DELETE = 'DELETE';

    const TYPE_DIRECT = 'DIRECT';
    const TYPE_PHPBBFORUM = 'PHPBBFORUM';
    const TYPE_IMAGE = 'IMAGE';

    /**
     * @inheritdoc
     */
    public static function tableName ()
    {
        return '{{%referral_links}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Referral link id',
            'name' => 'Name',
            'type' => 'Type',
            'template' => 'Template'
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
            ['name', 'string', 'min' => 1, 'max' => 100],
            ['type', 'required'],
            ['type', 'in', 'range' => [self::TYPE_DIRECT, self::TYPE_PHPBBFORUM, self::TYPE_IMAGE]],
            ['template', 'required'],
            ['template', 'string', 'min' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['name', 'type', 'template'],
            self::SCENARIO_UPDATE => ['id', 'name', 'type', 'template'],
            self::SCENARIO_DELETE => ['id']
        ];
    }

    /**
     * Returns referral link
     *
     * @param  User   $user owner of link
     * @param  array  $data additional data which may be required for link generation. Format is 'param' => 'value'
     * @return string
     */
    public function getLink (User $owner, $data = [])
    {
        $link = str_ireplace('{uid}', $owner->id, $this->template);
        $link = str_ireplace('{lid}', $this->id, $link);

        if (is_array($data) && !empty($data)) {
            foreach ($data as $param => $value) {
                $link = str_ireplace('{'.$param.'}', $value, $link);
            }
        }

        return $link;
    }
}
