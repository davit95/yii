<?php

namespace service\components\contents;

use yii\base\Exception;
use yii\helpers\FileHelper;

class HttpContentStream extends ContentStream
{
    /**
     * @inheritdoc
     */
    public function __construct($url, ContentStreamContext $context, $mode, $params = [])
    {
        $this->on(static::EVENT_BEFORE_OPEN_STREAM, [$this, 'processParams']);

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
            $context = $this->getContext();
            $context->addOption('http', 'header', 'Range: bytes='.$this->getParameter('rangeStart').'-'.$this->getParameter('rangeEnd'));
        }
    }

    /**
     * @inheritdoc
     */
    public function setMode($mode)
    {
        if ($mode !== 'r') {
            throw new Exception('HTTP content stream supports only read mode.');
        }

        parent::setMode($mode);
    }

    /**
     * @inheritdoc
     */
    public function getLength()
    {
        if ($this->length === null) {
            $metadata = $this->getMetadata();

            if (!empty($metadata) && isset($metadata['wrapper_data'])) {
                foreach ($metadata['wrapper_data'] as $wrapperData) {
                    if (preg_match('/Content-Length: (\d+)/', $wrapperData, $matches)) {
                        if (isset($matches[1])) {
                            $this->length = (int)$matches[1];
                        }
                    }
                }
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
            $metadata = $this->getMetadata();

            if (!empty($metadata) && isset($metadata['wrapper_data'])) {
                foreach ($metadata['wrapper_data'] as $wrapperData) {
                    if (preg_match('/filename\*?=\s?([A-Za-z0-9-]+\'\'|[A-Za-z0-9-]+\")?\"?([^\"]+)\"?/', $wrapperData, $matches)) {
                        if (isset($matches[2])) {
                            $this->name = strtolower((string)$matches[2]);
                            //Check if encoding is provided
                            if (isset($matches[1])) {
                                $enc = strtolower(trim($matches[1], ' \'"*'));
                                if ($enc == 'utf-8') {
                                    //Decode content name
                                    $this->name = urldecode($this->name);
                                }
                            }
                        }
                    }
                    /*} else if (preg_match('/Location:\s?(.*)/', $wrapperData, $matches)) {
                        if (isset($matches[1])) {
                            $this->name = strtolower(pathinfo((string)$matches[1], PATHINFO_BASENAME));
                        }
                    }*/
                }
            }

            if ($this->name === null) {
                $this->name = pathinfo($this->url, PATHINFO_BASENAME);
            }

            if ($this->name === null) {
                $this->name = 'unknown';
                $ext = FileHelper::getExtensionsByMimeType($this->getContentMimeType());
                if (is_array($ext)) {
                    $this->name .= '.'.reset($ext);
                }
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
            $metadata = $this->getMetadata();

            $this->mimeType = FileHelper::getMimeTypeByExtension($this->getContentName());

            if ($this->mimeType === null) {
                if (!empty($metadata) && isset($metadata['wrapper_data'])) {
                    foreach ($metadata['wrapper_data'] as $wrapperData) {
                        if (preg_match('/Content-Type: ([a-z0-9-.]+\/[a-z0-9-.]+)/', $wrapperData, $matches)) {
                            if (isset($matches[1])) {
                                $this->mimeType = strtolower((string)$matches[1]);
                            }
                        }
                    }
                }
            }
        }

        return $this->mimeType;
    }

    /**
     * @inheritdoc
     */
    public function write($data, $offset = -1)
    {
        throw new Exception('HTTP content stream is not writable.');
    }

    /**
     * @inheritdoc
     */
    public function truncate()
    {
        throw new Exception('HTTP content stream is not writable and can not be truncated.');
    }
}
