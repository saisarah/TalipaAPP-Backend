<?php

namespace App\Services\SmsService\SmsAdapter;

use Illuminate\Support\Facades\Log;

class SmsLogAdapter extends SmsAdapter
{
    public function sendMessage($to, $message)
    {
        Log::channel('sms')->info("Outgoing SMS Message", compact('to', 'message'));
    }
}