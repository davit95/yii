<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Model for download journal
 */
class DownloadJournal extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%download_journals}}';
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['timestamp']
                ]
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['service_uid', 'required'],
            ['user_id', 'required'],
            ['provider', 'required'],
            ['bytes_sent', 'required']
        ];
    }

    /**
     * Returns bytes sended to user
     *
     * @param  User $user
     * @param  mixed $from date in format '2016-01-01 12:12:12' or integer (representing timestamp)
     * @param  mixed $till date in format '2016-01-01 12:12:12' or integer (representing timestamp)
     * @return integer
     */
    public static function getBytesSendedToUser($user, $from = null, $till = null)
    {
        $query = static::find()->where(['user_id' => $user->id]);

        if ($from != null) {
            if (is_string($from)) {
                $from = Yii::$app->formatter->asTimestamp($from);
            }
            $query->andWhere(['>=', 'timestamp', $from]);
        }
        if ($till != null) {
            if (is_string($till)) {
                $from = Yii::$app->formatter->asTimestamp($till);
            }
            $query->andWhere(['<=', 'timestamp', $till]);
        }

        return $query->sum('bytes_sent');
    }
}
