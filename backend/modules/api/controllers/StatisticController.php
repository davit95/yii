<?php

namespace backend\modules\api\controllers;

use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use Yii;
use yii\di\Container;
use InvalidArgumentException;
use DateTime;
use RuntimeException;

class StatisticController extends \yii\rest\ActiveController
{
    protected $container;

    public $statistic;

    //Init and override Repositories
    public function init(){
        $this->container = new Container;
        $this->statistic =  $this->container->get('common\repositories\StatisticRepository');
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    /**
    * @return Downloads Statistic bytes Per Day
    */
    public function actionGetStatistic(){
        return ['resource'=>$this->statistic->getStatisticBytesPerDay(),'status' => 200];
    }

    /**
    * @return Downloads Statistic,Count Success and failed downloads
    */
    public function actionGetStatisticCount(){
        return ['resource'=>$this->statistic->getStatisticCount(),'status' => 200];
    }

    /**
    * @return Downloads Statistic,Count ContentProviders downloaded content size
    */
    public function actionGetStatisticCountProviders(){
        $startDate = Yii::$app->request->get('startDate');
        $endDate = Yii::$app->request->get('endDate');
        return ['resource'=>$this->statistic->getStatisticCountProviders($startDate,$endDate),'status' => 200];
    }
}