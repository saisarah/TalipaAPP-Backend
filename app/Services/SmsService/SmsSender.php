<?php

namespace App\Services\SmsService;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void sendMessage($to, $message)
 */
class SmsSender extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sms';        
    }
}
