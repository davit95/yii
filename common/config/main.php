<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'config' => [
            'class' => 'abhimanyu\config\components\Config',
            'tableName' => '{{%configs}}',
            'cacheId' => 'cache',
            'cacheKey' => 'config.cache',
            'cacheDuration' => 100,
        ],
        'auth' =>[
            'class'=>'common\modules\api_v1\v1\ApiService\Auth',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%rbac_auth_items}}',
            'itemChildTable' => '{{%rbac_auth_item_children}}',
            'assignmentTable' => '{{%rbac_auth_assignments}}',
            'ruleTable' => '{{%rbac_auth_rules}}',
        ],
        'serviceStatistic' => [
            'class' => 'common\components\statistics\service\Statistic',
            'useCache' => false,
            'cacheDuration' => 300
        ],
        /*'notificationHandler' =>[
            'class'=>'common\components\payment\NotificationHandler',
        ],*/
        'mailservice' => [
            'class' => 'frontend\components\MailService\MailService'
        ],
        'mailer'=> [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'plg.rebsrv.tk',
            'username' => 'support@premiumlinkgenerator.com',
            'password' => 'ZCv8FupsQw',
            'port' => '587',
            'encryption' => 'tls',
            'streamOptions' => [
                'ssl' =>
                    [
                        'allow_self_signed' => true,
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ]
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
            ],
        ],
    ],
    'modules' => [
        'v1_api' => [
            'class' => 'common\modules\api_v1\v1\Module',
        ],
    ],
];
