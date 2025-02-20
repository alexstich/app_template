<?php

// Получаем значения из переменных окружения
$appEnv = getenv('APP_ENV') ?: 'dev';
$appDebug = getenv('APP_DEBUG') !== false ? (bool)getenv('APP_DEBUG') : true;

defined('YII_DEBUG') or define('YII_DEBUG', $appDebug);
defined('YII_ENV') or define('YII_ENV', $appEnv);

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../common/config/bootstrap.php';
require __DIR__ . '/../config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    require __DIR__ . '/../config/main.php',
);

(new yii\web\Application($config))->run();
