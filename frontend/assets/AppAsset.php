<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main application asset
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jquery-ui.css',
        'css/styles.css',
        'css/overrides.css',
        'css/bootstrap.min.css',
        'css/profile.css',
        'css/jquery-ui.structure.min.css',
        'css/jquery-ui.theme.min.css',
        'css/nprogress.css',
    ];
    public $js = [
        '/js/app.js',
        '/js/home-page.js',
        '/js/bootstrap.min.js',
        '/js/profile.js',
        '/js/action.js',
        '/js/chart.min.js',
        '/js/jquery-ui.js',
        'https://www.google.com/recaptcha/api.js',
        '/js/nprogress.js',
        '/js/clipboard.min.js'
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_END
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'frontend\assets\BootstrapAsset',
        'frontend\assets\FontawesomeAsset',
        'frontend\assets\FontsAsset'
    ];
}
