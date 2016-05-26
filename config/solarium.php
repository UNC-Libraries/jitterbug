<?php

return [
    'endpoint' => array(
        env('SOLR_ENDPOINT') => array(
            'host' => env('SOLR_HOST'),
            'port' => env('SOLR_PORT'),
            'path' => env('SOLR_PATH')
        )
    )
];
