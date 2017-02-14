<?php
namespace common\modules\api_v1\v1\controllers;

use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use common\models\LoginForm;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\filters\AccessControl;
use yii\di\Container;
use InvalidArgumentException;
use DateTime;
use RuntimeException;
use yii\filters\VerbFilter;

class AuthController extends \yii\rest\ActiveController
{
    protected $container;

    public $modelClass = 'common\models\User';

    public function actions()
    {
        $this->container = new Container;
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    protected function verbs()
    {
        return [
            'payment-response' => ['post'],
        ];
    }

    /**
    * Generate new User
    */
    public function actionPaymentResponce(){
        $post_token = Yii::$app->request->post('token');
        $api_user = new ApiUser;
        $token = $api_user->getTokenByToken($post_token);
        if(null != $token && \Yii::$app->auth->isExpired($token)){
            //Todo Create Plg User by Wp.Mrpay Email Address
        }elseif(null != $token && !\Yii::$app->auth->isExpired($token)){
            return ['message'=>'token expired'];
        }else{
            return ['message'=>'incorect credentials '];
        }
    }
}
?>
