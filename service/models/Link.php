<?php

namespace service\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Exception;
use yii\helpers\Url;

/**
 * Model for links
 */
class Link extends ActiveRecord
{
    const SCENARIO_CREATE = 'CREATE';
    const SCENARIO_DELETE = 'DELETE';

    private $contentProvider;
    private $content;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%links}}';
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
            ],
            [
                'class' => 'yii\behaviors\AttributeBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'content_name',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'content_name',
                ],
                'value' => [$this, 'getContentName']
            ],
            [
                'class' => 'yii\behaviors\AttributeBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'content_size',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'content_size',
                ],
                'value' => [$this, 'getContentSize']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Link id',
            'user_id' => 'User id',
            'link' => 'Link',
            'password' => 'Password'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'required'],
            ['id', 'exist', 'targetClass' => static::className(), 'targetAttribute' => 'id'],
            ['user_id', 'required'],
            ['link', 'required'],
            ['link', 'string', 'min' => 1, 'max' => 500],
            ['link', 'validateLink'],
            ['password', 'string', 'min' => 1, 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id' => 'id',
            'userId' => 'user_id',
            'link' => 'link',
            'password' => 'password',
            'downloadLink' => 'downloadLink',
            'streamLink' => 'streamLink',
            'contentName' => 'content_name',
            'contentSize' => 'content_size',
            'created' => 'created'
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['user_id', 'link', 'password'],
            self::SCENARIO_DELETE => ['id']
        ];
    }

    /**
     * Returns links for given user
     *
     * @param  integer $userId
     * @return  yii\db\ActiveQueryInterface
     */
    public static function findByUser($userId)
    {
        return static::find()->where(['user_id' => $userId]);
    }

    /**
     * Returns link by given hash
     *
     * @param  string $hash
     * @return  yii\db\ActiveQueryInterface
     */
    public static function findByHash($hash)
    {
        return static::find()->where(['hash' => $hash]);
    }

    /**
     * Returns unrestrained download link
     *
     * @return string|null
     */
    public function getDownloadLink()
    {
        $provider = $this->getContentProvider();
        if ($provider != null) {
            if ($provider->isDownloadable() && $this->hash != null) {
                return Url::to(['/content/download', 'hash' => $this->hash], true);
            }
        }

        return null;
    }

    /**
     * Returns unrestrained stream link
     *
     * @return string
     */
    public function getStreamLink()
    {
        $provider = $this->getContentProvider();
        if ($provider != null) {
            if ($provider->isStreamable() && $this->hash != null) {
                return Url::to(['/content/stream', 'hash' => $this->hash], true);
            }
        }

        return null;
    }

    /**
     * Returns content provider
     *
     * @return ContentProvider
     */
    public function getContentProvider()
    {
        if ($this->contentProvider === null) {
            $this->contentProvider = ContentProvider::guessByUrl($this->link);
        }

        return $this->contentProvider;
    }

    /**
     * Returns content information
     *
     * @return Content
     */
    public function getContent()
    {
        if ($this->content === null) {
            $provider = $this->getContentProvider();
            if ($provider !== null) {
                try {
                    $this->content = $provider->getContent($this);
                } catch (\Exception $e) {
                    $this->content = null;
                }
            }
        }

        return $this->content;
    }

    /**
     * Returns link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Returns content  name
     *
     * @return string
     */
    public function getContentName()
    {
        $content = $this->getContent();
        if ($content !== null) {
            return $content->name;
        }
    }

    /**
     * Returns content size
     *
     * @return string
     */
    public function getContentSize()
    {
        $content = $this->getContent();
        if ($content !== null) {
            return $content->length;
        }
    }

    /**
     * Generates link hash
     *
     * @return string
     */
    public function generateHash()
    {
        return sha1($this->user_id.$this->link.$this->created.uniqid('', true));
    }

    /**
     * Checks if link is protected by
     *
     * @return boolean
     */
    public function hasPassword()
    {
        return ($this->password !== null);
    }

    /**
     * Returns password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Validates link
     *
     * @return void
     */
    public function validateLink()
    {
        $content = $this->getContent();
        //TODO: Maybe add validation by content-type ?
        if ($content === null) {
            $this->addError('link', 'Invalid link.');
        }
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        if ($this->validate()) {
            return parent::delete();
        } else {
            return false;
        }
    }
}
