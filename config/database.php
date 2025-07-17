<?php

return [

    'fetch' => PDO::FETCH_CLASS,

    'connections' => [
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => storage_path().'/database.sqlite',
            'prefix' => '',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
        ],
    ],

    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => false, // disable to preserve original behavior for existing applications
    ],

    'redis' => [

        'cluster' => false,

        'default' => [
            'host' => '127.0.0.1',
            'port' => 6379,
            'database' => 0,
        ],

    ],

];
