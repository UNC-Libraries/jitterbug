<?php

return [

    'stores' => [
        'file' => [
            'driver' => 'file',
            'path' => env('STORAGE_PATH', storage_path()).'/framework/cache',
        ],
    ],

];
