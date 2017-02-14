<?php

namespace service\components\contents;

use yii\base\Exception;
use yii\helpers\FileHelper;
use \GuzzleHttp\Client;
use \GuzzleHttp\Cookie\SetCookie;
use \GuzzleHttp\Cookie\CookieJar;
use \phpseclib\Crypt\AES;
use service\models\Link;
use service\models\ContentProvider;
use service\components\behaviors\AnonymousBehavior;
use service\components\behaviors\DebugBehavior;
use service\components\behaviors\DownloadBehavior;
use service\components\behaviors\StreamBehavior;
use service\components\behaviors\StoreBehavior;
use service\components\events\ContentChunkSentEvent;
use service\components\events\AfterContentSentEvent;

/**
 * mega.nz content
 *
 * Useful information:
 * - http://julien-marchand.fr/blog/using-mega-api-with-python-examples/
 * - http://julien-marchand.fr/blog/using-the-mega-api-how-to-download-a-public-file-or-a-file-you-know-the-key-without-logging-in/
 * - https://github.com/meganz/webclient/tree/master/js
 */
class MegaNz extends HttpContent
{
    const MEGA_API_URL = 'https://eu.api.mega.co.nz/cs?domain=meganz&lang=en';

    private $proxy;
    private $userAgent;
    private $decryptKey;
    private $iv;
    private $info;

    /**
     * @inheritdoc
     */
    public function __construct(Link $link, ContentProvider $provider)
    {
        $this->setProvider($provider);
        $this->setLink($link);

        //Attach behaviors
        $provider = $this->getProvider();

        if ($provider->isDownloadable()) {
            $this->attachBehavior('downloadBehavior', DownloadBehavior::className());

            //Add event handler to push download journal
            $this->on(DownloadBehavior::EVENT_AFTER_DOWNLOAD, function ($event) {
                //Push records to download journal
                if ($event->bytes_sended > 0) {
                    $client = \Yii::$app->service->getAppClient();
                    $resp = $client->pushDownloadJournal(
                        \Yii::$app->service->instance->uid,
                        $event->user_id,
                        $event->provider_name,
                        $event->bytes_sended
                    );
                    if (!$resp->isSuccess()) {
                        Yii::error('Failed to push download journal record.');
                    }
                }
            });
        }
        if ($provider->isStreamable()) {
            $this->attachBehavior('streamBehavior', StreamBehavior::className());

            //Add event handler to push download journal
            $this->on(StreamBehavior::EVENT_AFTER_STREAM, function ($event) {
                //Push records to download journal
                if ($event->bytes_sended > 0) {
                    $client = \Yii::$app->service->getAppClient();
                    $resp = $client->pushDownloadJournal(
                        \Yii::$app->service->instance->uid,
                        $event->user_id,
                        $event->provider_name,
                        $event->bytes_sended
                    );
                    if (!$resp->isSuccess()) {
                        Yii::error('Failed to push download journal record.');
                    }
                }
            });            
        }
        if ($provider->isStorable()) {
            $this->attachBehavior('storeBehavior', StoreBehavior::className());
        }

        $this->attachBehavior('debugBehavior', DebugBehavior::className());
        $this->attachBehavior('anonymousBehavior', AnonymousBehavior::className());

        $url = $this->link->getLink();

        //Set decryption key and iv
        preg_match('/https:\/\/mega\.nz\/\#\![a-zA-Z0-9_-]+\!([a-zA-Z0-9_-]+)/', $url, $matches);
        if (!isset($matches[1])) {
            throw new Exception('Invalid URL. No key found.');
        }

        $key = $this->base64ToA32($matches[1]);
        $iv = array_merge(array_slice($key, 4, 2), array(0, 0));
        $key = [$key[0] ^ $key[4], $key[1] ^ $key[5], $key[2] ^ $key[6], $key[3] ^ $key[7]];

        $this->setDecryptKey($this->a32ToStr($key));
        $this->setIv($this->a32ToStr($iv));

        //Get content info
        $info = $this->getInfo();

        if (!($info['size'] || $info['url'] || $info['name'])) {
            throw new Exception('Invalid file info.');
        }

        $this->setUrl($info['url']);

        $this->name = $info['name'];
        $this->length = $info['size'];
        $this->mimeType = FileHelper::getMimeTypeByExtension($this->name);
    }

    /**
     * Array of 32-bit words to string (big endian)
     *
     * @param  array $data
     * @return string
     */
    private function a32ToStr($data)
    {
        return call_user_func_array('pack', array_merge(array('N*'), $data));
    }

    /**
     * String to 32-bit array
     *
     * @param  string $data
     * @return array
     */
    private function strToA32($data)
    {
        $data = str_pad($data, 4 * ceil(strlen($data) / 4), "\0");
        return array_values(unpack('N*', $data));
    }

    /**
     * Unsubstitute standard base64 special characters, restore padding.
     *
     * @param  tring $data
     * @return string
     */
    private function base64UrlDecode($data)
    {
        $data .= substr('==', (2 - strlen($data) * 3) % 4);
        $data = str_replace(array('-', '_', ','), array('+', '/', ''), $data);
        return base64_decode($data);
    }

    /**
     * Base64 encoded string to 32-bit array
     *
     * @param  string $data
     * @return array
     */
    private function base64ToA32($data)
    {
        return $this->strToA32($this->base64UrlDecode($data));
    }

    /**
     * Returns user agent string
     *
     * @return string
     */
    private function getUserAgent()
    {
        if ($this->userAgent === null) {
            $this->userAgent = $this->getRandomUserAgent();
        }

        return $this->userAgent;
    }

    /**
     * Returns proxy URL
     *
     * @return string
     */
    private function getProxy()
    {
        if ($this->proxy === null) {
            $this->proxy = $this->getRandomProxy();
        }

        return $this->proxy;
    }

    /**
     * Returns HTTP client
     *
     * @return \GuzzleHttp\Client
     */
     private function getHttpClient()
     {
         $client = new Client();

         $instance = \Yii::$app->service->instance;
         if ($instance->isProxyEnabled() && $this->provider->isUsingProxy()) {
             $proxy = $this->getProxy();
             if ($proxy) {
                 $client->setDefaultOption('proxy', [
                     'http' => $proxy->url,
                     'https' => $proxy->url
                 ]);
                 if ($proxy->reqAuth) {
                     $client->setDefaultOption('headers', [
                         'Proxy-Authorization' => "Basic {$proxy->usrpwd}"
                     ]);
                 }
             }
         }

         return $client;
     }

    /**
     * Returns decryption key
     *
     * Returns decryption key.
     * This key is used to decrypt content info and content chunks.
     *
     * @return string
     */
    private function getDecryptKey()
    {
        return $this->decryptKey;
    }

    /**
     * Sets decryption key
     *
     * Sets decryption key.
     * This key is used to decrypt content info and content chunks.
     *
     * @param string $key
     */
    private function setDecryptKey($key)
    {
        $this->decryptKey = $key;
    }

    /**
     * Returns iv (init vector)
     *
     * Returns iv.
     * Iv is used to decrypt content info and content chunks.
     *
     * @return string
     */
    private function getIv()
    {
        return $this->iv;
    }

    /**
     * Sets iv (init vector)
     *
     * Sets decryption key.
     * This key is used to decrypt content info and content chunks.
     *
     * @param string $key
     */
    private function setIv($iv)
    {
        $this->iv = $iv;
    }

    /**
     * Returns content info
     *
     * @return array
     */
    private function getInfo()
    {
        if ($this->info == null) {
            $url = $this->link->getLink();

            //Get decryption key and iv
            preg_match('/https:\/\/mega\.nz\/\#\!([a-zA-Z0-9_]+)\![a-zA-Z0-9_]+/', $url, $matches);
            if (!isset($matches[1])) {
                throw new Exception('Invalid URL. No file id found.');
            }

            $fileId = $matches[1];

            //Fetch file info using MEGA API
            $client = $this->getHttpClient();

            $postBody = array(
                array (
                    'a' => 'g',
                    'g' => 1,
                    'ssl' => 0,
                    'p' => $fileId
                )
            );

            $req = $client->createRequest('POST', self::MEGA_API_URL, ['verify' => false, 'body' => json_encode($postBody)]);
            $req->setHeader('User-Agent', $this->getUserAgent());
            $resp = $client->send($req);
            $info = json_decode((string)$resp->getBody(), true);

            if ($info == null) {
                throw new Exception('Failed to get file info.');
            }
            $info = reset($info);

            $attr = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->getDecryptKey(), $this->base64UrlDecode($info['at']), MCRYPT_MODE_CBC, "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0");
            $attr = trim($attr);
            if (substr($attr, 0, 6) == 'MEGA{"') {
                $attr = json_decode(substr($attr, 4), true);
            }

            $this->info['size'] = (int)$info['s'];
            $this->info['url'] = $info['g'];
            $this->info['name'] = isset($attr['n']) ? $attr['n'] : null;
        }

        return $this->info;
    }

    /**
     * @inheritdoc
     */
    public function createStreamContext()
    {
        $context = new HttpContentStreamContext();
        $context->setOption('http', 'method', 'GET');
        $context->setOption('http', 'user_agent', $this->getUserAgent());
        //Set proxy
        $instance = \Yii::$app->service->instance;
        if ($instance->isProxyEnabled() && $this->provider->isUsingProxy()) {
            $proxy = $this->getProxy();
            if ($proxy) {
                $context->setOption('http', 'proxy', $proxy->url);
                if ($proxy->reqAuth) {
                    $context->addOption('http', 'header', "Proxy-Authorization: Basic {$proxy->usrpwd}");
                }
            }
        }

        return $context;
    }

    /**
     * Sends content to browser
     *
     * Sends content to browser.
     * Can't use method defined in download behavior
     * due content is encrypted and should be read
     * in specific way.
     * For more description @see service\behaviors\DownloadBehavior
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
                $link = $owner->getLink();
                $afterContentSentEvent->bytes_sended = $owner->getBytesDownloaded();
                $afterContentSentEvent->provider_id = $owner->provider->id;
                $afterContentSentEvent->provider_name = $owner->provider->name;
                $afterContentSentEvent->content_link = $link->link;
                $afterContentSentEvent->content_name = $link->content_name;
                $afterContentSentEvent->content_size = $link->content_size;
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

        //Get MEGA content chunks
        $chunks = array();
        $p = $pp = 0;

        for ($i = 1; $i <= 8 && $p < $this->length - $i * 0x20000; $i++) {
            $chunks[$p] = $i * 0x20000;
            $pp = $p;
            $p += $chunks[$p];
        }

        while ($p < $this->length) {
            $chunks[$p] = 0x100000;
            $pp = $p;
            $p += $chunks[$p];
        }

        $chunks[$pp] = ($this->length - $pp);
        if (!$chunks[$pp]) {
            unset($chunks[$pp]);
        }
        ksort($chunks);

        if (empty($chunks)) {
            throw new Exception('Failed to get content chunks.');
        }

        $decryptor = new AES(\phpseclib\Crypt\Base::MODE_CTR);
        $decryptor->setKey($this->getDecryptKey());
        $decryptor->setIV($this->getIv());
        $decryptor->enableContinuousBuffer();

        if ($isRangeReq) {
            http_response_code(206);
            header('Content-Range: bytes '.$start.'-'.$end.'/'.$this->length);
            header('Content-Length: '.$end - $start);
        } else {
            header('Content-Length: '.$this->length);
        }

        header('Content-Disposition: attachment; filename="'.$this->name.'"');
        header('Content-Type: application/octet-stream');
        header('Accept-Ranges: bytes');

        if (!ob_get_level()) {
            ob_start();
        }

        $context = $this->createStreamContext();
        $contentChunkSentEvent = new ContentChunkSentEvent();
        $contentChunkSentEvent->isPartial = $isRangeReq;

        foreach ($chunks as $chunkStart => $chunkLength) {
            $chunkEnd = $chunkStart + $chunkLength - 1;

            if ($isRangeReq) {
                /**
                 * In case of range request check if chunk contains
                 * required range.
                 */
                if ($end < $chunkStart || $start > $chunkEnd) {
                    continue;
                }
            }

            $contentChunk = null;

            $params['rangeStart'] = $chunkStart;
            $params['rangeEnd'] = $chunkEnd;

            $stream = $this->createStream($context, 'r', $params);

            try {
                while (($content = $stream->read())) {
                    if ($contentChunk === null) {
                        $contentChunk = $content;
                    } else {
                        $contentChunk .= $content;
                    }
                }
            } catch (\Exception $e) {
                ob_end_clean();
                $stream->close();
                \Yii::error($e);
                exit(1);
            }

            $contentChunk = $decryptor->decrypt($contentChunk);

            if ($isRangeReq) {
                $from = 0;
                $len = null;

                $rangeStart = $stream->getParameter('rangeStart');
                $rangeEnd = $stream->getParameter('rangeEnd');

                if ($start >= $rangeStart && $start <= $rangeEnd) {
                    $from = $start - $rangeStart;
                }
                if ($end <= $rangeEnd && $end >= $rangeStart) {
                    $len = $end - $from + 1;
                }

                $contentChunk = ($len !== null) ? substr($contentChunk, $from, $len) : substr($contentChunk, $from);
            }

            $contentChunkSentEvent->stream = $stream;
            $contentChunkSentEvent->content = $contentChunk;
            $contentChunkSentEvent->bytes = strlen($contentChunk);

            //Trigger before content chunk sent event
            $this->owner->trigger(DownloadBehavior::EVENT_BEFORE_CONTENT_CHUNK_SENT, $contentChunkSentEvent);

            echo $contentChunk;
            ob_flush();
            flush();

            //Trigger after content chunk sent event
            $this->owner->trigger(DownloadBehavior::EVENT_AFTER_CONTENT_CHUNK_SENT, $contentChunkSentEvent);

            $stream->close();

            $this->bytesDownloaded += strlen($contentChunk);
        }

        @ob_end_clean();

        //Trigger after download event
        $afterContentSentEvent = new AfterContentSentEvent();
        $link = $this->getLink();
        $afterContentSentEvent->bytes_sended = $this->getBytesDownloaded();
        $afterContentSentEvent->provider_id = $this->provider->id;
        $afterContentSentEvent->provider_name = $this->provider->name;
        $afterContentSentEvent->content_link = $link->link;
        $afterContentSentEvent->content_name = $link->content_name;
        $afterContentSentEvent->content_size = $link->content_size;
        $afterContentSentEvent->user_id = (\Yii::$app->user->identity != null) ? \Yii::$app->user->identity->id : null;
        $this->trigger(DownloadBehavior::EVENT_AFTER_DOWNLOAD, $afterContentSentEvent);
    }
}
