<?php

namespace App\Services\SmsService\SmsAdapter;

abstract class SmsAdapter
{
    public abstract function sendMessage($to, $message);
    
}
