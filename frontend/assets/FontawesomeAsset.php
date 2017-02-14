<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Font aswesome asset
 */
class FontawesomeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/fa/css/font-awesome.css',
    ];
}
