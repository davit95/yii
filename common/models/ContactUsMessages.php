<?php

namespace common\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "contact_us_messages".
 *
 * @property integer $id
 * @property integer $receiver_id
 * @property integer $sender_id
 * @property string $email
 * @property string $subject
 * @property string $message
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Users $receiver
 * @property Users $sender
 */
class ContactUsMessages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact_us_messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['receiver_id', 'email', 'message'], 'required'],
            [['receiver_id', 'sender_id', 'created_at', 'updated_at'], 'integer'],
            [['message'], 'string'],
            [['subject'], 'string', 'max' => 255],
            [['receiver_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['receiver_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'receiver_id' => Yii::t('app', 'Receiver ID'),
            'sender_id' => Yii::t('app', 'Sender ID'),
            'email' => Yii::t('app', 'Email'),
            'subject' => Yii::t('app', 'Subject'),
            'message' => Yii::t('app', 'Message'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['updated_at', 'created_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceiver()
    {
        return $this->hasOne(Users::className(), ['id' => 'receiver_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(Users::className(), ['id' => 'sender_id']);
    }
}
