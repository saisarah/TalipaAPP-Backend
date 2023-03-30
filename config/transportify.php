<?php

return [
    'mode' => env('TRANSPORTIFY_MODE', 'live'),
    
    'sandbox' => [
        'baseurl' => 'https://api.sandbox.deliveree.com/public_api/v1',
        'api_key' => env('TRANSPORTIFY_SANDBOX_API_KEY'),
    ],

    'live' => [
        'baseurl' => 'https://api.deliveree.com/public_api/v1',
        'api_key' => env('TRANSPORTIFY_API_KEY'),
    ],

    'forward_webhook_url' => env('TRANSPORTIFY_FORWARD_WEBHOOK_URL'),
];
