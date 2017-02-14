<?php

namespace backend\modules\api\controllers;

use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use Yii;
use yii\di\Container;
use InvalidArgumentException;
use RuntimeException;

class ResellersController extends \yii\rest\ActiveController
{
    public $modelClass = 'common\models\ResellerFee';
    
    protected $container;

    public $resellers;

    //Init and override Repositories
    public function init(){
        $this->container = new Container;
        $this->resellers =  $this->container->get('common\repositories\ResellersRepository');
    }
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
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    /**
    * @return all resellers
    */
    public function actionShowResellers(){
        return ['resource'=>$this->resellers->showResellers(),'status'=>"success"];
    }

    /**
    * @param reseller user_id
    * @return new resellers resourse
    */
    public function actionDeleteReseller(){
        $id =  Yii::$app->request->post("id");
        if($this->resellers->DeleteReseller($id)){
            return ['resource'=> $this->resellers->showResellers() ,"status" => "success"];
        }
        return  ['resource'=>null,"status" => "can not delete record"];
    }

    /**
    * @param reseller id
    * @return new resellers resourse
    */
    public function actionUpdateReseller(){
        $reseller = Yii::$app->request->post("reseller");
        if($this->resellers->updateReseller($reseller)){
            return ['status'=>'success',"resource"=>$this->resellers->showResellers()];
        }
        return ['status'=>'Error Occured',"resource"=>null];
    }

    /**
    * Store a newly created resource in storage.
    * @param new resellers resourse
    */
    public function actionCreateReseller(){
        $data = Yii::$app->request->post("data");
        if($this->resellers->createReseller($data)){
            return ['resourse'=> $this->resellers->showResellers() ,"status" => "success"];
        }
        return ['resourse'=>null,"status" => "User Role with this email address is not role reseller"];
    }

    /**
    * Show Reseller By Id
    * @return reseller
    */
    public function actionShowResellerById(){
        $id =  Yii::$app->request->get("id");
        return ['resource'=>$this->resellers->showResellerById($id),"status" => "success"];
    }
}