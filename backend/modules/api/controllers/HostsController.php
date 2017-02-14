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
use common\models\Service;
use backend\modules\api\components\service\Client;

class HostsController extends \yii\rest\ActiveController
{
    public $modelClass = 'service\models\ContentProvider';
    
    public $hosts;

    //Init and override Repositories
    public function init(){
        $this->container = new Container;
        $this->hosts =  $this->container->get('common\repositories\HostRepository');
    }

    protected $container;

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        parent::beforeAction($action);
        if (Yii::$app->user->isGuest){
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
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
    * @return Array with All hosts
    */
    public function actionIndex()
    {
        $hosts = $this->hosts->getAllHostsApi();
        return ['status'=>'success', 'resource' => $hosts];
    }

    /**
    * @return Array with All hosts with LastChecked date
    */
    public function actionProviders(){
        //get ApiService 
        $service = $this->hosts->getService();
        //get host By Id
        $host = $this->hosts->getHostById(Yii::$app->request->post());
        
        if($host->status == 'active'){
            $status = "INACTIVE";
            if(null!=$this->hosts->updateContentProviderByApiCall($host->content_provider_id,$service->api_url,$status)){
                $host->status ='inactive';
                $host->save();
                $hosts = $this->hosts->getAllHostsApi();
                return ['status'=>'success', 'resource' => $hosts];
            }
        }else{
            $status = "ACTIVE";
            if(null!=$this->hosts->updateContentProviderByApiCall($host->content_provider_id,$service->api_url,$status)){
                $host->status = 'active';
                $host->save();
                $hosts = $this->hosts->getAllHostsApi();
                return ['status'=>'success', 'resource' => $hosts];
            }
        }
    }
}