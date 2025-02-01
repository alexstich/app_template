<?php

use yii\helpers\ArrayHelper;

$params = require __DIR__ . '/conf.d/params.php';

$main = [
    'id' => 'ielts-api',
    'language' => 'en',
    'sourceLanguage' => 'en',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            'class' => 'api\components\ApiResponse',
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                $allowedDomains = [
                    'http://localhost:3000',
                ];
                
                if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowedDomains)) {
                    $response->headers->set('Access-Control-Allow-Origin', $_SERVER['HTTP_ORIGIN']);
                }
                
                $response->headers->set('Access-Control-Allow-Credentials', 'true');
                $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
                $response->headers->set('Access-Control-Allow-Headers', 'Authorization, X-Requested-With, Content-Type');
            },
        ],

        'user' => [
            'identityClass' => 'common\models\users\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'api/<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];

$mainLocal = require __DIR__ . '/main-local.php';

$config = ArrayHelper::merge($main, $mainLocal);

return $config;
