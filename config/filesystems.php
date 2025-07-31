<?php

return [

    'cloud' => 's3',

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => env('STORAGE_PATH', storage_path()).'/app',
            'throw' => false,
            'serve' => true,
            'report' => false,
        ],

        'rackspace' => [
            'driver' => 'rackspace',
            'username' => 'your-username',
            'key' => 'your-key',
            'container' => 'your-container',
            'endpoint' => 'https://identity.api.rackspacecloud.com/v2.0/',
            'region' => 'IAD',
            'url_type' => 'publicURL',
        ],
    ],

];
