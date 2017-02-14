<?php
/**
 * Debug controller
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
 * Handles debug staff
 */
class DbgController extends Controller
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
    protected function verbs()
    {
        return [
            'content' => ['get']
        ];
    }

    /**
     * Renders dubug information for content
     *
     * Link and password (if required) are provided via action params.
     * Response contains link, content provider and content.
     * Debug messages can be also rendered @see service\components\behaviors\DebugBehavior.
     * If error occures Exception data is returned.
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/dbg/content?link=http://host/file
     *
     * Example of response:
     * ```json
     * {
     *  "success": true,
     *  "link": {
     *   "id": null,
     *   "userId": null,
     *   "link": "https://1fichier.com/?camvve48y9",
     *   "password": null,
     *   "downloadLink": null,
     *   "streamLink": null,
     *   "contentName": null,
     *   "contentSize": null,
     *   "created": null
     *  },
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
     *  "content": {
     *   "length": 5253880,
     *   "name": "video_file_sm.mp4",
     *   "mimeType": "video/mp4"
     *  },
     *  "debug": [...]
     * }
     * ```
     *
     * @param string $link
     * @param string $password
     * @return mixed
     * @api
     */
    public function actionContent($link, $password = null)
    {
        $lnk = new Link();
        $lnk->link = $link;
        $lnk->password = $password;

        try {
            $provider = $lnk->getContentProvider();
            $content = $provider->getContent($lnk);
            $debugMessages = [];
            if ($content !== null && $content->getBehavior('debugBehavior') !== null) {
                $debugMessages = $content->getDebugMessages();
            }

            return [
                'success' => true,
                'link' => $lnk,
                'provider' => $provider,
                'content' => $content,
                'debug' => $debugMessages
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'link' => $lnk,
                'exception' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            ];
        }
    }
}
