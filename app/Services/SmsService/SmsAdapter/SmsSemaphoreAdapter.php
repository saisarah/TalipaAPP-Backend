<?php

namespace App\Services\SmsService\SmsAdapter;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsSemaphoreAdapter extends SmsAdapter
{
    const SEMAPHORE_ENDPOINT = "https://api.semaphore.co/api/v4/messages";
    
    public function sendMessage($to, $message)
    {
        $result = Http::post(self::SEMAPHORE_ENDPOINT, [
            'apikey' => config('sms.drivers.semaphore.apikey'),
            'number' => $to,
            'message' => $message
        ]);
        
        Log::channel('sms')->info("Outgoing SMS Message", [
            'to' => $to,
            'message' => $message,
            'result' => $result->body()
        ]);        
    }
}