<?php
/**
 * Application configuration for all service test types
 */
return [
    'components' => [
        'service' => [
            'class' => 'service\components\Service'
        ],
        'storage' => [
            'class' => 'service\components\storages\LocalStorage',
            'root' => 'c:/storage'
        ],
        'statistic' => [
            'class' => 'service\components\statistics\Statistic',
            'events' => [
            ]
        ]
    ],
    'params' => [
        'adminEmail' => 'admin@example.com',
        'serviceUid' => 'gXP9B9qd4Y',
        'serviceName' => 'plg.svc.01',
        'encryptKey' => 'iET1IM1GYh',
        'useragentXml' => __DIR__.'/../../service/_data/useragentswitcher.xml',
        'proxiesXml' => __DIR__.'/../../service/_data/proxylist.xml',
        'jwtSecretKey' => 'O7YoMyNuzU'
    ],
];
