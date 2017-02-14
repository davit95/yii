<?php

namespace backend\modules\api\controllers;

use yii\web\Controller;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use common\models\LoginForm;
use Yii;
use yii\di\Container;
use yii\filters\auth\QueryParamAuth;
use yii\filters\AccessControl;

class AuthController extends \yii\rest\ActiveController
{
    public $modelClass = 'common\models\User';

    protected $container;

    /**
    * @inheritdoc
    */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
	        'class' => QueryParamAuth::className(),
	        'except'=>['login','adminlogin','getauthuser','logout'],
        ];
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    /**
    * @param access_token string for QueryParam Auth
    * @return Array with status
    */
    public function actionLogin($access_token){
        $model = new User();
        $user = $model->findIdentityByAccessToken($access_token);
        Yii::$app->user->login($user);

        if (Yii::$app->user->isGuest) {
            return ['status'=>'error'];
        } else {
           return ['status'=>'success'];
        }
    }

    /**
    * Admin Login logic
    * @return Array with status and User Identity object
    */
    public function actionAdminlogin(){
        $email = Yii::$app->request->post('email');
        $password = Yii::$app->request->post('password');

        $user = User::find()->where(['email' => $email])->one();

        if ($user != null && $user->validatePassword($password)) {
            if ($user->hasRole('admin')) {
                $isLoggedIn = Yii::$app->user->login($user);
                return [
                    'status' => 'success',
                    'login' => $isLoggedIn
                ];
            }
        }

        $error = 'Incorrect Email or Password';
        return [
            'status' => 'error',
            'message' => $error,
            'login' => Yii::$app->user->isGuest
        ];
    }

    /**
    * Admin Logout
    * @return Array with status and User Identity object
    */
    public function actionLogout(){
        if(Yii::$app->user->logout()){
            return ['status'=>'success','logout'=>Yii::$app->user->logout()];
        }
    }

    /**
    * midelware for AngularJs
    * @return Array with status and User Identity object
    */
    public function actionGetauthuser(){
        if(Yii::$app->user->isGuest){
            return ['status'=>false,'resource'=>null];
        }
        else{
          return ['status'=>true,'resource'=>Yii::$app->user->identity];
        }
    }
}
?>
