<?php
namespace frontend\controllers;

use Yii;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\LoginForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\di\Container;

/**
 * Site controller
 */
class SiteController extends Controller
{
    protected $container;
    
    public $hosts;
    public $pages;
    public $param;

    //Init and override Repositories
    public function init(){
        $this->container = new Container;
        $this->hosts =  $this->container->get('common\repositories\HostRepository');
        $this->pages = $this->container->get('common\repositories\PagesRepository');
    }

    /**
    * @inheritdoc
    */
    public function beforeAction($action)
    {
        $this->layout = 'main';
        $url_lang = explode('-', Yii::$app->language);
        $lang_path = $url_lang[0];
        if(Yii::$app->request->url=="/" || Yii::$app->request->url=='/'.$lang_path){
            $this->param = "homepage";
        }elseif(Yii::$app->request->url== '/'.$lang_path.'/'){
            $this->param = "homepage";
            $this->redirect('/'.$lang_path);
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
     * Renders Site home page
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $meta = $this->pages->getPageMetaData($this->param);
        $title = $this->pages->getPageTitle($this->param);
        $hosts = $this->hosts->getAllHosts();
        $popularHosts = $this->hosts->getPopularHosts(6);
        $url_lang = explode('-', Yii::$app->language);
        $lang_path = $url_lang[0];

        return $this->render('index', [
            'hosts' => $hosts,
            'popularHosts' => $popularHosts,
            'meta'=>$meta,
            'lang_path'=>$lang_path,
            'title'=>$title
        ]);
    }
    /**
     * Renders Site terms page
     * For add dynamic text will be used admin panel methods
     * @return mixed
     */
    public function actionTerms()
    {
        $title = $this->pages->getPageTitle($this->param);
        $meta = $this->pages->getPageMetaData($this->param);
        return $this->render('terms',['meta'=>$meta,'title'=>$title]);
    }

    /**
     * Renders Site DMCA page
     * For add dynamic text will be used admin panel methods
     * @return mixed
     */
    public function actionDmca()
    {
        $title = $this->pages->getPageTitle($this->param);
        $meta = $this->pages->getPageMetaData($this->param);
        return $this->render('dmca',['meta'=>$meta,'title'=>$title]);
    }

    /**
     * Renders Site RefundPolicy page
     * For add dynamic text will be used admin panel methods
     * @return mixed
     */
    public function actionRefundPolicy()
    {
        $title = $this->pages->getPageTitle($this->param);
        $meta =$this->pages->getPageMetaData($this->param);
        return $this->render('refundPolicy',['meta'=>$meta,'title'=>$title]);
    }

    /**
     * Renders Site PrivacyPolicy page
     * For add dynamic text will be used admin panel methods
     * @return mixed
     */
    public function actionPrivacyPolicy()
    {
        $title = $this->pages->getPageTitle($this->param);
        $meta =$this->pages->getPageMetaData($this->param);
        return $this->render('privacyPolicy', ['meta'=>$meta,'title'=>$title]);
    }

    /**
     * Renders Site how does it works page
     *
     * @return mixed
     */
    public function actionWork()
    {
        $title = $this->pages->getPageTitle($this->param);
        $meta = $this->pages->getPageMetaData($this->param);

        $hostsNum = $this->hosts->getAllHosts()->count();

        return $this->render('work', ['hostsNum' => $hostsNum,'meta'=>$meta,'title'=>$title]);
    }

    /**
     * Renders Site Supported file hosts page.
     *
     * @return mixed
     */
    public function actionHosts()
    {   
        $title = $this->pages->getPageTitle('hosts');
        $url_lang = explode('-', Yii::$app->language);
        $lang_path = $url_lang[0];
        $meta = $this->pages->getPageMetaData('hosts');

        $hosts = $this->hosts->getAllHosts();

        return $this->render('hosts', ['lang_path'=>$lang_path,'hosts' => $hosts,'meta'=>$meta,'title'=>$title]);
    }

      /**
     * Renders Site Uptime page.
     *
     * @return mixed
     */
    public function actionUptime()
    {
        $title = $this->pages->getPageTitle($this->param);
        $meta = $this->pages->getPageMetaData($this->param);
        $hosts = $this->hosts->getAllHosts()->all();
        return $this->render('overviews',['hosts'=>$hosts,'meta'=>$meta,'title'=>$title]);
    }

    /**
     * Renders Site About us page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        $title = $this->pages->getPageTitle($this->param);
        $meta = $this->pages->getPageMetaData($this->param);
        return $this->render('about',['meta'=>$meta,'title'=>$title]);
    }

    public function actionHostsLanding($name){
        $title = $this->pages->getPageTitle('hosts-landing');
        $meta = $this->pages->getPageMetaData('hosts-landing');
        $host = $this->hosts->getHostByName($name);
        $hosts = $this->hosts->getAllHosts();
        $popularHosts = $this->hosts->getPopularHosts(6);
        $url_lang = explode('-', Yii::$app->language);
        $lang_path = $url_lang[0];

        return $this->render('hosts-landing', [
            'host_obj'=>$host,
            'hosts' => $hosts,
            'popularHosts' => $popularHosts,
            'lang_path'=>$lang_path,
            'meta'=>$meta,
            'title'=>$title
        ]);
    }
}
