<?php
/**
 * Stored content controller
 *
 * @package service\api
 * @author Yura Tovt <yura.tovt@ffflabel.com>
 */

namespace service\modules\api\v1\controllers;

use Yii;
use yii\web\Response;
use yii\rest\Controller;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use service\models\StoredContent;

/**
 * Handles stored content
 */
class StoredContentController extends Controller
{
    /**
     * @inheritdoc
     * @ignore
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
            'compositeAuth' => [
                'class' => '\yii\filters\auth\CompositeAuth',
                'authMethods' => [
                    'service\components\filters\auth\HttpBasicAuth',
                    'service\components\filters\auth\HttpBearerAuth',
                ],
            ],
            'accessControl' => [
                'class' => '\yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $user = Yii::$app->user->identity;
                            return (($user !== null) && ($user->isAdmin()));
                        }
                    ]
                ]
            ],
            'verbFilter' => [
                'class' => VerbFilter::className(),
                'actions' => $this->verbs(),
            ],
        ];
    }

    /**
     * @inheritdoc
     * @ignore
     */
    public function verbs()
    {
        return [
            'index' => ['get'],
            'get' => ['get'],
            'get-chunks' => ['get'],
            'create' => ['post'],
            'update' => ['put'],
            'delete' => ['delete']
        ];
    }

    /**
     * Renders list of stored content
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/stored-content/index
     *
     * Example of response:
     * ```json
     * {
     *  "total": 50,
     *  "count": 10,
     *  "storedContents": [...]
     * }
     * ```
     *
     * @param integer $offset
     * @param integer $limit
     * @return mixed
     */
    public function actionIndex($offset = 0, $limit = 0)
    {
        $storedContents = StoredContent::find();

        $total = $storedContents->count();

        if ($offset > 0) {
            $storedContents->offset($offset);
        }

        if ($limit > 0) {
            $storedContents->limit($limit);
        }

        $storedContents = $storedContents->all();

        return [
            'total' => $total,
            'count' => count($storedContents),
            'storedContents' => $storedContents
        ];
    }

    /**
     * Returns stored content by id
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/stored-content/get/1
     *
     * Example of response:
     * ```json
     * {
     *  "id": 3,
     *  "name": "video_file_lg.mp4",
     *  "size": 31491130,
     *  "extUrl": "http://www35.zippyshare.com/v/2Qh2LBdA/file.html",
     *  "complete": 1,
     *  "created": 1478089587
     * }
     * ```
     *
     * @param  integer $id
     * @return mixed
     * @api
     */
    public function actionGet($id)
    {
        $response = Yii::$app->response;

        $storedContent = StoredContent::findOne($id);

        if ($storedContent !== null) {
            return $storedContent;
        } else {
            $response->setStatusCode(404);
            return [
                'message' => 'Stored content not found.'
            ];
        }
    }

    /**
     * Returns stored content chunks by stored content id
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/stored-content/get-chunks/1
     *
     * Example of response:
     * ```json
     * {
     *  "count": 1,
     *  "chunks": [
     *   {
     *    "id": 19,
     *    "stored_content_id": 3,
     *    "file": "plg-5819dba5cd9757.22381576/video_file_lg.mp4.chunk",
     *    "start": 0,
     *    "end": 4544564,
     *    "length": 4544565,
     *    "locked": 0,
     *    "created": 1478089637
     *   }
     *  ]
     * }
     * ```
     *
     * @param  integer $id
     * @return mixed
     * @api
     */
    public function actionGetChunks($id)
    {
        $response = Yii::$app->response;

        $storedContent = StoredContent::findOne($id);

        if ($storedContent !== null) {
            return [
                'count' => count($storedContent->chunks),
                'chunks' => $storedContent->chunks
            ];
        } else {
            $response->setStatusCode(404);
            return [
                'message' => 'Stored content not found.'
            ];
        }
    }

    /**
     * Create new stored content
     *
     * Method: POST
     *
     * Call example: http://svc.plg.com/api/stored-content/create
     *
     * Data: name, size, ext_url, complete
     *
     * Example of response:
     * ```json
     * {
     *  "id": 3,
     *  "name": "video_file_lg.mp4",
     *  "size": 31491130,
     *  "extUrl": "http://www35.zippyshare.com/v/2Qh2LBdA/file.html",
     *  "complete": 1,
     *  "created": 1478089587
     * }
     * ```
     *
     * @return mixed
     * @api
     */
    public function actionCreate()
    {
        $response = Yii::$app->response;

        $storedContent = new StoredContent();
        $storedContent->setScenario(StoredContent::SCENARIO_CREATE);
        $storedContent->load(Yii::$app->request->post(), '');

        if ($storedContent->save()) {
            return $storedContent;
        } else {
            $response->setStatusCode(400);
            return [
                'message' => 'Failed to create new stored content.',
                'errors' => $storedContent->getErrors()
            ];
        }
    }

    /**
     * Updates existing stored content
     *
     * Method: PUT
     *
     * Call example: http://svc.plg.com/api/stored-content/update/1
     *
     * Data: name, size, ext_url, complete
     *
     * Example of response:
     * ```json
     * {
     *  "id": 3,
     *  "name": "video_file_lg.mp4",
     *  "size": 31491130,
     *  "extUrl": "http://www35.zippyshare.com/v/2Qh2LBdA/file.html",
     *  "complete": 1,
     *  "created": 1478089587
     * }
     * ```
     *
     * @param  integer $id
     * @return mixed
     * @api
     */
    public function actionUpdate($id)
    {
        $response = Yii::$app->response;

        $storedContent = StoredContent::findOne($id);

        if ($storedContent != null) {
            $storedContent->setScenario(StoredContent::SCENARIO_UPDATE);
            $storedContent->load(Yii::$app->request->post(), '');

            if ($storedContent->save()) {
                return $storedContent;
            } else {
                $response->setStatusCode(400);
                return [
                    'message' => 'Failed to update stored content.',
                    'errors' => $storedContent->getErrors()
                ];
            }
        } else {
            $response->setStatusCode(404);
            return [
                'message' => 'Stored content not found.'
            ];
        }
    }

    /**
     * Delete existing stored content
     *
     * Method: DELETE
     *
     * Call example: http://svc.plg.com/api/stored-content/delete/1
     *
     * Example of response:
     * ```json
     * {
     *  "message": "Stored content deleted successfully."
     * }
     * ```
     *
     * @param integer $id
     * @return mixed
     * @api
     */
    public function actionDelete($id)
    {
        $response = Yii::$app->response;

        $storedContent = StoredContent::findOne($id);

        if ($storedContent != null) {
            $storedContent->setScenario(StoredContent::SCENARIO_DELETE);

            if ($storedContent->delete()) {
                return [
                    'message' => 'Stored content deleted successfully.'
                ];
            } else {
                $storedContent->setStatusCode(400);
                return [
                    'message' => 'Failed to delete stored content.',
                    'errors' => $storedContent->getErrors()
                ];
            }
        } else {
            $response->setStatusCode(404);
            return [
                'message' => 'Stored content not found.'
            ];
        }
    }
}
