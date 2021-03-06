<?php
$_SERVER['SCRIPT_FILENAME'] = SERVICE_ENTRY_FILE;
$_SERVER['SCRIPT_NAME'] = SERVICE_ENTRY_URL;

/**
 * Application configuration for service functional tests
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
    require(dirname(__DIR__) . '/functional.php'),
    require(__DIR__ . '/config.php'),
    [
    ]
);
