<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Google reCaptcha asset
 */
class ReCaptchaAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'https://www.google.com/recaptcha/api.js?hl=en'
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_END
    ];
}
