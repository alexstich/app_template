<?php

use yii\helpers\ArrayHelper;

$params = require __DIR__ . '/conf.d/params.php';

$mainCommon = require __DIR__ . '/../../common/config/main.php';

$mainConsole = [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'fixture' => [
            'class' => \yii\console\controllers\FixtureController::class,
            'namespace' => 'common\fixtures',
        ],
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@console/migrations',
        ],
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];

$mainConsoleLocal = require __DIR__ . '/main-local.php';

return ArrayHelper::merge($mainCommon, $mainConsole, $mainConsoleLocal);
