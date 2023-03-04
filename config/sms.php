<?php

use App\Services\SmsService\SmsAdapter\SmsGatewayAdapter;
use App\Services\SmsService\SmsAdapter\SmsLogAdapter;
use App\Services\SmsService\SmsAdapter\SmsMoviderAdapter;
use App\Services\SmsService\SmsAdapter\SmsTwilioAdapter;
use App\Services\SmsService\SmsAdapter\SmsVonageAdapter;

return [
    'default' => env("SMS_DRIVER", "log"), //log | movider
    
    'country_code' => '+63',

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
        'sms_gateway' => [
            'host' => env('SMSGATEWAY_HOST'),
            'adapter' => SmsGatewayAdapter::class,
        ],
        'twilio' => [
            'adapter' => SmsTwilioAdapter::class,
            'sid' => env('TWILIO_ACCOUNT_SID'),
            'token' => env('TWILIO_AUTH_TOKEN'),
            'from' => env('TWILIO_PHONE_NUMBER'),
        ],
        'vonage' => [
            'adapter' => SmsVonageAdapter::class,
            'key' => env('VONAGE_KEY'),
            'secret' => env('VONAGE_SECRET')
        ]
    ]
];
