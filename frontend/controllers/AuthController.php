<?php

namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use common\models\User;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\components\behaviors\ReferralBehavior;
use yii\di\Container;

class AuthController extends \yii\web\Controller
{
    protected $container;
    /**
     * @inheritdoc
     */
	 public function behaviors()
     {
        return [
            'referral' => [
                'class' => ReferralBehavior::className()
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $this->container = new Container;
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
    * Renders login page
    *
    * @return mixed
    */
    public function actionLogin()
    {
        $meta = $this->container->get('common\repositories\PagesRepository')->getPageMetaData('login');
        $title = $this->container->get('common\repositories\PagesRepository')->getPageTitle('login');
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect('/profile');
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = Yii::$app->user->identity;

            $url_lang = explode('-', Yii::$app->language);
            if ($user->hasRole('reseller')) {
                return $this->redirect("/".$url_lang[0]."/reseller");
            } else {
                return $this->redirect("/".$url_lang[0]."/profile");
            }
        } else {
            return $this->render('login', [
                'model' => $model,
                'title'=> $title,
                'meta'=>$meta
            ]);
        }
    }

    /**
    * @return mixed
    */
    public function actionLogout()
    {
        $url_lang = explode('-', Yii::$app->language);
        Yii::$app->user->logout();
        return $this->redirect(Yii::$app->getHomeUrl().$url_lang[0]);
    }

    /**
    * Renders Signup page
    *
    * @return mixed
    */
    public function actionRegister(){
        $meta = $this->container->get('common\repositories\PagesRepository')->getPageMetaData('register');
        $title = $this->container->get('common\repositories\PagesRepository')->getPageTitle('register');
        $model = new SignupForm();
        $post = Yii::$app->request->post();
        $date = date("Y-m-d H:i:s");
        $date = strtotime($date);
        $date = strtotime("+7 day", $date);
        $format = date('Y-m-d H:i:s', $date);
        $model->expiration_date=$format;
        $model->access_token = Yii::$app->security->generateRandomString(16);
        $model->role = 'user';
        $url_lang = explode('-', Yii::$app->language);
        $lang_path = $url_lang[0];
        if ($model->load($post)) {
            if ($user = $model->signup()) {
                $this->getBehavior('referral')->catchRegister();
                return $this->redirect('/auth/login');
            }
        }

        return $this->render('register', [
            'model' => $model,'lang_path'=>$lang_path,'title'=> $title,'meta'=>$meta
        ]);
    }

}
