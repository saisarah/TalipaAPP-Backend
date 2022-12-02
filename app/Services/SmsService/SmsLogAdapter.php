<?php

namespace App\Services\SmsService;

use Illuminate\Support\Facades\Log;

class SmsLogAdapter extends SmsAdapter
{
    public function sendMessage($to, $message)
    {
        Log::info("Outgoing SMS Message", compact('to', 'message'));
    }
}