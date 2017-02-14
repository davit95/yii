<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Model for unrestrained links
 */
class UnrestrainedLink extends ActiveRecord
{
    const SCENARIO_CREATE = 'CREATE';
    const SCENARIO_DELETE = 'DELETE';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%unrestrained_links}}';
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created']
                ]
            ],
            [
                'class' => 'yii\behaviors\AttributeBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'hash',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'hash',
                ],
                'value' => [$this, 'generateHash']
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User id',
            'download_link' => 'Download link',
            'stream_link' => 'Stream link',
            'content_name' => 'Content name',
            'content_size' => 'Content size',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules ()
    {
        return [
            ['user_id', 'required'],
            ['user_id', 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id'],
            ['download_link', 'string', 'min' => 1, 'max' => 200],
            ['stream_link', 'string', 'min' => 1, 'max' => 200],
            ['content_name', 'required'],
            ['content_name', 'string', 'min' => 1, 'max' => 255],
            ['content_size', 'required'],
            ['content_size', 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['user_id', 'download_link', 'stream_link', 'content_name', 'content_size'],
            self::SCENARIO_DELETE => ['id']
        ];
    }

    /**
     * Returns unrestrained link by hash
     *
     * @param  string $hash
     * @return UnrestrainedLink
     */
    public static function findByHash($hash)
    {
        return static::find()->where(['hash' => $hash])->one();
    }

    /**
     * Returns inner download link
     *
     * @return string
     */
    public function getInnerDownloadLink()
    {
        return Url::to(['/proxy/process-download', 'hash' => $this->hash], true);
    }

    /**
     * Returns inner stream link
     *
     * @return string
     */
    public function getInnerStreamLink()
    {
        return Url::to(['/proxy/process-stream', 'hash' => $this->hash], true);
    }

    /**
     * Returns owner (user) of unrestrined link
     *
     * @return User
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Returns formatted content size
     *
     * @return string
     */
    public function getFormattedContentSize()
    {
        return Yii::$app->formatter->asShortSize($this->content_size);
    }

    /**
     * Checks if link can be downloaded
     *
     * @return boolean
     */
    public function isDownloadable()
    {
        return ($this->download_link !== null);
    }

    /**
     * Checks if link can be streamed
     *
     * @return boolean
     */
    public function isStreamable()
    {
        return ($this->stream_link !== null);
    }

    /**
     * Generates unrestrained link hash
     *
     * @return string
     */
    public function generateHash()
    {
        return sha1($this->user_id.$this->content_name.$this->content_size.$this->created.uniqid('', true));
    }

    /**
     * Returns shortened content name
     *
     * @return string
     */
    public function getShortenedContentName()
    {
        if (mb_strlen($this->content_name) > 50) {
            return mb_substr($this->content_name, 0, 50).'...';
        }

        return $this->content_name;
    }
}
