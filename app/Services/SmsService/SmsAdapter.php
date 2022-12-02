<?php

namespace App\Services\SmsService;

abstract class SmsAdapter
{
    public abstract function sendMessage($to, $message);

    public function sendOtp($type, $to, $message)
    {
        
    }
}
