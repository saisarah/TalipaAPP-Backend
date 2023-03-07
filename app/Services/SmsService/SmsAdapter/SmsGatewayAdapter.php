<?php

namespace App\Services\SmsService\SmsAdapter;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsGatewayAdapter extends SmsAdapter
{
    public function sendMessage($to, $message)
    {
        $result = Http::get(config('sms.drivers.sms_gateway.host'), [
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