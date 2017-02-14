<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * User's profile asset
 */
class ProfileAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/profile.css',
    ];
    public $js = [
        'js/profile.js'
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_END
    ];
    public $depends = [
        'frontend\assets\AppAsset',
        'yii\web\JqueryAsset',
    ];
}
