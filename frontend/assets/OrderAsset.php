<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Order asset
 */
class OrderAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        '/js/order.js',
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_END
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'frontend\assets\BootstrapAsset',
        'frontend\assets\FontawesomeAsset',
        'frontend\assets\FontsAsset',
        'frontend\assets\AppAsset'
    ];
}
