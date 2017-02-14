<?php

namespace frontend\controllers;

use common\models\User;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\web\Response;

class ApiController extends \yii\rest\ActiveController
{
    public $modelClass = 'common\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'except' => ['login'],
        ];
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    /**
    * Renders login page
    * For admin role 
    * @return redirect to user page
    */
    public function actionLogin($access_token)
    {
        $model = new User();
        $user = $model->findIdentityByAccessToken($access_token);
        if (is_null($user)) {
            return $this->redirect('/login');
        } else {
            $url_lang = explode('-', Yii::$app->language);

            if ($user->hasRole('reseller')) {
                Yii::$app->user->login($user);
                return $this->redirect("/".$url_lang[0]."/reseller");
            } else {
                Yii::$app->user->login($user);
                return $this->redirect("/".$url_lang[0]."/profile");
            }
        }
    }
}
