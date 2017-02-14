<?php

namespace backend\modules\api\controllers;

use yii\web\Controller;
use frontend\models\Page;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use Yii;
use yii\di\Container;
use InvalidArgumentException;
use DateTime;
use RuntimeException;

class PagesController extends \yii\rest\ActiveController
{
    public $modelClass = 'frontend\models\Page';

    public $pages;

    //Init and override Repositories
    public function init(){
        $this->container = new Container;
        $this->pages =  $this->container->get('common\repositories\PagesRepository');
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
    protected function verbs()
    {
        return [
            'json' => ['post'],
        ];
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
    * Get specific resource from storage.
    */
    public function actionUrls(){
        $page = $this->pages->getAllPageUrls();
        return ['status'=>'success','resource'=>$page];
    }

    /**
    * Get specific resource from storage.
    */
    public function actionContent(){
        $queryParam = Yii::$app->request->get();
        $page = $this->pages->getPageDetailsByPageNameApi($queryParam);
        return ['status'=>'success','resource'=>$page];
    }

    /**
    * Store a newly created resource in storage.
    * @param bodyParam Json
    */
    public function actionJson(){
        $object = Yii::$app->request->post();
        $pagename = $object['pagename'];

        if($this->pages->UpdatePageDetails($object)){
            return ['status'=>'success','message'=>$pagename.' text has been successfully updated','resource'=>"sdsdsd"];
        }else{
            return ['status'=>'error','message'=>'Error Occurred'];
        }
    }

    /**
    * Store a newly created resource in storage.
    * @param QueryParam Json
    */
    public function actionAddmeta(){
        $queryParam  = Yii::$app->request->get();
        $pageDetails = $this->pages->getPageDetailsByPageNameApi($queryParam);
        $queryParam['page_id'] = $pageDetails[0]['id'];

        if($this->pages->saveMetadata($queryParam)){
            return ['status'=>'success','message'=>'meta data for this page hes benn successfully created'];
        }elseif(!$this->pages->saveMetadata($queryParam)){
            return ['status'=>'error','message'=>'fields are required'];
        }else{
             return ['status'=>'error','message'=>'error ,metadata does not created'];
        }
    }

     /**
    * Get specific resource from storage.
    */
    public function actionGetmeta(){
        $slug = Yii::$app->request->get();
        $pageDetails = $this->pages->getPageMetaDataApi($slug);

        return ['status'=>'success','resource'=>$pageDetails];
    }

    /**
    * Store a newly created resource in storage.
    * @param QueryParam Json
    */
    public function actionUpdatemeta(){
        $queryParam = Yii::$app->request->get();

        if(true == $this->pages->UpdateMeta($queryParam)) {
            return ['status'=>'success','message'=>'Your Page meta data has been successfully updated'];
        }else{
            return ['status'=>'error','message'=>'Meta data does not updated'];
        }
    }

    /**
    * Store a newly created resource in storage.
    */
    public function actionAddPageTitle(){
        $queryParam = Yii::$app->request->get();

        if(true == $this->pages->savePageTitle($queryParam)) {
            return ['status'=>'success','message'=>'Your Page title has been successfully created'];
        }elseif(null == $this->pages->savePageTitle($queryParam)){
            return ['status'=>'success','message'=>'There is a page title'];
        }else{
            return ['status'=>'error','message'=>' Page title data does not created'];
        }
    }

    /**
    * get resource from storage.
    */
    public function actionGetPageTitleApi(){
        $slug = Yii::$app->request->get();
        $pageTitle = $this->pages->getPageTitleApi($slug);
        return ['status'=>'success','resource'=>$pageTitle];
    }

    /**
    * Update Page title
    */
    public function actionEditPageTitle(){
        $queryParam = Yii::$app->request->get();
        if(true == $this->pages->UpdatePageTitle($queryParam)) {
            return ['status'=>'success','message'=>'Your Page title has been successfully updated'];
        }else{
            return ['status'=>'error','message'=>' Page title data does not updated'];
        }
    }
}