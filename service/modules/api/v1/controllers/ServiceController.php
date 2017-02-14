<?php
/**
 * Service controller
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

/**
 * Handles download requests.
 */
class ServiceController extends Controller
{
    /**
     * @inheritdocs
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
            'ping' => ['get'],
            'get-connections-number' => ['get'],
            'set-status' => ['put'],
            'set-storing' => ['put'],
            'set-use-proxy' => ['put']
        ];
    }

    /**
     * Renders "ping" response
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/service/ping
     *
     * Example of response:
     * ```json
     * {
     *  "id": 1,
     *  "uid": "gXP9B9qd4Y",
     *  "name": "plg.svc.01",
     *  "storing_enabled": 1,
     *  "status": "ACTIVE"
     * }
     * ```
     *
     * @return mixed
     * @api
     */
    public function actionPing()
    {
        $response = Yii::$app->response;
        $instance = Yii::$app->service->instance;

        if ($instance != null) {
            return $instance;
        } else {
            $response->setStatusCode(404);
            return [
                'message' => 'Service instance not found.'
            ];
        }
    }

    /**
     * Returns current number of connections
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/service/get-connections-number
     *
     * Example of response:
     * ```json
     * {
     *  "uid": "gXP9B9qd4Y",
     *  "connections_number": 5,
     * }
     * ```
     *
     * @return mixed
     * @api
     */
    public function actionGetConnectionsNumber()
    {
        $response = Yii::$app->response;
        $instance = Yii::$app->service->instance;

        if ($instance != null) {
            return [
                'uid' => $instance->uid,
                'connections_number' => Yii::$app->service->getConnectionsNumber()
            ];
        } else {
            $response->setStatusCode(404);
            return [
                'message' => 'Service instance not found.'
            ];
        }
    }

    /**
     * Updates status of service instance
     *
     * Method: PUT
     *
     * Call example: http://svc.plg.com/api/service/set-status
     *
     * Data: status
     *
     * Example of response:
     * ```json
     * {
     *  "message": "Service instance status changed.",
     * }
     * ```
     *
     * @return mixed
     * @api
     */
    public function actionSetStatus()
    {
        $response = Yii::$app->response;
        $instance = Yii::$app->service->instance;
        $status = Yii::$app->request->post('status', null);

        if ($instance != null) {
            $instance->status = strtoupper($status);
            if ($instance->save()) {
                return [
                    'message' => 'Service instance status changed.'
                ];
            } else {
                $response->setStatusCode(500);
                return [
                    'message' => 'Failed to change service instance status.'
                ];
            }
        } else {
            $response->setStatusCode(404);
            return [
                'message' => 'Service instance not found.'
            ];
        }
    }

    /**
     * Updates storing_enabled attribute of service instance
     *
     * Method: PUT
     *
     * Call example: http://svc.plg.com/api/service/set-storing
     *
     * Data: enabled
     *
     * Example of response:
     * ```json
     * {
     *  "message": "Service instance storing enabled.",
     * }
     * ```
     *
     * @return mixed
     * @api
     */
    public function actionSetStoring()
    {
        $response = Yii::$app->response;
        $instance = Yii::$app->service->instance;
        $enabled = Yii::$app->request->post('enabled', null);

        if ($instance != null) {
            $instance->storing_enabled = $enabled;
            if ($instance->save()) {
                $stateText = ($enabled == 1) ? 'enabled' : 'disabled';
                return [
                    'message' => "Service instance storing {$stateText}."
                ];
            } else {
                $response->setStatusCode(500);
                return [
                    'message' => 'Failed to change service storing.'
                ];
            }
        } else {
            $response->setStatusCode(404);
            return [
                'message' => 'Service instance not found.'
            ];
        }
    }

    /**
     * Updates proxy_enabled attribute of service instance
     *
     * Method: PUT
     *
     * Call example: http://svc.plg.com/api/service/set-use-proxy
     *
     * Data: enabled
     *
     * Example of response:
     * ```json
     * {
     *  "message": "Service instance use proxy optio enabled.",
     * }
     * ```
     *
     * @param  string $enabled 1- yes, 0- no
     * @return mixed
     * @api
     */
    public function actionSetUseProxy()
    {
        $response = Yii::$app->response;
        $instance = Yii::$app->service->instance;
        $enabled = Yii::$app->request->post('enabled', null);

        if ($instance != null) {
            $instance->proxy_enabled = $enabled;
            if ($instance->save()) {
                $stateText = ($enabled == 1) ? 'enabled' : 'disabled';
                return [
                    'message' => "Service instance use proxy option {$stateText}."
                ];
            } else {
                $response->setStatusCode(500);
                return [
                    'message' => 'Failed to change service use proxy option.'
                ];
            }
        } else {
            $response->setStatusCode(404);
            return [
                'message' => 'Service instance not found.'
            ];
        }
    }
}
