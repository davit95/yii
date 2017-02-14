<?php

namespace service\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;

/**
 * Model for stored content
 */
class StoredContent extends ActiveRecord
{
    const SCENARIO_CREATE = 'CREATE';
    const SCENARIO_UPDATE = 'UPDATE';
    const SCENARIO_DELETE = 'DELETE';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stored_contents}}';
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
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Stored content id',
            'name' => 'Name',
            'size' => 'Size',
            'ext_url' => 'External url',
            'complete' => 'Complete',
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
            ['name', 'required'],
            ['name', 'string', 'min' => 1, 'max' => 255],
            ['size', 'required'],
            ['size', 'number'],
            ['ext_url', 'required'],
            ['ext_url', 'string', 'min' => 1, 'max' => 500],
            ['complete', 'boolean', 'trueValue' => 1, 'falseValue' => 0]
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'size' => 'size',
            'extUrl' => 'ext_url',
            'complete' => 'complete',
            'created' => 'created'
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        //TODO: Disallow updating name, size, ext_url fields
        return [
            self::SCENARIO_CREATE => ['name', 'size', 'ext_url', 'complete'],
            self::SCENARIO_UPDATE => ['id', 'name', 'size', 'ext_url', 'complete'],
            self::SCENARIO_DELETE => ['id']
        ];
    }

    /**
     * Returns stored content for link
     *
     * @param  Link   $link
     * @return StoredContent|null
     */
    public static function findByLink(Link $link)
    {
        return static::find()->where(['ext_url' => $link->getLink()])
            ->andWhere(['name' => $link->content_name])
            ->andWhere(['size' => $link->content_size])
            ->one();
    }

    /**
     * Returns content chunks
     *
     * @return service\models\StoredContentChunk[]
     */
    public function getChunks()
    {
        return $this->hasMany(StoredContentChunk::className(), ['stored_content_id' => 'id']);
    }

    /**
     * Creates new stored content chunk
     *
     * @param  boolean   $lock
     * @return service\models\StoredContentChunk
     */
    public function createChunk($lock = false)
    {
        if (!$this->isNewRecord) {
            $chunk = new StoredContentChunk();
            $chunk->setScenario(StoredContentChunk::SCENARIO_CREATE);
            $chunk->start = 0;
            $chunk->end = 0;
            $chunk->length = 0;

            if ($lock) {
                $chunk->lock();
            }

            $chunk->link('storedContent', $this);

            return $chunk;
        } else {
            throw new Exception('Stored content should be saved before chunks can be created.');
        }
    }

    /**
     * Compacts chunks.
     *
     * Removes chunks which have 0 length.
     * Removes chunks which are part of other chunks.
     *
     * @return void
     */
    public function compactChunks()
    {
        $redurant = [];

        foreach ($this->getChunks()->where(['locked' => 0])->each() as $chunk) {
            //Remove chunks with zero length and invalid chunks
            if ($chunk->length == 0 || $chunk->end >= $this->size) {
                $redurant[] = $chunk->id;
            }
            //Remove redurant chunks
            foreach ($this->chunks as $_chunk) {
                if ($chunk->id != $_chunk->id && $chunk->start >= $_chunk->start && $chunk->end <= $_chunk->end) {
                    $redurant[] = $chunk->id;
                }
            }
        }

        $this->deleteChunks(['id' => $redurant]);
    }

    /**
     * Returns content
     *
     * @return service\components\contents\StoredContent
     */
    public function getContent()
    {
        return new \service\components\contents\StoredContent($this);
    }

    /**
     * Checks if given range of bytes is saved
     *
     * @param  integer  $start
     * @param  integer  $end
     * @return boolean
     */
    public function isRangeStored($start, $end)
    {
        $query = $this->getChunks();
        if ($start !== null && $end !== null) {
            $query->where(['and', ['<=', 'start', $start], ['>=', 'end', $start]]);
            $query->orWhere(['and', ['<=', 'start', $end], ['>=', 'end', $end]]);
            $query->orWhere(['and', ['>=', 'start', $start], ['<=', 'end', $end]]);
        }
        $query->orderBy(['start' => SORT_ASC, 'end' => SORT_DESC]);
        $chunks = $query->asArray(true)->all();

        if (empty($chunks)) {
            return false;
        }

        $rangeStart = $chunks[0]['start'];
        $rangeEnd = $chunks[0]['end'];

        if ($rangeStart > $start) {
            //No start position found
            return false;
        }

        for ($i = 1; $i < count($chunks); $i++) {
            if ($chunks[$i]['start'] <= $rangeEnd + 1 && $rangeEnd + 1 <= $chunks[$i]['end']) {
                $rangeEnd = $chunks[$i]['end'];
            }
        }

        if ($rangeEnd < $end) {
            //No end position found
            return false;
        }

        return true;
    }

    /**
     * Checks if stored content is complete
     *
     * @return boolean
     */
    public function isComplete()
    {
        return ($this->complete === 1);
    }

    /**
     * Marks stored content as complete
     *
     * @return void
     */
    public function setComplete()
    {
        $this->complete = 1;
    }

    /**
     * Deletes stored content chunks
     *
     * @param  array $conditions
     * @return void
     */
    private function deleteChunks($conditions = [])
    {
        foreach ($this->getChunks()->where($conditions)->each() as $chunk) {
            $chunk->deleteFile();
        }
        StoredContentChunk::deleteAll($conditions);
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        if ($this->validate()) {
            $this->deleteChunks();
            return parent::delete();
        } else {
            return false;
        }
    }
}
