<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;

/**
 * Model for tickets
 */
class Ticket extends ActiveRecord
{
    const SCENARIO_CREATE = 'CREATE';
    const SCENARIO_DELETE = 'DELETE';

    const EXP_PERIOD = 18000;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tickets}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\behaviors\AttributeBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'ticket',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'ticket',
                ],
                'value' => [$this, 'generateTicket']
            ],
            [
                'class' => 'yii\behaviors\AttributeBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'expires',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'expires',
                ],
                'value' => [$this, 'generateExpiration']
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
            ['id', 'exist', 'targetClass' => self::className(), 'targetAttribute' => 'id'],
            ['user_id', 'required'],
            ['user_id', 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['user_id'],
            self::SCENARIO_DELETE => ['id']
        ];
    }

    /**
     * Returns ticket
     *
     * @return Ticket
     */
    public static function findByTicket($ticket)
    {
        return static::find()->where(['ticket' => $ticket])->one();
    }

    /**
     * Deletes expired tickets
     *
     * @return integer
     */
    public static function deleteExpired()
    {
        return static::deleteAll(['<', 'expires', time()]);
    }

    /**
     * Sets ticket owner
     *
     * @param User $user
     * @return void
     */
    public function setOwner(User $user)
    {
        $this->user_id = $user->id;
    }

    /**
     * Returns user (owner) of ticket
     *
     * @return User
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Checks if ticket is expired
     *
     * @return boolean
     */
    public function isExpired()
    {
        return ($this->expires < time());
    }

    /**
     * Generates ticket
     *
     * @return string
     */
    public function generateTicket()
    {
        return Yii::$app->security->generateRandomString(40);
    }

    /**
     * Returns expiration date
     *
     * @return integer
     */
    public function generateExpiration()
    {
        return time() + self::EXP_PERIOD;
    }
}
