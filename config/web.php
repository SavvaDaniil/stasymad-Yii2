<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mail.hosting.reg.ru',
                'username' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
                'password' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
                //'port' => '587',
                'port' => '465',
                'encryption' => 'ssl',
            ],
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
        'db' => $db,
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            "enableStrictParsing" => true,
            'rules' => [
                "/" => "site/index",
                "/contacts" => "site/contacts",
                "/api/contacts" => "api/contacts",
                "/privacy" => "site/privacy",
                "/terms" => "site/terms",
                "/exotic" => "site/exotic",
                "/strip" => "site/strip",
                "/acrobatics" => "site/acrobatics",

                "/api/test" => "/api/test/index",

                "/cart" => "cart/index",
                "/api/cart/add" => "api/cart/add",
                "/api/cart/remove" => "api/cart/remove",


                "/login" => "site/login",
                "/api/login" => "api/login",
                "/logout" => "site/logout",

                "/forget" => "site/forget",
                "/api/forget" => "api/forget/index",

                "/registration" => "site/registration",
                "/api/registration" => "api/registration/index",
                
                "/contact" => "site/contact",

                "/account" => "account/index",
                "/api/account/save" => "api/account/save",
                "/api/account/getvideo" => "api/account/getvideo",
                "/api/account/updatevideoplay" => "api/account/updatevideoplay",

                "/payment" => "payment/index",
                "/payment/check" => "payment/check",
                "/payment/cansel" => "payment/cansel",
                "/payment/success" => "payment/success",
                "/payment/error" => "payment/error",

                "/api/paypal/createorder" => "api/paypal/createorder",
                "/api/paypal/getorder" => "api/paypal/getorder",
            ],
        ],
        
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
