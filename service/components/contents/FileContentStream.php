<?php

namespace service\components\contents;

use yii\helpers\FileHelper;
use yii\base\Exception;

class FileContentStream extends ContentStream
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
            fseek($this->getResource(), $rangeStart);
        }
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
            $rangeStart = $this->getParameter('rangeStart');
            $rangeEnd = $this->getParameter('rangeEnd');
            if ($rangeStart !== null && $rangeEnd !== null) {
                $length = filesize($this->getUrl());
                $this->length = ($rangeEnd > $length) ? $length - $rangeStart + 1 : $rangeEnd - $rangeStart + 1;
            } else {
                $this->length = filesize($this->getUrl());
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
            $this->name = pathinfo($this->url, PATHINFO_BASENAME);
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
            $curPos = ftell($stream);
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
        if (!$this->isWritable()) {
            throw new Exception('Stream is not writable.');
        }

        $sRes = $this->getResource();
        return ftruncate($sRes, 0) && rewind($sRes);
    }
}
