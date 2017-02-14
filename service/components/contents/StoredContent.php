<?php

namespace service\components\contents;

use Yii;
use yii\base\Component;
use yii\base\Exception;
use yii\web\HttpException;
use yii\helpers\FileHelper;
use service\components\behaviors\DownloadBehavior;
use service\components\behaviors\StreamBehavior;
use service\components\events\ContentChunkSentEvent;
use service\components\events\AfterContentSentEvent;

/**
 * Component to handle sending stored content to client
 */
class StoredContent extends Component
{
    private $model;
    public $name;
    public $length;
    public $mimeType;

    private $bytesDownloaded;
    private $bytesStreamed;

    /**
     * Initializes new instance
     *
     * @param service\models\StoredContent $model
     * @return void
     */
    public function __construct(\service\models\StoredContent $model)
    {
        $this->setModel($model);

        $this->name = $model->name;
        $this->length = $model->size;
        $this->mimeType = FileHelper::getMimeTypeByExtension($this->name);

        //Add events handlers to push download journal
        $this->on(DownloadBehavior::EVENT_AFTER_DOWNLOAD, function ($event) {
            //Push records to download journal
            if ($event->bytes_sended > 0) {
                $client = \Yii::$app->service->getAppClient();
                $resp = $client->pushDownloadJournal(
                    \Yii::$app->service->instance->uid,
                    $event->user_id,
                    'stored',
                    $event->bytes_sended
                );
                if (!$resp->isSuccess()) {
                    Yii::error('Failed to push download journal record.');
                }
            }
        });

        $this->on(StreamBehavior::EVENT_AFTER_STREAM, function ($event) {
            //Push records to download journal
            if ($event->bytes_sended > 0) {
                $client = \Yii::$app->service->getAppClient();
                $resp = $client->pushDownloadJournal(
                    \Yii::$app->service->instance->uid,
                    $event->user_id,
                    'stored',
                    $event->bytes_sended
                );
                if (!$resp->isSuccess()) {
                    Yii::error('Failed to push download journal record.');
                }
            }
        });
    }

    /**
     * Sets stored content model
     *
     * @param service\models\StoredContent $model
     * @return void
     */
    private function setModel(\service\models\StoredContent $model)
    {
        if (!$model->isComplete()) {
            throw new Exception('Stored content should be complete.');
        }

        $this->model = $model;
    }

    /**
     * Returns stored content model
     *
     * @return service\models\StoredContent
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Returns stored content chunks
     *
     * @param  integer                             $start range start
     * @param  integer                             $end   range end
     * @return service\models\StoredContentChunk[]
     */
    private function getChunks($start = null, $end = null)
    {
        $chunks = $this->model->getChunks();
        if ($start !== null && $end !== null) {
            $chunks->where(['and', ['<=', 'start', $start], ['>=', 'end', $start]]);
            $chunks->orWhere(['and', ['<=', 'start', $end], ['>=', 'end', $end]]);
            $chunks->orWhere(['and', ['>=', 'start', $start], ['<=', 'end', $end]]);
        }
        $chunks->orderBy(['start' => SORT_ASC, 'end' => SORT_DESC]);
        return $chunks->all();
    }

    /**
     * Returns downloaded bytes
     *
     * @return integer
     */
    public function getBytesDownloaded()
    {
        return (int)$this->bytesDownloaded;
    }

    /**
     * Sets downloaded bytes
     *
     * @param integer $bytes
     * @return void
     */
    public function setBytesDownloaded($bytes)
    {
        $this->bytesDownloaded = $bytes;
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
     * Returns HTTP range data from request. Function is taken from yii\web\Response.
     *
     * @param  integer $fileSize
     * @return array|boolean
     */
    public function getHttpRange($fileSize)
    {
         if (isset($_SERVER['HTTP_RANGE']) && $_SERVER['HTTP_RANGE'] !== '-') {
             $range = $_SERVER['HTTP_RANGE'];
         } else if (isset($_GET['range']) && $_GET['range'] !== '-') {
             $range = 'bytes='.$_GET['range'];
         } else {
             return [0, $fileSize - 1];
         }

         if (!preg_match('/^bytes=(\d*)-(\d*)$/', $range, $matches)) {
             return false;
         }
         if ($matches[1] === '') {
             $start = $fileSize - $matches[2];
             $end = $fileSize - 1;
         } elseif ($matches[2] !== '') {
             $start = $matches[1];
             $end = $matches[2];
             if ($end >= $fileSize) {
                 $end = $fileSize - 1;
             }
         } else {
             $start = $matches[1];
             $end = $fileSize - 1;
         }
         if ($start < 0 || $start > $end) {
             return false;
         } else {
             return [$start, $end];
         }
    }

    /**
     * Sends content to browser
     *
     * Content is read from content stream and returned to client(browser) as chunked content.
     * Partial content HTTP requests are also supported.
     *
     * @return mixed
     */
    public function sendContent()
    {
        set_time_limit(0);
        ignore_user_abort(false);

        $handler = function ($owner) {
            //This should be executed only when connection is aborted.
            //We must flush statistics manualy.
            if (connection_status() == CONNECTION_ABORTED) {
                $afterContentSentEvent = new AfterContentSentEvent();
                $storedContent = $owner->getModel();
                $afterContentSentEvent->bytes_sended = $owner->getBytesDownloaded();
                $afterContentSentEvent->content_link = $storedContent->ext_url;
                $afterContentSentEvent->content_name = $storedContent->name;
                $afterContentSentEvent->content_size = $storedContent->size;
                $afterContentSentEvent->user_id = (Yii::$app->user->identity != null) ? Yii::$app->user->identity->id : null;
                $owner->trigger(DownloadBehavior::EVENT_AFTER_DOWNLOAD, $afterContentSentEvent);
                Yii::$app->statistic->flush();
            }
        };
        //Register shutdown function to handle connection abort
        register_shutdown_function($handler, $this);

        $this->bytesDownloaded = 0;

        //Trigger before download event
        $this->trigger(DownloadBehavior::EVENT_BEFORE_DOWNLOAD);

        $range = $this->getHttpRange($this->length);

        if ($range === false) {
            header('Content-Range: bytes */'.$this->length);
            throw new HttpException(416, 'Requested range not satisfiable');
        }

        list($start, $end) = $range;
        $isRangeReq = ($start !== null && $end !== null && ($start !== 0 || $end !== $this->length - 1));

        if ($isRangeReq) {
            http_response_code(206);
            header('Content-Range: bytes '.$start.'-'.$end.'/'.$this->length);
            header('Content-Length: '.($end - $start) + 1);
        } else {
            header('Content-Length: '.$this->length);
        }

        header('Content-Disposition: attachment; filename="'.rawurlencode($this->name).'"; filename*=UTF-8\'\''.rawurlencode($this->name));
        header('Content-Type: application/octet-stream');
        header('Accept-Ranges: bytes');

        if (!ob_get_level()) {
            ob_start();
        }

        //Get stored content chunks
        $chunks = ($isRangeReq) ? $this->getChunks($start, $end) : $this->getChunks();
        //Last sended chunk's end
        $lastChunkEnd = 0;

        foreach ($chunks as $chunk) {
            $params = [];
            $chunkStart = $chunk->start;
            $chunkEnd = $chunk->end;

            try {
                $content = Yii::$app->storage->getFileContent($chunk->file);
            } catch (\Exception $e) {
                $content = null;
            }

            if ($content === null) {
                Yii::error('Failed to create content for stored content chunk.');
                if (!headers_sent()) {
                    header_remove();
                    throw new HttpException(500, 'Internal server error occured. Please try again later.');
                } else {
                    exit(1);
                }
            }

            //If request is range request and chunk contains start\end set start\end position of chunk
            if ($isRangeReq) {
                if ($start > $chunk->start && $start <= $chunk->end) {
                    $chunkStart = $start;
                }
                if ($end >= $chunk->start && $end < $chunk->end) {
                    $chunkEnd = $end;
                }
            }
            //Since chunks can overlap need to check if chunk content was not already sended
            if ($lastChunkEnd >= $chunkEnd) {
                continue;
            }
            //If part of current chunk was already sent - update chunk's start position
            if ($lastChunkEnd > $chunkStart) {
                $chunkStart = $lastChunkEnd + 1;
            }

            if ($chunkStart > $chunk->start || $chunkEnd < $chunk->end) {
                $params['rangeStart'] = ($chunkStart > $chunk->start) ? $chunkStart - $chunk->start : 0;
                $params['rangeEnd'] = ($chunkEnd < $chunk->end) ? $chunk->length - 1 - ($chunk->end - $chunkEnd) : $chunk->length - 1;
            }

            $context = $content->createStreamContext();
            $stream = $content->createStream($context, 'r', $params);

            $contentChunkSentEvent = new ContentChunkSentEvent();
            $contentChunkSentEvent->stream = $stream;
            $contentChunkSentEvent->isPartial = $isRangeReq;

            try {
                while (($data = $stream->read())) {
                    $contentChunkSentEvent->content = $data;
                    $contentChunkSentEvent->bytes = strlen($data);
                    //Trigger before content chunk sent event
                    $this->trigger(DownloadBehavior::EVENT_BEFORE_CONTENT_CHUNK_SENT, $contentChunkSentEvent);
                    echo $data;
                    ob_flush();
                    flush();
                    //Trigger after content chunk sent event
                    $this->trigger(DownloadBehavior::EVENT_AFTER_CONTENT_CHUNK_SENT, $contentChunkSentEvent);
                    $this->bytesDownloaded += strlen($data);
                }
            } catch (\Exception $e) {
                @ob_end_clean();
                $stream->close();
                Yii::error($e);
                exit(1);
            }

            $stream->close();

            $lastChunkEnd = $chunk->end;
        }

        @ob_end_clean();
        //Trigger after download event
        $afterContentSentEvent = new AfterContentSentEvent();
        $storedContent = $this->getModel();
        $afterContentSentEvent->bytes_sended = $this->getBytesDownloaded();
        $afterContentSentEvent->content_link = $storedContent->ext_url;
        $afterContentSentEvent->content_name = $storedContent->name;
        $afterContentSentEvent->content_size = $storedContent->size;
        $afterContentSentEvent->user_id = (Yii::$app->user->identity != null) ? Yii::$app->user->identity->id : null;
        $this->trigger(DownloadBehavior::EVENT_AFTER_DOWNLOAD, $afterContentSentEvent);
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
                $storedContent = $owner->getModel();
                $afterContentSentEvent->bytes_sended = $owner->getBytesStreamed();
                $afterContentSentEvent->content_link = $storedContent->ext_url;
                $afterContentSentEvent->content_name = $storedContent->name;
                $afterContentSentEvent->content_size = $storedContent->size;
                $afterContentSentEvent->user_id = (Yii::$app->user->identity != null) ? Yii::$app->user->identity->id : null;
                $owner->trigger(StreamBehavior::EVENT_AFTER_STREAM, $afterContentSentEvent);
                Yii::$app->statistic->flush();
            }
        };
        //Register shutdown function to handle connection abort
        register_shutdown_function($handler, $this);

        $this->bytesStreamed = 0;

        //Trigger before download event
        $this->trigger(StreamBehavior::EVENT_BEFORE_STREAM);

        $range = $this->getHttpRange($this->length);

        if ($range === false) {
            header_remove();
            header('Content-Range: bytes */'.$this->length);
            throw new HttpException(416, 'Requested range not satisfiable');
        }

        list($start, $end) = $range;
        $isRangeReq = ($start !== null && $end !== null && ($start !== 0 || $end !== $this->length - 1));

        if ($isRangeReq) {
            http_response_code(206);
            header('Content-Range: bytes '.$start.'-'.$end.'/'.$this->length);
            header('Content-Length: '.($end - $start) + 1);
        }

        header('Content-Type: '.$this->mimeType);
        header('Accept-Ranges: bytes');

        if (!ob_get_level()) {
            ob_start();
        }

        //Get stored content chunks
        $chunks = ($isRangeReq) ? $this->getChunks($start, $end) : $this->getChunks();
        //Last sended chunk's end
        $lastChunkEnd = 0;

        foreach ($chunks as $chunk) {
            $params = [];
            $chunkStart = $chunk->start;
            $chunkEnd = $chunk->end;

            try {
                $content = Yii::$app->storage->getFileContent($chunk->file);
            } catch (\Exception $e) {
                $content = null;
            }

            if ($content === null) {
                Yii::error('Failed to create content for stored content chunk.');
                if (!headers_sent()) {
                    header_remove();
                    throw new HttpException(500, 'Internal server error occured. Please try again later.');
                } else {
                    exit(1);
                }
            }

            //If request is range request and chunk contains start\end set start\end position of chunk
            if ($isRangeReq) {
                if ($start > $chunk->start && $start <= $chunk->end) {
                    $chunkStart = $start;
                }
                if ($end >= $chunk->start && $end < $chunk->end) {
                    $chunkEnd = $end;
                }
            }
            //Since chunks can overlap need to check if chunk content was not already sended
            if ($lastChunkEnd >= $chunkEnd) {
                continue;
            }
            //If part of current chunk was already sent - update chunk's start position
            if ($lastChunkEnd > $chunkStart) {
                $chunkStart = $lastChunkEnd + 1;
            }

            if ($chunkStart > $chunk->start || $chunkEnd < $chunk->end) {
                $params['rangeStart'] = ($chunkStart > $chunk->start) ? $chunkStart - $chunk->start : 0;
                $params['rangeEnd'] = ($chunkEnd < $chunk->end) ? $chunk->length - 1 - ($chunk->end - $chunkEnd) : $chunk->length - 1;
            }

            $context = $content->createStreamContext();
            $stream = $content->createStream($context, 'r', $params);

            $contentChunkSentEvent = new ContentChunkSentEvent();
            $contentChunkSentEvent->stream = $stream;
            $contentChunkSentEvent->isPartial = $isRangeReq;

            try {
                while (($data = $stream->read())) {
                    $contentChunkSentEvent->content = $data;
                    $contentChunkSentEvent->bytes = strlen($data);
                    //Trigger before content chunk sent event
                    $this->trigger(StreamBehavior::EVENT_BEFORE_CONTENT_CHUNK_SENT, $contentChunkSentEvent);
                    echo $data;
                    ob_flush();
                    flush();
                    //Trigger after content chunk sent event
                    $this->trigger(StreamBehavior::EVENT_AFTER_CONTENT_CHUNK_SENT, $contentChunkSentEvent);
                    $this->bytesStreamed += strlen($data);
                }
            } catch (\Exception $e) {
                @ob_end_clean();
                $stream->close();
                Yii::error($e);
                exit(1);
            }

            $stream->close();

            $lastChunkEnd = $chunk->end;
        }

        @ob_end_clean();
        //Trigger after download event
        $afterContentSentEvent = new AfterContentSentEvent();
        $storedContent = $this->getModel();
        $afterContentSentEvent->bytes_sended = $this->getBytesStreamed();
        $afterContentSentEvent->content_link = $storedContent->ext_url;
        $afterContentSentEvent->content_name = $storedContent->name;
        $afterContentSentEvent->content_size = $storedContent->size;
        $afterContentSentEvent->user_id = (Yii::$app->user->identity != null) ? Yii::$app->user->identity->id : null;
        $this->trigger(StreamBehavior::EVENT_AFTER_STREAM, $afterContentSentEvent);
    }
}
