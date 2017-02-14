<?php

namespace service\components\contents;

use yii\base\Component;
use service\models\ContentProvider;

/**
 * Base content class
 */
abstract class Content extends Component
{
    protected $url;
    public $length;
    public $name;
    public $mimeType;

    /**
     * Initializes content object
     *
     * @return void
     */
    public function __construct($url)
    {
        $this->setUrl($url);

        $context = $this->createStreamContext();
        $stream = $this->createStream($context);

        $this->name = $stream->getContentName();
        $this->length = $stream->getLength();
        $this->mimeType = $stream->getContentMimeType();

        $stream->close();
    }

    /**
     * Returns content URL
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets content url
     *
     * @param string $url
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Creates new stream context
     *
     * @return ContentStreamContext
     */
    abstract public function createStreamContext();

    /**
     * Creates new content stream
     *
     * @param ContentStreamContext $context
     * @param string               $mode mode @see http://php.net/manual/en/function.fopen.php
     * @param array                $params parameters passed to stream
     * @return ContentStream
     */
    abstract public function createStream(ContentStreamContext $context, $mode, $params = []);

}
