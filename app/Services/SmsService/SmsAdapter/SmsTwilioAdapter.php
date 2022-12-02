<?php

namespace App\Services\SmsService\SmsAdapter;

use Twilio\Rest\Client;

class SmsTwilioAdapter extends SmsAdapter
{
    private $client = null;

    public function __construct()
    {
        $sid = config('sms.drivers.twilio.sid');
        $token = config('sms.drivers.twilio.token');

        $this->client = new Client($sid, $token);
    }

    public function sendMessage($to, $message)
    {
        return $this->client->messages->create($to, [
            "from" => config('sms.drivers.twilio.from'),
            "body" => $message,
        ]);
    }
}