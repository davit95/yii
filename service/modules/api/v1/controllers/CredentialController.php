<?php
/**
 * Credential controller
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
use service\models\Credential;
use service\models\ContentProvider;

/**
 * Handles credentials
 */
class CredentialController extends Controller
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
            'create' => ['post'],
            'update' => ['put'],
            'delete' => ['delete'],
            'bind' => ['post'],
            'unbind' => ['post']
        ];
    }

    /**
     * Renders list of credentials
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/credentials/index
     *
     * Example of response:
     * ```json
     * {
     *   "total": 50,
     *   "count": 10,
     *   "credentials": [...]
     * }
     * ```
     *
     * @param integer $offset
     * @param integer $limit
     * @return mixed
     * @api
     */
    public function actionIndex($offset = 0, $limit = 0)
    {
        $credentials = Credential::find();

        $total = $credentials->count();

        if ($offset > 0) {
            $credentials->offset($offset);
        }

        if ($limit > 0) {
            $credentials->limit($limit);
        }

        $credentials = $credentials->all();

        return [
            'total' => $total,
            'count' => count($credentials),
            'credentials' => $credentials
        ];
    }

    /**
     * Returns credential by id
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/credentials/get/1
     *
     * Example of response:
     * ```json
     * {
     *  "id": 2,
     *  "user": "username",
     *  "pass": "password",
     *  "status": "ACTIVE"
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

        $credential = Credential::findOne($id);

        if ($credential !== null) {
            return $credential;
        } else {
            $response->setStatusCode(404);
            return [
                'message' => 'Credentials not found.'
            ];
        }
    }

    /**
     * Create new credential
     *
     * Method: POST
     *
     * Call example: http://svc.plg.com/api/credentials/create/
     *
     * Data: user, pass, status
     *
     * Example of response:
     * ```json
     * {
     *  "id": 2,
     *  "user": "username",
     *  "pass": "password",
     *  "status": "ACTIVE"
     * }
     * ```
     *
     * @return mixed
     * @api
     */
    public function actionCreate()
    {
        $response = Yii::$app->response;

        $credential = new Credential();
        $credential->setScenario(Credential::SCENARIO_CREATE);
        $credential->load(Yii::$app->request->post(), '');

        if ($credential->save()) {
            return $credential;
        } else {
            $response->setStatusCode(400);
            return [
                'message' => 'Failed to create new credential.',
                'errors' => $credential->getErrors()
            ];
        }
    }

    /**
     * Updates existing credential
     *
     * Method: PUT
     *
     * Call example: http://svc.plg.com/api/credentials/update/1
     *
     * Data: user, pass, status
     *
     * Example of response:
     * ```json
     * {
     *  "id": 2,
     *  "user": "username",
     *  "pass": "password",
     *  "status": "ACTIVE"
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

        $credential = Credential::findOne($id);

        if ($credential != null) {
            $credential->setScenario(Credential::SCENARIO_UPDATE);
            $credential->load(Yii::$app->request->post(), '');

            if ($credential->save()) {
                return $credential;
            } else {
                $response->setStatusCode(400);
                return [
                    'message' => 'Failed to update credential.',
                    'errors' => $credential->getErrors()
                ];
            }
        } else {
            $response->setStatusCode(404);
            return [
                'message' => 'Credential not found.'
            ];
        }
    }

    /**
     * Delete existing credential
     *
     * Method: DELETE
     *
     * Call example: http://svc.plg.com/api/credentials/delete/1
     *
     * Example of response:
     * ```json
     * {
     *  "message": "Credential deleted successfully."
     * }
     * ```
     *
     * @param  integer $id
     * @return mixed
     * @api
     */
    public function actionDelete($id)
    {
        $response = Yii::$app->response;

        $credential = Credential::findOne($id);

        if ($credential != null) {
            $credential->setScenario(Credential::SCENARIO_DELETE);

            if ($credential->delete()) {
                return [
                    'message' => 'Credential deleted successfully.'
                ];
            } else {
                $credential->setStatusCode(400);
                return [
                    'message' => 'Failed to delete credential.',
                    'errors' => $credential->getErrors()
                ];
            }
        } else {
            $response->setStatusCode(404);
            return [
                'message' => 'Credential not found.'
            ];
        }
    }

    /**
     * Binds credential to content provider
     *
     * Method: POST
     *
     * Call example: http://svc.plg.com/api/credentials/bind/1
     *
     * Data: provider
     *
     * Example of response:
     * ```json
     * {
     *  "message": "Credential successfully binded to content provider."
     * }
     * ```
     *
     * @param  integer $id
     * @return mixed
     * @api
     */
    public function actionBind($id)
    {
        $response = Yii::$app->response;

        $credential = Credential::findOne($id);

        if ($credential != null) {
            $provider = ContentProvider::findOne(Yii::$app->request->post('provider'));

            if ($provider != null) {
                try {
                    $provider->link('credentials', $credential);
                } catch (\Exception $e) {
                    $response->setStatusCode(500);
                    return [
                        'message' => 'Failed to bind credential to content provider.'
                    ];
                }

                return [
                    'message' => 'Credential successfully binded to content provider.'
                ];
            } else {
                $response->setStatusCode(404);
                return [
                    'message' => 'Content provider not found.'
                ];
            }
        } else {
            $response->setStatusCode(404);
            return [
                'message' => 'Credential not found.'
            ];
        }
    }

    /**
     * Unbinds credential from content provider
     *
     * Method: POST
     *
     * Call example: http://svc.plg.com/api/credentials/unbind/1
     *
     * Data: provider
     *
     * Example of response:
     * ```json
     * {
     *  "message": "Credential successfully unbinded from content provider."
     * }
     * ```
     *
     * @param  integer $id
     * @return mixed
     * @api
     */
    public function actionUnbind($id)
    {
        $response = Yii::$app->response;

        $credential = Credential::findOne($id);

        if ($credential != null) {
            $provider = ContentProvider::findOne(Yii::$app->request->post('provider'));

            if ($provider != null) {
                try {
                    $provider->unlink('credentials', $credential, true);
                } catch (\Exception $e) {
                    $response->setStatusCode(500);
                    return [
                        'message' => 'Failed to unbind credential from content provider.'
                    ];
                }

                return [
                    'message' => 'Credential successfully unbinded from content provider.'
                ];
            } else {
                $response->setStatusCode(404);
                return [
                    'message' => 'Content provider not found.'
                ];
            }
        } else {
            $response->setStatusCode(404);
            return [
                'message' => 'Credential not found.'
            ];
        }
    }
}
