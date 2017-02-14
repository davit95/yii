<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Fonts asset
 */
class FontsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://fonts.googleapis.com/css?family=Roboto:400,100,300,300italic,400italic,500,500italic,700,700italic,900,900italic',
    ];
}
