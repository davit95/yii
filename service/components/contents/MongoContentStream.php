<?php

namespace service\components\contents;

use yii\helpers\FileHelper;
use yii\base\Exception;

class MongoContentStream extends ContentStream
{
    /**
     * @inheritdoc
     */
    public function __construct($url, ContentStreamContext $context, $mode, $params = [])
    {
        $this->on(static::EVENT_AFTER_OPEN_STREAM, [$this, 'processParams']);

        parent::__construct($url, $context, $mode, $params);
    }

    /**
     * Processes params passed to stream
     *
     * @return void
     */
    public function processParams()
    {
        if ($this->getParameter('rangeStart') !== null && $this->getParameter('rangeEnd') !== null) {
            $rangeStart = (int)$this->getParameter('rangeStart');
            $rangeEnd = (int)$this->getParameter('rangeEnd');
            if ($rangeEnd < $rangeStart) {
                throw new Exception('Invalid range.');
            }
            //TODO: Use chunks to seek range start
            $chunk = min(self::CHUNK_SIZE, $rangeStart);
            $curPos = 0;
            while ($curPos < $rangeStart) {
                fread($this->getResource(), $chunk);
                $curPos = ftell($this->getResource());
                $chunk = min(self::CHUNK_SIZE, $rangeStart - $curPos);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function setMode($mode)
    {
        if ($mode !== 'r' && $mode !== 'w') {
            throw new Exception('Mongo content stream does not support simultaneous reading and writing.');
        }

        parent::setMode($mode);
    }

    /**
     * @inheritdoc
     */
    public function getLength()
    {
        if ($this->length === null) {
            /**
             * If stream represents only part of content, params rangeStart and rangeEnd are set,
             * we should calculate content length based on this params.
             */
            $stat = fstat($this->stream);
            $length = $stat['size'];
            $rangeStart = $this->getParameter('rangeStart');
            $rangeEnd = $this->getParameter('rangeEnd');
            if ($rangeStart !== null && $rangeEnd !== null) {
                $this->length = ($rangeEnd > $length) ? $length - $rangeStart + 1 : $rangeEnd - $rangeStart + 1;
            } else {
                $this->length = $length;
            }
        }

        return $this->length;
    }

    /**
     * @inheritdoc
     */
    public function getContentName()
    {
        if ($this->name === null) {
            if (($file = $this->getContext()->getOption('gridfs', 'file')) !== null) {
                $this->name = $file->metadata->originalname;
            } else if (($options = $this->getContext()->getOption('gridfs', 'options')) !== null) {
                $this->name = $options['metadata']['originalname'];
            }
        }

        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getContentMimeType()
    {
        if ($this->mimeType === null) {
            $this->mimeType = FileHelper::getMimeTypeByExtension($this->getContentName());
        }

        return $this->mimeType;
    }

    /**
     * @inheritdoc
     */
    public function read($chunk = self::CHUNK_SIZE, $offset = 0)
    {
        if (!$this->isReadable()) {
            throw new Exception('Stream is not readable.');
        }

        $stream = $this->getResource();

        $rangeStart = $this->getParameter('rangeStart');
        $rangeEnd = $this->getParameter('rangeEnd');
        if ($rangeStart !== null && $rangeEnd !== null) {
            $curPos = ftell($this->getResource());
            if ($curPos + $chunk > $rangeEnd) {
                $chunk = $rangeEnd - $curPos + 1;
            }
        }

        if (!feof($stream) && $chunk != 0) {
            return fread($stream, $chunk);
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function truncate()
    {
        return true;
    }
}
