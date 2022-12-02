<?php

return [
    'default' => env("SMS_DRIVER", "log"), //log | movider
    
    'drivers' => [
        'movider' => [
            'api_key' => env("MOVIDER_API_KEY"),
            'api_secret' => env("MOVIDER_API_SECRET"),
            'from' => 'MOVIDER',
        ]
    ]
];
