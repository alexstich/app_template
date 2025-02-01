<?php

$components = [
    // Компонент для PostgreSQL
    'db' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'pgsql:host=db;port=5432;dbname=base_db;',
        'username' => 'postgres',
        'password' => 'postgres',
        'charset' => 'utf8',
        'enableSchemaCache' => true,
        'schemaCacheDuration' => 3600,
        'schemaCache' => 'cache',
    ],

    // Компонент для Redis
    'redis' => [
        'class' => 'yii\redis\Connection',
        'hostname' => 'redis', // имя сервиса из docker-compose
        'port' => 6379,
        'database' => 0,
        'retries' => 1,
    ],

    // Компонент кэширования через Redis
    'cache' => [
        'class' => 'yii\redis\Cache',
        'redis' => [
            'hostname' => 'redis',
            'port' => 6379,
            'database' => 0,
        ],
    ]
];

return $components;
