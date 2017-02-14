<?php

namespace backend\modules\api\controllers;

use yii\web\Controller;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\di\Container;
use InvalidArgumentException;
use DateTime;
use RuntimeException;

class UsersController extends \yii\rest\ActiveController
{
    public $modelClass = 'common\models\User';

    protected $container;

    public $user;

    //Init and override Repositories
    public function init(){
        $this->container = new Container;
        $this->user =  $this->container->get('common\repositories\UserRepository');
    }

    public function beforeAction($action)
    {
        parent::beforeAction($action);
        if (Yii::$app->user->isGuest){
            return false;
        }
        return true;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete'], $actions['update'], $actions['index'], $actions['create']);
        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    public function actionIndex()
    {
        $users = $this->user->getAllUsersApi();
        return ['status' => 'success', 'resource' => $users];
    }

    public function actionDelete($id)
    {
        try {
            $user = $this->user->deleteUser($id);
        } catch (InvalidArgumentException $exception) {
            return ['status' => 'error', 'message' => $exception->getMessage()];
        } catch (RuntimeException $exception) {
            return ['status' => 'error', 'message' => $exception->getMessage()];
        }

        return ['status' => 'success', 'resource' => $user];
    }

    public function actionCreate()
    {
        $email  = \Yii::$app->request->post('email');
        $password = \Yii::$app->request->post('password');
        $first_name = \Yii::$app->request->post('firstname');
        $last_name = \Yii::$app->request->post('lastname');

        $model = $this->container->get('frontend\models\SignupForm');

        $expiration_date = (new DateTime('+7 day'))->format('Y-m-d H:i:s');
        $access_token = Yii::$app->security->generateRandomString(16);
        $model->expiration_date = $expiration_date;
        $model->access_token = $access_token;
        $model->email = $email;
        $model->password = $password;

        $data = [
            'email' => $email,
            'password' => $password,
            'first_name'=>$first_name,
            'last_name'=>$last_name,
            'access_token' => $access_token,
            'expiration_date' => $expiration_date,
            'role'=> \Yii::$app->request->post('roleSelected')
        ];

        $model->attributes  = $data;

        if ($model->validate() && !is_null($this->user->createUser($data))) {
            return ['status' => 'success', 'User has been successfully created.'];
        } else {
            return ['status' => 'error', 'message' => $model->errors];
        }
    }

    public function actionActive()
    {
        $id = \Yii::$app->request->post('id');
        $status = ((int)\Yii::$app->request->post('status') == 1) ? 0 : 1;

        try {
            $user = $this->user->updateUserStatus($id, $status);
        } catch (InvalidArgumentException $exception) {
            return ['status' => 'error', 'message' => $exception->getMessage()];
        } catch (RuntimeException $exception) {
            return ['status' => 'error', 'message' => $exception->getMessage()];
        }

        $users = $this->user->getAllUsersApi();

        return ['status'=>'success', 'resource' => $users];
    }
}
