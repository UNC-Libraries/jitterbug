<?php

return [
    'endpoint' => array(
        env('SOLARIUM_ENDPOINT') => array(
            'host' => env('SOLARIUM_HOST'),
            'port' => env('SOLARIUM_PORT'),
            'path' => env('SOLARIUM_PATH')
        )
    )
];
