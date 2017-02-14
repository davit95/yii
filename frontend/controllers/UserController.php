<?php

namespace frontend\controllers;

use frontend\models\ContactForm;
use Yii;
use yii\di\Container;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\helpers\Url;
use frontend\models\Page;
use common\models\Product;
use app\models\ChangeModel;
use frontend\components\behaviors\ReferralBehavior;

class UserController extends \yii\web\Controller
{
    protected $container;

    public $param;

    public $pages;
    public $hosts;
    public $price;
    public $contact_us_messages;

    //Init and override Repositories
    public function init(){
        $this->container = new Container;

        $this->pages = $this->container->get('common\repositories\PagesRepository');
        $this->hosts =  $this->container->get('common\repositories\HostRepository');
        $this->contact_us_messages =  $this->container->get('common\repositories\ContactUsRepository');
    }

    /**
    * @inheritdoc
    */
    public function beforeAction($action)
    {
        if(Yii::$app->request->url=="/" || Yii::$app->request->url=="/en" || Yii::$app->request->url=="/ru"){
            $this->param = "homepage";
        }else{
            $url  = explode("/",Yii::$app->request->url);
            if(count($url)>3){
                $this->param = explode("/",Yii::$app->request->url)[3];
            }elseif(count($url)>2){
                $this->param = explode("/",Yii::$app->request->url)[2];
            }elseif(count($url)>1){
                $this->param = explode("/",Yii::$app->request->url)[1];
            }else{
                $this->param = "homepage";
            }
        }
        return parent::beforeAction($action);
    }

    /**
    * @inheritdoc
    */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions'=> ['price','contact','changelanguage','supported-payment-methods'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'referral' => [
                'class' => ReferralBehavior::className(),
                'actions' => [
                    'index' => 'catchVisitPage'
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
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
     * Requests password reset.
     * *** It may be needed
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     * ***It may be needed
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Displays user profile page.
     *
     * @return mixed
     */
    public function actionProfile(){
        $this->layout = 'site';
        $title = $this->pages->getPageTitle($this->param);
        $meta = $this->pages->getPageMetaData($this->param);
        $user = Yii::$app->user->identity;

        $last_download = $this->hosts->getLastDownloadDate($user);

        $url_lang = explode('-', Yii::$app->language);
        $lang_path = $url_lang[0];

        return $this->render('profile',['lang1' => $lang_path,'last_download'=>$last_download,'title'=>$title,'meta'=>$meta]);
    }

    /**
     * Displays user forum page.
     *
     * @return mixed
     */
    public function actionForum(){
        $title = $this->pages->getPageTitle($this->param);
        $meta = $this->pages->getPageMetaData($this->param);
        $this->layout = 'site';
        $active = 'active';
        return $this->render('forum',['title'=>$title,'meta'=>$meta]);
    }

    /**
     * Displays overviews page.
     *
     * @return mixed
     */
    public function actionOverviews(){
        $title = $this->pages->getPageTitle($this->param);
        $meta = $this->pages->getPageMetaData($this->param);
        $this->layout = 'site';
        $hosts = $this->hosts->getAllHosts()->all();
        return $this->render('overviews',['hosts'=>$hosts,'title'=>$title,'meta'=>$meta]);
    }

     /**
     * Renders change Password Page
     *
     * @return mixed
     */
    public function actionChangePassword ()
    {
        $this->layout = 'site';
        $url_lang = explode('-', Yii::$app->language);
        $lang_path = $url_lang[0];
        if(!Yii::$app->user->isGuest){
            $model = new ChangeModel;
            $modeluser = \common\models\User::find()->where([
                'email'=>Yii::$app->user->identity->email
                ])->one();

            $isReseller = $modeluser->hasRole('reseller');
            if ($isReseller) {
                $this->layout = 'reseller';
            }
            if($model->load(Yii::$app->request->post())){
                if($model->validate()){
                    try{
                        $modeluser->password = $_POST['ChangeModel']['newpass'];
                            if($modeluser->save()){
                                \Yii::$app->session->setFlash('consol_v_error',\Yii::t('app/consol', 'Password successfully updated'));
                                if ($isReseller) {
                                    return $this->redirect('@reseller_profile');
                                }
                                return $this->redirect('/profile');
                            }
                        }
                    catch(Exception $e){
                        return $this->render('change-password',[
                            'model'=>$model,
                            'lang'=>$lang_path,
                        ]);
                    }
                }
                else{
                    $model->oldpass       = null;
                    $model->newpass       = null;
                    $model->repeatnewpass = null;
                    return $this->render('change-password',[
                        'model'=>$model,
                        'lang'=>$lang_path,
                        ]);
                    }
            }
            else{
                return $this->render('change-password',[
                    'model'=>$model,
                    'lang'=>$lang_path,
                ]);
            }
        }
    }

    /**
     * Renders prices page
     *
     * @return mixed
     */
    public function actionPrice()
    {
        $daysProducts = Product::findByType(Product::TYPE_DAILY)
            ->andWhere(['status' => Product::STATUS_ACTIVE])
            ->all();
        $limitProducts = Product::findByType(Product::TYPE_LIMITED)
            ->andWhere(['status' => Product::STATUS_ACTIVE])
            ->all();

        $url_lang = explode('-', Yii::$app->language);
        $lang_path = $url_lang[0];
        $title = $this->pages->getPageTitle($this->param);
        $meta = $this->pages->getPageMetaData($this->param);

        $hosts = $this->hosts->getAllHosts();

        //Save current URL to be able to go back if user cancels order
        Url::remember(Url::current());

        if (!Yii::$app->user->isGuest) {
            $plan = Yii::$app->user->identity->plan;
        } else {
            $plan = null;
        }

        return $this->render('price', [
            'lang_path' => $lang_path,
            'title' => $title,
            'meta' => $meta,
            'hosts' => $hosts,
            'daysProducts' => $daysProducts,
            'limitProducts' => $limitProducts,
            'plan' => $plan
        ]);
    }

    /**
     * Renders Contact us page. Handles contact form submition.
     * Displays Site ContactUs page.
     * @return mixed
     */
    public function actionContact()
    {
        $title = $this->pages->getPageTitle($this->param);
        $meta =$this->pages->getPageMetaData($this->param);
        $contactForm = new ContactForm();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $post['reCaptchaResp'] = Yii::$app->request->post('g-recaptcha-response', null);

            $contactForm->load($post, '');
            if ($contactForm->send()) {
                try {
                    $this->contact_us_messages->createNewSupportMessage(Yii::$app->request->post());
                } catch (RuntimeException $e) {
                    throw new RuntimeException("Support Messages not saved");

                }
                \Yii::$app->session->setFlash('consol_v_error',\Yii::t('app/consol', 'Contact Form successfully submitted,Thank you,i will get back to you soon!'));
                $contactForm = new ContactForm();
            }
        }
        return $this->render('contact', ['contactForm' => $contactForm,'meta'=>$meta,'title'=>$title]);
    }

    /**
     * Change Language
     *
     * @return mixed
     */

    public function actionChangelanguage(){
        $lang_url = Yii::$app->request->get('lang');
        $pathInfo = Yii::$app->request->get('pathInfo');
        $to = '';
        if($pathInfo != '/') {
            $to = str_replace(substr($pathInfo, strpos($pathInfo, '/') + 1, 2), $lang_url, $pathInfo);
        } else {
            $to = $pathInfo . $lang_url;
        }
        return $this->redirect($to);
    }

    /**
    * Renders User Dashboard Supported payment methods page
    *
    * @return mixed
    */
    public function actionSupportedPaymentMethods ()
    {
        $this->layout = 'main';

        $title = $this->pages->getPageTitle($this->param);
        $meta = $this->pages->getPageMetaData($this->param);
        $url_lang = explode('-', Yii::$app->language);
        $lang_path = $url_lang[0];
        $hosts = $this->hosts->getAllHosts();
        return $this->render('supported-payment',['hosts'=>$hosts,'lang'=>$lang_path,'title'=>$title,'meta'=>$meta]);
    }
}
