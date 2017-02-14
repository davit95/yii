<?php

namespace service\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use service\models\Link;
use service\models\StoredContent;

class ContentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'ticketAuthBehavior' => [
                'class' => 'service\components\filters\auth\TicketAuth',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        //Check if service is online
        if (!Yii::$app->service->instance->isActive()) {
            throw new HttpException(503, 'Service temporary is unavailable.');
            return false;
        }

        return parent::beforeAction($action);
    }

    /**
     * Handles file downloading
     *
     * @param  string $hash link hash
     * @return mixed
     */
    public function actionDownload($hash)
    {
        $link = Link::findByHash($hash)->one();
        if ($link !== null) {
            if (Yii::$app->service->instance->isStoringEnabled()) {
                //Check if we have stored copy of content
                $storedContent = StoredContent::findByLink($link);
                if ($storedContent != null && $storedContent->isComplete()) {
                    $content = null;
                    try {
                        $content = $storedContent->getContent();
                    } catch (\Exception $e) {
                        Yii::error($e);
                    }
                    if ($content !== null) {
                        $content->sendContent();
                    }
                }
            }
            if (!isset($content) || $content == null) {
                //No content found in storage. Use content provider.
                $provider = $link->getContentProvider();
                if ($provider !== null) {
                    if ($provider->isDownloadable()) {
                        try {
                            $content = $provider->getContent($link);
                        } catch (\Exception $e) {
                            Yii::error($e);
                            throw new HttpException(500, 'Internal server error occured. Please try again later.');
                        }
                    } else {
                        throw new HttpException(400, 'Provided content can\'t be downloaded.');
                    }
                } else {
                    throw new HttpException(400, 'Content provider not found.');
                }
                //Send content to client
                $content->sendContent();
            }
        } else {
            throw new NotFoundHttpException('Page not found.');
        }
    }

    /**
     * Handles file streaming
     *
     * @param  string $hash link hash
     * @return mixed
     */
    public function actionStream($hash)
    {
        $link = Link::findByHash($hash)->one();
        if ($link !== null) {
            if (Yii::$app->service->instance->isStoringEnabled()) {
                //Check if we have stored copy of content
                $storedContent = StoredContent::findByLink($link);
                if ($storedContent != null && $storedContent->isComplete()) {
                    $content = null;
                    try {
                        $content = $storedContent->getContent();
                    } catch (\Exception $e) {
                        Yii::error($e);
                        throw new HttpException(500, 'Internal server error occured. Please try again later.');
                    }
                    if ($content !== null) {
                        $content->streamContent();
                    }
                }
            }
            if (!isset($content) || $content == null) {
                //No content found in storage. Use content provider.
                $provider = $link->getContentProvider();
                if ($provider !== null) {
                    if ($provider->isStreamable()) {
                        try {
                            $content = $provider->getContent($link);
                        } catch (\Exception $e) {
                            Yii::error($e);
                            throw new HttpException(500, 'Internal server error occured. Please try again later.');
                        }
                    } else {
                        throw new HttpException(400, 'Provided content can\'t be streamed.');
                    }
                } else {
                    throw new HttpException(400, 'Content provider not found.');
                }
                //Send content to client
                $content->streamContent();
            }
        } else {
            throw new NotFoundHttpException('Page not found.');
        }
    }
}
