<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'plg-service',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'service\controllers',
    'bootstrap' => ['log', 'statistic'],
    'modules' => [
        'api' => [
            'class' => 'service\modules\api\v1\Module'
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => 'service\components\identities\User',
            'enableAutoLogin' => false,
            'enableSession' => false
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache'
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning'],
                    'logTable' => '{{%logs}}'
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'error/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                //Content controller
                'content/download/<hash:[a-zA-z0-9]+>' => 'content/download',
                'content/stream/<hash:[a-zA-z0-9]+>' => 'content/stream',
                //API Link controller
                'api/link/delete/<id:\d+>' => 'link/delete',
                //API Content provider controller
                'api/content-provider/get/<id:\d+>' => 'api/content-provider/get',
                'api/content-provider/get-credentials/<id:\d+>' => 'api/content-provider/get-credentials',
                'api/content-provider/is-alive/<id:\d+>' => 'api/content-provider/is-alive',
                'api/content-provider/update/<id:\d+>' => 'api/content-provider/update',
                'api/content-provider/delete/<id:\d+>' => 'content-provider/delete',
                //API Credential controller
                'api/credential/get/<id:\d+>' => 'api/credential/get',
                'api/credential/update/<id:\d+>' => 'api/credential/update',
                'api/credential/delete/<id:\d+>' => 'api/credential/delete',
                'api/credential/bind/<id:\d+>' => 'api/credential/bind',
                'api/credential/unbind/<id:\d+>' => 'api/credential/unbind',
                //API Stored content controller
                'api/stored-content/get/<id:\d+>' => 'api/stored-content/get',
                'api/stored-content/get-chunks/<id:\d+>' => 'api/stored-content/get-chunks',
                'api/stored-content/update/<id:\d+>' => 'api/stored-content/update',
                'api/stored-content/delete/<id:\d+>' => 'api/stored-content/delete',
                //API Statistic controller
                'api/statistic/get/<indexName:[a-zA-z0-9_]+>' => 'api/statistic/get',
                //API Log controler
                'api/log/view/<id:\d+>' => 'api/log/view'
            ],
        ],
        'service' => [
            'class' => 'service\components\Service'
        ],
        'storage' => [
            //Local storage
            'class' => 'service\components\storages\LocalStorage',
            'root' => 'local_storage'
            //Ftp storage
            /*'class' => 'service\components\storages\FtpStorage',
            'host' => '127.0.0.1',
            'port' => '21',
            'username' => 'plgtest',
            'password' => '123123',
            'root' => 'storage',*/
            //MongoDb storage
            /*'class' => 'service\components\storages\MongoStorage',
            'dsn' => 'mongodb://storage:rebel15@92.222.91.252:27017/storage',
            'root' => 'fs'*/
            //sFtp storage
            /*'class' => 'service\components\storages\SftpStorage',
            'host' => '92.222.91.252',
            'port' => '22',
            'username' => 'storage',
            'password' => 'rebel15',
            'root' => 'home/storage/content'*/
        ],
        'statistic' => [
            'class' => 'service\components\statistics\Statistic',
            'events' => [
                'sended_content_amount' => [
                    \service\components\behaviors\DownloadBehavior::EVENT_AFTER_DOWNLOAD,
                    \service\components\behaviors\StreamBehavior::EVENT_AFTER_STREAM
                ],
                'sended_content_attrs' => [
                    \service\components\behaviors\DownloadBehavior::EVENT_AFTER_DOWNLOAD,
                    \service\components\behaviors\StreamBehavior::EVENT_AFTER_STREAM
                ],
                'used_credentials' => \service\components\contents\ProviderContent::EVENT_USE_CREDENTIALS
            ]
        ]
    ],
    'aliases' => [
    ],
    'params' => $params,
];
