<?php

namespace backend\modules\api\controllers;

use yii\web\Controller;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use Yii;
use yii\di\Container;
use RuntimeException;


class ContactController extends \yii\rest\ActiveController
{
    public $modelClass = 'common\models\ContactUsMessages';

    protected $container;

    public $contact_us_messages;

    //Init and override Repositories
    public function init(){
        $this->container = new Container;
        $this->contact_us_messages =  $this->container->get('common\repositories\ContactUsRepository');
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
    * @return Contact Us Messages
    */
    public function actionGetMessages(){
        return ['resource'=>$this->contact_us_messages->showMessages(),'status'=>200];
    }

    /**
    * @return Specific Message resourse 
    */
    public function actionGetMessageById(){
        return ['resource'=>$this->contact_us_messages->showMessageById(Yii::$app->request->get('id')),'status'=>200];
    }

    /**
    * @return Specific Message resource for Reply new Message
    */
    public function actionGetMessageByIdForReply(){
        return ['resource'=>$this->contact_us_messages->showMessageByIdForReply(Yii::$app->request->get('id')),'status'=>200];
    }

    /**
    * Delete checked messages from storage
    * @return new resourses 
    */
    public function actionDeleteChecked(){
        $data = Yii::$app->request->post('data');
        if($this->contact_us_messages->deleteChecked($data)){
            $messages = $this->contact_us_messages->showMessages();
            return ['resource'=> $this->contact_us_messages->showMessages(),'status'=>200];
        }
        return ['resource'=>null,'status'=>500];
    }

    /**
    * Send Reply Email
    * @return boolean
    */
    public function actionSendReplyEmail(){
        $email_data = Yii::$app->request->post('email_data');
        $message = Yii::$app->request->post('message');
        try {
            if($this->contact_us_messages->SendReplyEmail($email_data,$message)){
                return ['resource'=>$this->contact_us_messages->showMessageById($email_data['id']),'status'=>200];
            }
        } catch (RuntimeException $e) {
            return ['resource'=>$e->getMessage(),'status'=>500];
        }
    }

    /**
    * Compose Email
    * @return boolean
    */
    public function actionSendEmail(){
        $email_data = Yii::$app->request->post('email_data');
        return ['resource'=> $this->contact_us_messages->SendEmail($email_data)];
    }
}
?>