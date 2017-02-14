<?php

namespace service\components\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\Exception;
use yii\web\HttpException;
use service\components\contents\ProviderContent;
use service\components\events\ContentChunkSentEvent;
use service\components\events\AfterContentSentEvent;

/**
 * Behavior provides method to stream content
 */
class StreamBehavior extends Behavior
{
    const EVENT_BEFORE_STREAM = 'EVENT_BEFORE_STREAM';
    const EVENT_BEFORE_CONTENT_CHUNK_SENT = 'EVENT_BEFORE_STREAM_CONTENT_CHUNK_SENT';
    const EVENT_AFTER_CONTENT_CHUNK_SENT = 'EVENT_AFTER_STREAM_CONTENT_CHUNK_SENT';
    const EVENT_AFTER_STREAM = 'EVENT_AFTER_STREAM';

    private $bytesStreamed;

    /**
     * @inheritdoc
     */
    public function attach($owner)
    {
        if (!($owner instanceof ProviderContent)) {
            throw new Exception(self::className().' can be attached only to instances of '.ProviderContent::className());
        }

        parent::attach($owner);
    }

    /**
     * Returns streamed bytes
     *
     * @return integer
     */
    public function getBytesStreamed()
    {
        return $this->bytesStreamed;
    }

    /**
     * Sets streamed bytes
     *
     * @param integer $bytes
     * @return void
     */
    public function setBytesStreamed($bytes)
    {
        $this->bytesStreamed = $bytes;
    }

    /**
     * Sends content to browser as stream
     *
     * @return mixed
     */
    public function streamContent()
    {
        set_time_limit(0);
        ignore_user_abort(false);

        $handler = function ($owner) {
            //This should be executed only when connection is aborted.
            //We must flush statistics manualy.
            if (connection_status() == CONNECTION_ABORTED) {
                $afterContentSentEvent = new AfterContentSentEvent();
                $link = $owner->getLink();
                $afterContentSentEvent->bytes_sended = $owner->getBytesStreamed();
                $afterContentSentEvent->provider_id = $owner->provider->id;
                $afterContentSentEvent->provider_name = $owner->provider->name;
                $afterContentSentEvent->content_link = $link->link;
                $afterContentSentEvent->content_name = $link->content_name;
                $afterContentSentEvent->content_size = $link->content_size;
                $afterContentSentEvent->user_id = (Yii::$app->user->identity != null) ? Yii::$app->user->identity->id : null;
                $owner->trigger(StreamBehavior::EVENT_AFTER_STREAM, $afterContentSentEvent);
                Yii::$app->statistic->flush();
            }
        };
        //Register shutdown function to handle connection abort
        register_shutdown_function($handler, $this->owner);

        $this->bytesStreamed = 0;

        //Trigger before stream event
        $this->owner->trigger(self::EVENT_BEFORE_STREAM);

        $range = $this->owner->getHttpRange($this->owner->length);

        if ($range === false) {
            header('Content-Range: bytes */'.$this->owner->length);
            throw new HttpException(416, 'Requested range not satisfiable');
        }

        list($start, $end) = $range;
        $isRangeReq = ($start !== null && $end !== null && ($start !== 0 || $end !== $this->owner->length - 1));

        $context = $this->owner->createStreamContext();

        $params = [];

        if ($isRangeReq) {
            $params['rangeStart'] = (int)$start;
            $params['rangeEnd'] = (int)$end;
        }

        $stream = $this->owner->createStream($context, 'r', $params);

        if ($isRangeReq) {
            http_response_code(206);
            header('Content-Range: bytes '.$start.'-'.$end.'/'.$this->owner->length);
            header('Content-Length: '.$stream->getLength());
        }

        header('Content-Type: '.$this->owner->mimeType);
        header('Accept-Ranges: bytes');

        if (!ob_get_level()) {
            ob_start();
        }

        $contentChunkSentEvent = new ContentChunkSentEvent();
        $contentChunkSentEvent->stream = $stream;
        $contentChunkSentEvent->isPartial = $isRangeReq;

        try {
            while (($content = $stream->read())) {
                $contentChunkSentEvent->content = $content;
                $contentChunkSentEvent->bytes = strlen($content);
                //Trigger before content chunk sent event
                $this->owner->trigger(self::EVENT_BEFORE_CONTENT_CHUNK_SENT, $contentChunkSentEvent);
                echo $content;
                ob_flush();
                flush();
                //Trigger after content chunk sent event
                $this->owner->trigger(self::EVENT_AFTER_CONTENT_CHUNK_SENT, $contentChunkSentEvent);
                $this->bytesStreamed += strlen($content);
            }
        } catch (\Exception $e) {
            @ob_end_clean();
            $stream->close();
            Yii::error($e);
            exit(1);
        }

        @ob_end_clean();

        $stream->close();
        //Trigger after stream event
        $afterContentSentEvent = new AfterContentSentEvent();
        $link = $this->owner->getLink();
        $afterContentSentEvent->bytes_sended = $this->getBytesStreamed();
        $afterContentSentEvent->provider_id = $this->owner->provider->id;
        $afterContentSentEvent->provider_name = $this->owner->provider->name;
        $afterContentSentEvent->content_link = $link->link;
        $afterContentSentEvent->content_name = $link->content_name;
        $afterContentSentEvent->content_size = $link->content_size;
        $afterContentSentEvent->user_id = (Yii::$app->user->identity != null) ? Yii::$app->user->identity->id : null;
        $this->owner->trigger(self::EVENT_AFTER_STREAM, $afterContentSentEvent);
    }
}
