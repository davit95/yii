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

class TranslationsController extends \yii\rest\ActiveController
{
    public $modelClass = 'common\models\SourceMessage';
    
    protected $container;

    public $source_message;

    //Init and override Repositories
    public function init(){
        $this->container = new Container;
        $this->source_message =  $this->container->get('common\repositories\TranslationRepository');
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
    * @return SourceMessage with Message
    */
    public function actionGetMessages(){
        return $this->source_message->getSourceMessageWithMessage();
    }

    /**
    * @return SourceMessage with Message
    */
    public function actionGetMessagesWithId(){
        $id = Yii::$app->request->get('id');
        return ['status'=>200,'message'=>'success','resource'=>$this->source_message->getSourceBySlug($id)];
    }

    /**
    * @return statusCode and message
    */
    public function actionUpdateTranslation(){
        $data = Yii::$app->request->post('data');
        $connection = Yii::$app->db;
        foreach ($data as $key => $item) {
            $connection->createCommand()->update('message', ['translation' => $item['translation'],'language'=>$item['language']], 'id='."'".$item['id']."'".'AND language ='."'".$item['language']."'".'')->execute();
        }
        return ['status'=>200,'message'=>'success'];
    }

    /**
    * @return statusCode and message
    */
    public function actionDeleteTranslation(){
        if($this->source_message->deleteCategory(Yii::$app->request->post('id'))){
            return ['status'=>200,'message'=>'success'];
        }else{
            return ['status'=>500,'message'=>'error'];
        }
    }
    
    /**
    * @return statusCode and message
    */
    public function actionCreateTranslation(){
        $data = Yii::$app->request->post('data');
        if($this->source_message->createCategory($data)){
            return ['status'=>200,'message'=>'success'];
        }else{
            return ['status'=>500,'message'=>'success'];
        }
    }
}