<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MainAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'css/styles.css',
        'css/fa/css/font-awesome.css',
        'css/profile.css',
        'https://fonts.googleapis.com/css?family=Roboto:400,100,300,300italic,400italic,500,500italic,700,700italic,900,900italic',
    ];
    public $depends = [
        '\yii\web\YiiAsset',
        '\yii\bootstrap\BootstrapAsset',
    ];
    public $js = [
        'js/app.js',
        'js/home-page.js',
        'js/bootstrap.min.js',
        'js/profile.js',
        '/js/action.js',
        'https://www.google.com/recaptcha/api.js',
    ];
    public $jsOptions = array(
     'position' => \yii\web\View::POS_END ,
    ); 
}