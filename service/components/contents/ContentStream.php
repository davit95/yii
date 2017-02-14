<?php

namespace service\components\contents;

use yii\base\Component;
use yii\base\Exception;

abstract class ContentStream extends Component
{
    const EVENT_BEFORE_OPEN_STREAM = 'EVENT_BEFORE_OPEN_STREAM';
    const EVENT_AFTER_OPEN_STREAM = 'EVENT_AFTER_OPEN_STREAM';

    const CHUNK_SIZE = 1048576;

    protected $url;
    protected $context;
    protected $mode;
    protected $params;
    protected $stream;
    protected $metadata;
    protected $name;
    protected $length;
    protected $mimeType;

    /**
     * Create content stream
     *
     * Create content stream.
     * [[mode]] should be one of supported by fopen function.
     * [[params]] is array of parameters which may be used by content stream.
     * Supported parameters:
     *
     * - rangeStart - determinates start postition in bytes (should be used with rangeEnd param).
     * Used to create stream which represents part of content.
     * - rangeEnd - determinates end postition in bytes (should be used with rangeStart param).
     * Used to create stream which represents part of content.
     *
     * Before stream is opened EVENT_BEFORE_OPEN_STREAM is triggered.
     *
     * @param string               $url
     * @param ContentStreamContext $context
     * @param string               $mode mode @see http://php.net/manual/en/function.fopen.php
     * @param array                $param parameters passed to stream
     * @param resource             $context
     */
    public function __construct($url, ContentStreamContext $context, $mode, $params = [])
    {
        $this->setUrl($url);
        $this->setMode($mode);
        $this->setParameters($params);
        $this->setContext($context);

        $this->trigger(self::EVENT_BEFORE_OPEN_STREAM);

        $this->stream = @fopen($this->url, $this->mode, false, $this->getContext()->getResource());

        if ($this->stream === false) {
            throw new Exception('Failed to open stream.');
        }

        $this->trigger(self::EVENT_AFTER_OPEN_STREAM);
    }

    /**
     * Returns stream url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets stream url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Returns stream context instance
     *
     * @return ContentStreamContext
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Sets stream context
     *
     * @param ContentStreamContext $context
     */
    public function setContext(ContentStreamContext $context)
    {
        $this->context = $context;
    }

    /**
     * Returns mode in which stream is opened
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Sets stream mode
     *
     * @param string $mode
     */
    public function setMode($mode)
    {
        if (!in_array($mode, ['r', 'r+', 'w', 'w+', 'a', 'a+', 'x', 'x+', 'c', 'c+'])) {
            throw new Exception('Unsupported mode.');
        }

        $this->mode = $mode;
    }

    /**
     * Returns param value by name
     *
     * @param  string $name
     * @return mixed
     */
    public function getParameter($name)
    {
        if (!isset($this->params[$name])) {
            return null;
        }

        return $this->params[$name];
    }

    /**
     * Sets param value
     *
     * @param string $name
     * @param mixed  $value
     * @return void
     */
    public function setParameter($name, $value)
    {
        if (!is_array($this->params)) {
            $this->params = [];
        }

        $this->params[$name] = $value;
    }

    /**
     * Sets params
     *
     * @param array $params
     * @return void
     */
    public function setParameters(array $params)
    {
        foreach ($params as $name => $value) {
            $this->setParameter($name, $value);
        }
    }

    /**
     * Returns current stream resource
     *
     * @return resource
     */
    public function getResource()
    {
        return $this->stream;
    }

    /**
     * Returns stream meta data
     *
     * @return array
     */
    public function getMetadata()
    {
        if ($this->metadata === null) {
            $this->metadata = stream_get_meta_data($this->getResource());
        }

        return $this->metadata;
    }

    /**
     * Return content length (size) in bytes
     *
     * @return integer
     */
    abstract public function getLength();

    /**
     * Returns content name
     *
     * @return string
     */
    abstract public function getContentName();

    /**
     * Returns MIME type of content
     *
     * @return string
     */
    abstract public function getContentMimeType();

    /**
     * Checks if stream is readable
     *
     * @return boolean
     */
    public function isReadable()
    {
        return in_array($this->getMode(), ['r', 'r+', 'w+', 'a+', 'x+', 'c+']);
    }

    /**
     * Checks if stream is writable
     *
     * @return boolean
     */
    public function isWritable()
    {
        return in_array($this->getMode(), ['r+', 'w', 'w+', 'a', 'a+', 'x', 'x+', 'c', 'c+']);
    }

    /**
     * Returns [[chunk]] bytes from stream. If end is reached returns false.
     *
     * @param  integer  $chunk
     * @param  integer $offset
     * @return string|boolean
     */
    public function read($chunk = self::CHUNK_SIZE, $offset = 0)
    {
        if (!$this->isReadable()) {
            throw new Exception('Stream is not readable.');
        }

        $stream = $this->getResource();

        if (!feof($stream) && $chunk != 0) {
            return fread($stream, $chunk);
        } else {
            return false;
        }
    }

    /**
     * Writes data to stream
     *
     * @param  string  $data   data to write
     * @param  integer $offset
     * @return integer|boolean
     */
    public function write($data, $offset = -1)
    {
        if (!$this->isWritable()) {
            throw new Exception('Stream is not writable.');
        }

        $stream = $this->getResource();

        if ($offset != -1) {
            if (fseek($stream, 0, $offset) == -1) {
                return 0;
            }
        }

        return fwrite($stream, $data);
    }

    /**
     * Truncates content stream to zero length
     *
     * @return boolean
     */
    abstract public function truncate();

    /**
     * Close stream
     *
     * @return void
     */
    public function close()
    {
        if ($this->stream !== null) {
            fclose($this->stream);
        }
    }
}
