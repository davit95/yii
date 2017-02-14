<?php
/**
 * Content provider controller
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
use service\models\Link;
use service\models\ContentProvider;

/**
 * Handles content providers
 */
class ContentProviderController extends Controller
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
            'get-credentials' => ['get'],
            'is-alive' => ['get'],
            'create' => ['post'],
            'update' => ['put'],
            'delete' => ['delete']
        ];
    }

    /**
     * Renders list of content providers
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/content-providers/list
     *
     * Example of response:
     * ```json
     * {
     *  "total": 50,
     *  "count": 10,
     *  "providers": [...]
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
        $providers = ContentProvider::find();

        $total = $providers->count();

        if ($offset > 0) {
            $providers->offset($offset);
        }

        if ($limit > 0) {
            $providers->limit($limit);
        }

        $providers = $providers->all();

        return [
            'total' => $total,
            'count' => count($providers),
            'providers' => $providers
        ];
    }

    /**
     * Returns content provider by id
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/content-providers/get/1
     *
     * Example of response:
     * ```json
     * {
     *  "id": 2,
     *  "name": "1fichier.com",
     *  "class": "service\\components\\contents\\OneFichierCom",
     *  "urlTpl": "https?:\\/\\/1fichier\\.com\\/.+",
     *  "authUrl": "https://1fichier.com/login.pl",
     *  "downloadable": 1,
     *  "streamable": 0,
     *  "storable": 1,
     *  "useProxy": 0,
     *  "status": "ACTIVE",
     *  "created": 1477909318,
     *  "updated": null
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

        $provider = ContentProvider::findOne($id);

        if ($provider !== null) {
            return $provider;
        } else {
            $response->setStatusCode(404);
            return [
                'message' => 'Content provider not found.'
            ];
        }
    }

    /**
     * Rerurns credentials which are binded to content provider
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/content-providers/get-credentials/1
     *
     * Example of response:
     * ```json
     * {
     *  "count": 1,
     *  "credentials": [
     *   {
     *    "id": 17,
     *    "user": "username",
     *    "pass": "password",
     *    "status": "ACTIVE"
     *   }
     *  ]
     * }
     *
     * @param  integer $id
     * @return mixed
     * @api
     */
    public function actionGetCredentials($id)
    {
        $response = Yii::$app->response;

        $provider = ContentProvider::findOne($id);

        if ($provider !== null) {
            return [
                'count' => count($provider->credentials),
                'credentials' => $provider->credentials
            ];
        } else {
            $response->setStatusCode(404);
            return [
                'message' => 'Content provider not found.'
            ];
        }
    }

    /**
     * Checks if content provider is "alive"
     *
     * Checks if content provider is able to download content.
     * Link (and password) to file may be provided as action params.
     * If link is not provided it will be taken from curently existing links.
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/content-providers/is-alive/1
     *
     * Example of response:
     * ```json
     * {
     *  "isAlive": "yes",
     *  "provider": {
     *   "id": 2,
     *   "name": "1fichier.com",
     *   "class": "service\\components\\contents\\OneFichierCom",
     *   "urlTpl": "https?:\\/\\/1fichier\\.com\\/.+",
     *   "authUrl": "https://1fichier.com/login.pl",
     *   "downloadable": 1,
     *   "streamable": 0,
     *   "storable": 1,
     *   "useProxy": 0,
     *   "status": "ACTIVE",
     *   "created": 1477909318,
     *   "updated": null
     *  },
     *  "link": {
     *   "id": 5,
     *   "userId": 14,
     *   "link": "https://1fichier.com/?camvve48y9",
     *   "password": null,
     *   "downloadLink": "http://svc.plg.com/content/download/e0ddc8cd96a6b8fb6e830e9c992d6ade2ae48884",
     *   "streamLink": null,
     *   "contentName": "video_file_sm.mp4",
     *   "contentSize": 5253880,
     *   "created": 1478526737
     *  },
     *  "content": {
     *   "length": 5253880,
     *   "name": "video_file_sm.mp4",
     *   "mimeType": "video/mp4"
     *  }
     * }
     *
     * @param  integer $id
     * @param  string $link
     * @param  string $password
     * @return mixed
     * @api
     */
    public function actionIsAlive($id, $link = null, $password = null)
    {
        $response = Yii::$app->response;

        $provider = ContentProvider::findOne($id);

        if ($provider === null) {
            $response->setStatusCode(404);
            return [
                'message' => 'Content provider not found.'
            ];
        }

        if ($link != null) {
            $lnk = new Link();
            $lnk->link = $link;
            if ($password) {
                $lnk->password = $password;
            }
        } else {
            $lnk = Link::find()
                ->where(['REGEXP', 'link', $provider->url_tpl])
                ->orderBy(['created' => SORT_DESC])
                ->one();
        }

        if ($lnk === null) {
            $response->setStatusCode(404);
            return [
                'message' => 'Link not found.'
            ];
        }

        try {
            $content = $provider->getContent($lnk);
            return [
                'isAlive' => 'yes',
                'provider' => $provider,
                'link' => $lnk,
                'content' => $content
            ];
        } catch (\Exception $e) {
            return [
                'isAlive' => 'no',
                'provider' => $provider,
                'link' => $lnk,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Create new content provider
     *
     * Creates new content provider.
     * Note that file containing PHP implementation of content provider should exist.
     *
     * Method: POST
     *
     * Call example: http://svc.plg.com/api/content-providers/create
     *
     * Data: name, class, url_tpl, auth_url, downloadable, streamable, storable,
     * use_proxy, status
     *
     * Example of response:
     * ```json
     * {
     *  "id": 2,
     *  "name": "1fichier.com",
     *  "class": "service\\components\\contents\\OneFichierCom",
     *  "urlTpl": "https?:\\/\\/1fichier\\.com\\/.+",
     *  "authUrl": "https://1fichier.com/login.pl",
     *  "downloadable": 1,
     *  "streamable": 0,
     *  "storable": 1,
     *  "useProxy": 0,
     *  "status": "ACTIVE",
     *  "created": 1477909318,
     *  "updated": null
     * }
     * ```
     *
     * @return mixed
     * @api
     */
    public function actionCreate()
    {
        $response = Yii::$app->response;

        $provider = new ContentProvider();
        $provider->setScenario(ContentProvider::SCENARIO_CREATE);
        $provider->load(Yii::$app->request->post(), '');

        if ($provider->save()) {
            return $provider;
        } else {
            $response->setStatusCode(400);
            return [
                'message' => 'Failed to create new content provider.',
                'errors' => $provider->getErrors()
            ];
        }
    }

    /**
     * Update content provider
     *
     * Updates existing content provider.
     * Note that file containing PHP implementation of content provider should exist.
     *
     * Method: PUT
     *
     * Call example: http://svc.plg.com/api/content-providers/update/1
     *
     * Data: name, class, url_tpl, auth_url, downloadable, streamable, storable,
     * use_proxy, status
     *
     * Example of response:
     * ```json
     * {
     *  "id": 2,
     *  "name": "1fichier.com",
     *  "class": "service\\components\\contents\\OneFichierCom",
     *  "urlTpl": "https?:\\/\\/1fichier\\.com\\/.+",
     *  "authUrl": "https://1fichier.com/login.pl",
     *  "downloadable": 1,
     *  "streamable": 0,
     *  "storable": 1,
     *  "useProxy": 0,
     *  "status": "ACTIVE",
     *  "created": 1477909318,
     *  "updated": null
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

        $provider = ContentProvider::findOne($id);

        if ($provider != null) {
            $provider->setScenario(ContentProvider::SCENARIO_UPDATE);
            $provider->load(Yii::$app->request->post(), '');

            if ($provider->save()) {
                return $provider;
            } else {
                $response->setStatusCode(400);
                return [
                    'message' => 'Failed to update content provider.',
                    'errors' => $provider->getErrors()
                ];
            }
        } else {
            $response->setStatusCode(404);
            return [
                'message' => 'Content provider not found.'
            ];
        }
    }

    /**
     * Delete existing content provider
     *
     * Method: DELETE
     *
     * Call example: http://svc.plg.com/api/content-providers/delete/1
     *
     * Example of response:
     * ```json
     * {
     *  "message": "Content provider deleted successfully."
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

        $provider = ContentProvider::findOne($id);

        if ($provider != null) {
            $provider->setScenario(ContentProvider::SCENARIO_DELETE);

            if ($provider->delete()) {
                return [
                    'message' => 'Content provider deleted successfully.'
                ];
            } else {
                $response->setStatusCode(400);
                return [
                    'message' => 'Failed to delete content provider.',
                    'errors' => $provider->getErrors()
                ];
            }
        } else {
            $response->setStatusCode(404);
            return [
                'message' => 'Content provider not found.'
            ];
        }
    }
}
