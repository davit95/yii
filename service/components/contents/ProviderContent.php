<?php

namespace service\components\contents;

use service\models\Link;
use service\models\ContentProvider;
use service\components\behaviors\AnonymousBehavior;
use service\components\behaviors\DebugBehavior;
use service\components\behaviors\DownloadBehavior;
use service\components\behaviors\StreamBehavior;
use service\components\behaviors\StoreBehavior;

/**
 * Base class for content which is served by content providers.
 * This class allows to attach download, stream and store behaviors.
 */
abstract class ProviderContent extends Content
{
    const EVENT_USE_CREDENTIALS = 'EVENT_USE_CREDENTIALS';

    protected $provider;
    protected $link;

    /**
     * Initializes object
     *
     * Initializes object. If you decide to redeclare constructor
     * in child class don't forget to call parent::__construct to
     * attach behaviors
     *
     * @param Link            $link
     * @param ContentProvider $provider
     * @return void
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

        parent::__construct($this->link->getLink());
    }

    /**
     * Returns content provider
     *
     * @return ContentProvider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Sets content provider
     *
     * @param ContentProvider $provider
     * @return void
     */
    public function setProvider(ContentProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Returns content link
     *
     * @return Link
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Sets content link
     *
     * @param Link $link
     * @return void
     */
    public function setLink(Link $link)
    {
        $this->link = $link;
    }

    /**
     * Checks if content is downloadable
     *
     * @return boolean
     */
    public function isDownloadable()
    {
        return ($this->getBehavior('downloadBehavior') !== null);
    }

    /**
     * Checks if content is streamable
     *
     * @return boolean
     */
    public function isStreamable()
    {
        return ($this->getBehavior('streamBehavior') !== null);
    }

    /**
     * Checks if content is storable
     *
     * @return boolean
     */
    public function isStorable()
    {
        return ($this->getBehavior('storeBehavior') !== null);
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
}
