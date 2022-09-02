<?php

return [
    'endpoint' => [
        env('SOLR_ENDPOINT') => [
            'host' => env('SOLR_HOST'),
            'port' => env('SOLR_PORT'),
            'path' => env('SOLR_PATH'),
        ],
    ],
];
