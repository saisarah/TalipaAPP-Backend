<?php

namespace App\Services\SmsService;


class SmsSender 
{
    public static function sendMessage($to, $message)
    {
        $country_code = config('sms.country_code');
        $to = "{$country_code}{$to}";
        $sms = app()->make('sms');
        return $sms->sendMessage($to, $message);
    }

}
