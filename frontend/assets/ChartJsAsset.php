<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * ChartJs asset
 */
class ChartJsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/chart.min.js'
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
}
