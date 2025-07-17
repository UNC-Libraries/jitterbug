<?php

return [

    'connections' => [
        'iron' => [
            'driver' => 'iron',
            'host' => 'mq-aws-us-east-1.iron.io',
            'token' => 'your-token',
            'project' => 'your-project-id',
            'queue' => 'your-queue-name',
            'encrypt' => true,
        ],
    ],

];
