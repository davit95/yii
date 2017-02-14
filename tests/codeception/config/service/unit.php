<?php

/**
 * Application configuration for service unit tests
 */
$config = yii\helpers\ArrayHelper::merge(
    require(YII_APP_BASE_PATH . '/common/config/main.php'),
    require(YII_APP_BASE_PATH . '/common/config/main-local.php'),
    require(YII_APP_BASE_PATH . '/service/config/main.php'),
    require(YII_APP_BASE_PATH . '/service/config/main-local.php')
);

$config['components']['storage'] = [];

return yii\helpers\ArrayHelper::merge(
    $config,
    require(dirname(__DIR__) . '/config.php'),
    require(dirname(__DIR__) . '/unit.php'),
    require(__DIR__ . '/config.php'),
    [
    ]
);
