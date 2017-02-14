<?php

namespace service\components\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\Exception;
use service\models\StoredContent;
use service\models\StoredContentChunk;
use service\components\FileContent;
use service\components\FtpContent;
use service\components\contents\ProviderContent;

/**
 * Behavior provides methods to store content
 */
class StoreBehavior extends Behavior
{
    const MAX_STORED_CONTENT_CHUNK_SIZE = 10485760;

    private $storedContent;
    private $storedContentChunk;
    private $storingStream;
    private $hasStoringError = false;

    /**
     * @inheritdoc
     */
    public function attach($owner)
    {
        if (!($owner instanceof ProviderContent)) {
            throw new Exception(self::className().' can be attached only to instances of '.ProviderContent::className());
        }

        parent::attach($owner);

        $owner = $this->owner;
        if (Yii::$app->service->instance->isStoringEnabled() && $this->owner->provider->isStorable()) {
            //Bind events to store content
            $this->owner->on(DownloadBehavior::EVENT_AFTER_CONTENT_CHUNK_SENT, function($event) use (&$owner) {
                $owner->storeContentChunk($event->stream, $event->content);
            });
            $this->owner->on(DownloadBehavior::EVENT_AFTER_DOWNLOAD, [$this, 'closeStoredContent']);

            $this->owner->on(StreamBehavior::EVENT_AFTER_CONTENT_CHUNK_SENT, function($event) use (&$owner) {
                $owner->storeContentChunk($event->stream, $event->content);
            });
            $this->owner->on(StreamBehavior::EVENT_AFTER_STREAM, [$this, 'closeStoredContent']);

            register_shutdown_function([$this, 'closeStoredContent']);
        }
    }

    /**
     * Opens storing content. If storing content exists it is returned otherwise new instance is created
     *
     * @return service\models\StoredContent
     */
    public function openStoredContent()
    {
        $link = $this->owner->getLink();
        if (null === ($storedContent = StoredContent::findByLink($link))) {
            $storedContent = new StoredContent();
            $storedContent->setScenario(StoredContent::SCENARIO_CREATE);
            $storedContent->name = $link->getContentName();
            $storedContent->size = $link->getContentSize();
            $storedContent->ext_url = $link->getLink();
            $storedContent->complete = 0;

            try {
                if (!$storedContent->save()) {
                    return null;
                }
            } catch (\Exception $e) {
                Yii::error($e);
                return null;
            }
        }

        return $storedContent;
    }

    /**
     * Writes content chunk to file
     *
     * @param  service\components\contents\ContentStream $stream
     * @param  string                                    $contentChunk
     * @return void
     */
    public function storeContentChunk(\service\components\contents\ContentStream $stream, $contentChunk)
    {
        $rangeStart = $stream->getParameter('rangeStart') != null ? (int)$stream->getParameter('rangeStart') : 0;
        $rangeEnd = $stream->getParameter('rangeEnd') != null ? (int)$stream->getParameter('rangeEnd') : $this->owner->length - 1;

        //Don't store content if there were errors
        if ($this->hasStoringError) {
            return;
        }

        if ($this->storedContent == null) {
            //Reset storing attributes
            $this->storedContentChunk = null;
            $this->storingStream = null;
            $this->hasStoringError = false;

            $this->storedContent = $this->openStoredContent();
            //Store content only if stored content created successfully and chunk is not already stored
            if ($this->storedContent != null && !$this->storedContent->isRangeStored($rangeStart, $rangeEnd)) {
                try {
                    $this->storedContentChunk = $this->storedContent->createChunk(true);
                } catch (\Exception $e) {
                    Yii::error($e);
                }
                if ($this->storedContentChunk != null) {
                    $this->storedContentChunk->start = $rangeStart;
                    $storage = Yii::$app->storage;
                    try {
                        $content = $storage->getFileContent($this->storedContentChunk->file);
                    } catch (\Exception $e) {
                        Yii::error($e);
                    }
                    if (isset($content)) {
                        $context = $content->createStreamContext();
                        $this->storingStream = $content->createStream($context, 'w');
                        $this->storingStream->truncate();
                    }
                }
            }
        }

        $needNewChunk = ($this->storedContentChunk != null && $this->storedContentChunk->length > self::MAX_STORED_CONTENT_CHUNK_SIZE);

        if ($needNewChunk) {
            //Calculate new chunk start
            $newChunkStart = $this->storedContentChunk->start + $this->storedContentChunk->length;
            //Close stored content chunk stream
            if ($this->storingStream != null) {
                $this->storingStream->close();
                $this->storingStream = null;
            }
            //Save content chunk
            $this->storedContentChunk->setScenario(StoredContentChunk::SCENARIO_UPDATE);
            $this->storedContentChunk->end = $this->storedContentChunk->start + $this->storedContentChunk->length - 1;
            $this->storedContentChunk->unlock();
            $this->storedContentChunk->save();
            $this->storedContentChunk = null;

            try {
                $this->storedContentChunk = $this->storedContent->createChunk(true);
            } catch (\Exception $e) {
                Yii::error($e);
            }
            if ($this->storedContentChunk != null) {
                $this->storedContentChunk->start = $newChunkStart;
                $storage = Yii::$app->storage;
                try {
                    $content = $storage->getFileContent($this->storedContentChunk->file);
                } catch (\Exception $e) {
                    Yii::error($e);
                }
                if (isset($content)) {
                    $context = $content->createStreamContext();
                    $this->storingStream = $content->createStream($context, 'w');
                    $this->storingStream->truncate();
                }
            }
        }

        if ($this->storingStream != null) {
            try {
                $bytesWritten = $this->storingStream->write($contentChunk);
                $this->hasStoringError = ($bytesWritten === false);
            } catch (\Exception $e) {
                $this->hasStoringError = true;
                Yii::error($e);
            }

            if (!$this->hasStoringError) {
                $this->storedContentChunk->length += $bytesWritten;
            }
        }
    }

    /**
     * Finalizes storing
     *
     * @return void
     */
    public function closeStoredContent()
    {
        if ($this->storingStream != null) {
            $this->storingStream->close();
            $this->storingStream = null;
        }

        if ($this->storedContentChunk != null) {
            $this->storedContentChunk->setScenario(StoredContentChunk::SCENARIO_UPDATE);
            $this->storedContentChunk->end = $this->storedContentChunk->start + $this->storedContentChunk->length - 1;
            $this->storedContentChunk->unlock();
            $this->storedContentChunk->save();
            $this->storedContentChunk = null;
        }

        if ($this->storedContent != null) {
            if ($this->storedContent->isRangeStored(0, $this->owner->length - 1)) {
                $this->storedContent->setScenario(StoredContent::SCENARIO_UPDATE);
                $this->storedContent->setComplete();
                $this->storedContent->save();
                $this->storedContent->compactChunks();
            }
            $this->storedContent = null;
        }
    }
}
