<?php

use App\Services\SmsService\SmsLogAdapter;
use App\Services\SmsService\SmsMoviderAdapter;
use App\Services\SmsService\SmsTwilioAdapter;

return [
    'default' => env("SMS_DRIVER", "log"), //log | movider
    
    'drivers' => [
        'movider' => [
            'api_key' => env("MOVIDER_API_KEY"),
            'api_secret' => env("MOVIDER_API_SECRET"),
            'from' => 'MOVIDER',
            'adapter' => SmsMoviderAdapter::class,
        ],
        'log' => [
            'adapter' => SmsLogAdapter::class,
        ],
        'twilio' => [
            'adapter' => SmsTwilioAdapter::class,
            'sid' => env('TWILIO_ACCOUNT_SID'),
            'token' => env('TWILIO_AUTH_TOKEN'),
            'from' => env('TWILIO_PHONE_NUMBER'),
        ]
    ]
];
