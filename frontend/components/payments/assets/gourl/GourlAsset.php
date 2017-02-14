<?php

namespace frontend\components\payments\assets\gourl;

use yii\web\AssetBundle;

/**
 * Gourl payment gateway asset
 */
class GourlAsset extends AssetBundle
{
    public $sourcePath = '@frontend/components/payments/includes/';
    public $js = [
        'cryptoapi_php/cryptobox.min.js'
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_BEGIN
    ];
}
