<?php

namespace service\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;

/**
 * Model for stored content chunks
 */
class StoredContentChunk extends ActiveRecord
{
    const SCENARIO_CREATE = 'CREATE';
    const SCENARIO_UPDATE = 'UPDATE';
    const SCENARIO_DELETE = 'DELETE';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stored_content_chunks}}';
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
                    ActiveRecord::EVENT_BEFORE_INSERT => 'file',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'file',
                ],
                'value' => [$this, 'createFile']
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Stored content chunk id',
            'stored_content_id' => 'Stored content id',
            'file' => 'File',
            'start' => 'Start',
            'end' => 'End url',
            'length' => 'Length',
            'locked' => 'Locked',
            'created' => 'Created'
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
            ['stored_content_id', 'required'],
            ['stored_content_id', 'exist', 'targetClass' => StoredContent::className(), 'targetAttribute' => 'id'],
            ['start', 'required'],
            ['start', 'number'],
            ['end', 'required'],
            ['end', 'number'],
            ['locked', 'boolean', 'trueValue' => 1, 'falseValue' => 0],
            ['length', 'required'],
            ['length', 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id' => 'id',
            'stored_content_id' => 'stored_content_id',
            'file' => 'file',
            'start' => 'start',
            'end' => 'end',
            'length' => 'length',
            'locked' => 'locked',
            'created' => 'created'
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['stored_content_id', 'start', 'end', 'length', 'locked'],
            self::SCENARIO_UPDATE => ['id', 'stored_content_id', 'start', 'end', 'length', 'locked'],
            self::SCENARIO_DELETE => ['id']
        ];
    }

    /**
     * Returns stored contend to which this chunk belongs
     *
     * @return service\models\StoredContent
     */
    public function getStoredContent()
    {
        return $this->hasOne(StoredContent::className(), ['id' => 'stored_content_id']);
    }

    /**
     * Creates content chunk file and returns its name
     *
     * @return string
     */
    public function createFile()
    {
        //Since chunk's file name depends on stored content name we need to update it only if
        //chunk is linked to different stored content
        if (!empty($this->getDirtyAttributes(['stored_content_id']))) {
            $storedContent = $this->storedContent;

            if ($storedContent != null) {
                $storage = Yii::$app->storage;

                if (!($file = $storage->createFile($storedContent->name.'.chunk'))) {
                    throw new Exception('Failed to create stored content chunk file.');
                }

                return $file;
            } else {
                throw new Exception('Stored content for this chunk is not found.');
            }
        } else {
            return $this->file;
        }
    }

    /**
     * Removes file from FS
     *
     * @return boolean
     */
    public function deleteFile()
    {
        $storage = Yii::$app->storage;
        return $storage->removeFile($this->file);
    }

    /**
     * Returns absolute file path
     *
     * @return string|boolean
     */
    public function getAbsoluteFilePath()
    {
        $storage = Yii::$app->storage;
        return $storage->getAbsolutePath($this->file);
    }

    /**
     * Checks if stored content chunk is locked
     *
     * @return boolean
     */
    public function isLocked()
    {
        return ($this->locked === 1);
    }

    /**
     * Locks stored content chunk
     *
     * @return void
     */
    public function lock()
    {
        $this->locked = 1;
    }

    /**
     * Unlocks stored content chunk
     *
     * @return void
     */
    public function unlock()
    {
        $this->locked = 0;
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        if ($this->validate()) {
            $this->deleteFile();
            return parent::delete();
        } else {
            return false;
        }
    }
}
