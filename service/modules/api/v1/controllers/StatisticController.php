<?php
/**
 * Statistic controller
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
use service\models\StatisticalIndex;
use service\models\StatisticalDataSet;

/**
 * Handles statistics
 */
class StatisticController extends Controller
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
                    ],
                    [
                        'allow' => true,
                        'actions' => ['get'],
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
            'list-indexes' => ['get'],
            'list-data-sets' => ['get'],
            'get' => ['get'],
        ];
    }

    /**
     * Renders avaliable statistical indexes
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/statistic/list-indexes
     *
     * Example of response:
     * ```json
     * {
     *  "total": 50,
     *  "count": 10,
     *  "indexes": [...]
     * }
     * ```
     *
     * @param integer $offset
     * @param integer $limit
     * @return mixed
     * @api
     */
    public function actionListIndexes($offset = 0, $limit = 0)
    {
        $indexes = StatisticalIndex::find();

        $total = $indexes->count();

        if ($offset > 0) {
            $indexes->offset($offset);
        }

        if ($limit > 0) {
            $indexes->limit($limit);
        }

        $indexes = $indexes->all();

        return [
            'total' => $total,
            'count' => count($indexes),
            'indexes' => $indexes
        ];
    }

    /**
     * Renders avaliable statistical data sets
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/statistic/list-data-sets
     *
     * Example of response:
     * ```json
     * {
     *  "total": 50,
     *  "count": 10,
     *  "datasets": [...]
     * }
     * ```
     *
     * @param integer $offset
     * @param integer $limit
     * @return mixed
     * @api
     */
    public function actionListDataSets($offset = 0, $limit = 0)
    {
        $dataSets = StatisticalDataSet::find();

        $total = $dataSets->count();

        if ($offset > 0) {
            $dataSets->offset($offset);
        }

        if ($limit > 0) {
            $dataSets->limit($limit);
        }

        $dataSets = $dataSets->all();

        return [
            'total' => $total,
            'count' => count($dataSets),
            'datasets' => $dataSets
        ];
        return StatisticalDataSet::find()->all();
    }

    /**
     * Renders statistical data
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/statistic/get/index_name
     *
     * Example of response:
     * ```json
     * {
     *  "count": 10,
     *  "statistic": [...]
     * }
     * ```
     * @param string $indexName statistical index name
     * @param string $dateFrom start date (i.e. 2016-11-08 12:00:00)
     * @param string $dateTo end date (i.e. 2016-11-08 12:00:00)
     * @param integer $offset
     * @param integer $limit
     * @return mixed
     * @api
     */
    public function actionGet($indexName, $dateFrom = null, $dateTo = null, $offset = 0, $limit = 0)
    {
        $response = Yii::$app->response;

        $index = StatisticalIndex::findByName($indexName);

        if ($index === null) {
            $response->setStatusCode(404);
            return [
                'message' => 'Statistical index not found.'
            ];
        }

        $get = Yii::$app->request->get();

        $filter = [];
        foreach ($get as $par => $val) {
            if (!in_array($par, ['indexName', 'dateFrom', 'dateTo', 'offset', 'limit'])) {
                $filter[] = [$par => $val];
            }
        }

        $stat = Yii::$app->statistic->get($index, $dateFrom, $dateTo, $filter, $offset, $limit);

        return [
            'count' => count($stat),
            'statistic' => $stat
        ];
    }
}
