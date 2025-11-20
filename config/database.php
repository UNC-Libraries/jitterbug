<?php

return [

    'fetch' => PDO::FETCH_CLASS,

    'connections' => [
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => storage_path().'/database.sqlite',
            'prefix' => '',
            'url' => env('DB_URL'),
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
            'busy_timeout' => null,
            'journal_mode' => null,
            'synchronous' => null,
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
            'url' => env('DB_URL'),
            'port' => env('DB_PORT', '3306'),
            'unix_socket' => env('DB_SOCKET', ''),
            'prefix_indexes' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
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
            'url' => env('REDIS_URL'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
        ],

    ],

];
