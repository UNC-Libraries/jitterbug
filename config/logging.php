<?php

return [

    'channels' => [
        'single' => [
            'driver' => 'single',
            'path' => env('LOG_CHANNEL_PATH', storage_path('logs/laravel.log')),
            'level' => env('LOG_LEVEL', 'debug'),
            'replace_placeholders' => true,
        ],
    ],

];
