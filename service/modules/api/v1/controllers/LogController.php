<?php
/**
 * Log controller
 *
 * @package service\api
 * @author Yura Tovt <yura.tovt@ffflabel.com>
 */

namespace service\modules\api\v1\controllers;

use Yii;
use yii\db\Query;
use yii\db\Expression;
use yii\web\Response;
use yii\rest\Controller;
use yii\filters\VerbFilter;
use yii\filters\ContentNegotiator;

/**
 * Handles log view and manipulate actions
 */
class LogController extends Controller
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
            'list' => ['get'],
            'view' => ['get'],
            'truncate' => ['post']
        ];
    }

    /**
     * Renders summary log entry info
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/log/list
     *
     * Example of response:
     * ```json
     * {
     *  "total": 10,
     *  "count": 1,
     *  "entries": [...]
     * }
     * ```
     *
     * @param  integer $offset
     * @param  integer $limit
     * @return mixed
     * @api
     */
    public function actionList($offset = 0, $limit = 0)
    {
        $select[] = 'id';
        $select[] = 'category';
        $select[] = new Expression('FROM_UNIXTIME(log_time) AS log_time');
        $select[] = new Expression('CONCAT(SUBSTR(message, 1, 100), "...") AS short_message');
        $query = new Query();
        $query->select($select);
        $query->from('{{%logs}}');

        $total = $query->count();

        if ($offset > 0) {
            $query->offset($offset);
        }
        if ($limit > 0) {
            $query->limit($limit);
        }

        $logs = $query->all();

        return [
            'total' => $total,
            'count' => count($logs),
            'entries' => $logs
        ];
    }

    /**
     * Renders single log entrie
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/log/view/1
     *
     * Example of response:
     * ```json
     * [
     *  {
     *   "id": "30707",
     *   "category": "yii\\web\\HttpException:404",
     *   "log_time": "2016-11-03 14:33:41.609300",
     *   "message": "..."
     *  }
     * ]
     * ```
     *
     * @param  integer $id
     * @return mixed
     * @api
     */
    public function actionView($id)
    {
        $response = Yii::$app->response;

        $select[] = 'id';
        $select[] = 'category';
        $select[] = new Expression('FROM_UNIXTIME(log_time) AS log_time');
        $select[] = 'message';
        $query = new Query();
        $query->select($select);
        $query->from('{{%logs}}');
        $query->where(['id' => $id]);

        $log = $query->one();

        if ($log == null) {
            $response->setStatusCode(404);
            return [
                'message' => 'Log entry not found.'
            ];
        }

        return [
            $log
        ];
    }

    /**
     * Truncates log till given date
     *
     * Method: POST
     *
     * Call example: http://svc.plg.com/api/log/truncate
     *
     * Data: date
     *
     * Example of response:
     * ```json
     * {
     *  "message": "Log truncated successfuly."
     * }
     * ```
     *
     * @return mixed
     * @api
     */
    public function actionTruncate()
    {
        $response = Yii::$app->response;

        $date = Yii::$app->request->post('date');
        $date = ($date != null) ? Yii::$app->formatter->asTimestamp($date) : null;

        if ($date == null) {
            $response->setStatusCode(400);
            return [
                'message' => 'Invalid date.'
            ];
        }

        $comm = Yii::$app->db->createCommand();
        $comm->delete('{{%logs}}', ['<', 'log_time', $date]);

        if ($comm->execute()) {
            return [
                'message' => 'Log truncated successfuly.'
            ];
        } else {
            $response->setResponseCode(400);
            return [
                'message' => 'Failed to truncate log.'
            ];
        }
    }
}
