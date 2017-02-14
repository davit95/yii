<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'plg-app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'user/index',
    'components' => [
        /*'client' => [
            'class' => 'frontend\components\payment\client',
        ],*/
        /*'PaymentRequest' => [
            'class' => 'frontend\components\payment\PaymentRequest',
        ],*/
        /*'Response' => [
            'class' => 'frontend\components\payment\Response',
        ],*/
        'request' => [
            'class' => 'frontend\components\languages\LangRequest'
        ],
        'mailservice' => [
            'class' => 'frontend\components\MailService\MailService'
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'enableSession' => true,
            'loginUrl' => '/login'
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'error/error',
        ],
        'urlManager' => [
            'baseUrl' => '/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'class'=>'frontend\components\languages\LangUrlManager',
            'rules' => [
                //Auth pages
                'register' => 'auth/register',
                'login' => 'auth/login',
                //User pages
                'profile'=>'user/profile',
                'overviews'=>'user/overviews',
                'forum'=>'user/forum',
                'contact'=>'user/contact',
                'price'=>'user/price',
                'change-password'=>'user/change-password',
                'supported-payment-methods'=>'user/supported-payment-methods',
                'payment-details'=>'payment-details',
                'affiliate-terms'=>'payment-details/affiliate-terms',
                //Site pages
                '/'=>'site',
                'work'=>'site/work',
                'hosts/<name:[a-zA-z0-9\-]+>'=>'site/hosts-landing',
                'privacy-policy'=>'site/privacy-policy',
                'refund-policy'=>'site/refund-policy',
                'uptime'=>'site/uptime',
                'dmca'=>'site/dmca',
                'terms'=>'site/terms',
                'about'=>'site/about',
                'supported-hosts'=>'site/hosts',
                //Profile referral section
                'referral' => 'referral',
                'referral/render-earnings' => 'referral/render-earnings',
                'referral/download-invoice' => 'referral/download-invoice',
                //Profile transactions section
                'transactions' => 'transaction',
                'transactions/download-invoice' => 'transaction/download-invoice',
                //Profile downloads
                'download' => 'download/download',
                'download/links-list' => 'download/links-list',
                'download/unrestrain-link' => 'download/unrestrain-link',
                'my-downloads' => 'download/my-downloads',
                'my-downloads/delete-unrestrained-link' => 'download/delete-unrestrained-link',
                //Orders
                'order/create/product/<id:\d+>' => 'order/create-for-product',
                'order/create/voucher/<id:\d+>' => 'order/create-for-voucher',
                'order/checkout/<id:\d+>'=>'order/checkout',
                //Profile credits section
                'credits' => 'credits/index',
                //Content proxy routes
                'dl/<hash:[a-zA-z0-9]+>' => 'proxy/process-download',
                's/<hash:[a-zA-z0-9]+>' => 'proxy/process-stream',
                //Reseller profile
                'reseller' => 'reseller/my-account',
                'reseller/voucher/<id:\d+>' => 'reseller/voucher',
                'reseller/pay-voucher/<id:\d+>' => 'reseller/pay-voucher'
            ],
        ],
        'language'=>'en-En',
        'i18n' => [
        'translations' => [
            '*' => [
                'class' => 'yii\i18n\DbMessageSource',
                'sourceMessageTable'=>'{{%source_message}}',
                'messageTable'=>'{{%message}}',
                'enableCaching' => true,
                'cachingDuration' => 3600,
                'forceTranslation'=>true,
                'sourceLanguage' => 'ru_Ru'
            ],
        ],
    ],
    ],
    'params' => $params,
    'aliases' => [
        //Profie referral section
        'profile_referral' => '/referral',
        'profile_render_earnings' => '/referral/render-earnings',
        'profile_referral_download_invoice' => '/referral/download-invoice',
        //Profile transactions section
        'profile_my_transactions' => '/transactions',
        'profile_my_transactions_download_invoice' => '/transactions/download-invoice',
        //Profile my downloads
        'profile_my_downloads' => '/my-downloads',
        //Profile add credits
        'profile_add_credits' => '/credits',
        'profile_proc_voucher' => '/credits/process-voucher',
        //Reseller profile
        'reseller_profile' => 'reseller/my-account',
        'reseller_vouchers' => '/reseller/vouchers',
        'reseller_pay_vouchers' => '/reseller/pay-vouchers',
        'reseller_pay_voucher' => '/reseller/pay-voucher',
        'reseller_voucher' => '/reseller/voucher',
        'reseller_suspend_voucher' => '/reseller/suspend-voucher',
        'reseller_products' => '/reseller/products',
        //Orders
        'order_create' => '/order/create-for-product',
        'order_create_for_voucher' => '/order/create-for-voucher',
        'order_checkout' => '/order/checkout',
        'order_render_form' => '/order/render-order-form'
    ]
];
