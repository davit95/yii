<?php
/**
 * Link controller
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

/**
 * Handles links
 */
class LinkController extends Controller
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
                        'actions' => ['index', 'create', 'delete'],
                        'matchCallback' => function ($rule, $action) {
                            $user = Yii::$app->user->identity;
                            return (($user !== null) && ($user->isAdmin()));
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'matchCallback' => function ($rule, $action) {
                            $user = Yii::$app->user->identity;
                            return ($user !== null);
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
    protected function verbs()
    {
        return [
            'index' => ['get'],
            'create' => ['post'],
            'delete' => ['delete']
        ];
    }

    /**
     * Retuns links for given user
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/link/index
     *
     * Example of response:
     * ```json
     * {
     *  "total": 50,
     *  "count": 1,
     *  "links": [...]
     * }
     * ```
     *
     * @param integer $user user id
     * @param integer $offset
     * @param integer $limit
     * @return mixed
     */
    public function actionIndex($user_id = null, $offset = 0, $limit = 0)
    {
        if ($user_id != null) {
            $links = Link::findByUser($user_id);
        } else {
            $links = Link::find();
        }

        $total = $links->count();

        if ($offset > 0) {
            $links->offset($offset);
        }

        if ($limit > 0) {
            $links->limit($limit);
        }

        $links = $links->all();

        return [
            'total' => $total,
            'count' => count($links),
            'links' => $links
        ];
    }

    /**
     * Creates link
     *
     * Method: POST
     *
     * Call example: http://svc.plg.com/api/link/create
     *
     * Data: link, user_id
     *
     * Example of response:
     * ```json
     * {
     *  "id": 1,
     *  "userId": 1,
     *  "link": "http://www35.zippyshare.com/v/S7yi4ZBL/file.html",
     *  "password": null,
     *  "downloadLink": "http://svc01.premiumlinkgenerator.com/content/download/f285da7e4da4c113fc89032477c6ab826b50963f",
     *  "streamLink": null,
     *  "contentName": "courage the cowardly dog 7.jpg",
     *  "contentSize": 131364,
     *  "created": 1477917788
     * }
     *
     * @return mixed
     * @api
     */
    public function actionCreate()
    {
        $response = Yii::$app->response;

        $link = new Link ();
        $link->setScenario(Link::SCENARIO_CREATE);
        $link->load(Yii::$app->request->post(), '');

        if ($link->save()) {
            return $link;
        } else {
            $response->setStatusCode(400);
            return [
                'message' => 'Failed to create new link.',
                'errors' => $link->getErrors()
            ];
        }
    }

    /**
     * Deletes link
     *
     * Method: DELETE
     *
     * Call example: http://svc.plg.com/api/link/delete/1
     *
     * Example of response:
     * ```json
     * {
     *  "message": "Link deleted successfully."
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

        $link = Link::findOne($id);

        if ($link != null) {
            $link->setScenario(Link::SCENARIO_DELETE);
            if ($link->delete()) {
                return [
                    'message' => 'Link deleted successfully.'
                ];
            } else {
                $response->setStatusCode(400);
                return [
                    'message' => 'Failed to delete link.',
                    'errors' => $link->getErrors()
                ];
            }
        } else {
            $response->setStatusCode(404);
            return [
                'message' => 'Link not found.'
            ];
        }
    }
}
