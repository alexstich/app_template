<?php

use yii\helpers\ArrayHelper;

$aliases = require __DIR__ . '/conf.d/aliases.php';
$components = require __DIR__ . '/conf.d/components.php';
$params = require __DIR__ . '/conf.d/params.php';
$mainLocal = require __DIR__ . '/main-local.php';

$main = [
    'aliases' => $aliases,
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => $components,
    'params' => $params,
];

$config = ArrayHelper::merge($main, $mainLocal);

return $config;