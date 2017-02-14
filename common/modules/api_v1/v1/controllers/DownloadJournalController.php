<?php

namespace common\modules\api_v1\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use common\models\User;
use common\models\DownloadJournal;

/**
 * Download journal controller
 */
class DownloadJournalController extends Controller
{
    /**
     * @inheritdocs
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml' => Response::FORMAT_XML,
                ],
            ],
            'verbFilter' => [
                'class' => VerbFilter::className(),
                'actions' => $this->verbs(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function verbs()
    {
        return [
            'push' => ['post'],
        ];
    }

    /**
     * Adds new record to download journal
     *
     * @return mixed
     */
    public function actionPush()
    {
        $response = Yii::$app->response;

        $rec = new DownloadJournal();
        $rec->load(Yii::$app->request->post(), '');

        if ($rec->save()) {
            return [
                'success' => true,
                'message' => 'Download journal record created.'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to create download journal record.'
            ];
        }
    }
}
