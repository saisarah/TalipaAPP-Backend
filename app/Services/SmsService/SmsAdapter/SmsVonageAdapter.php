<?php

namespace App\Services\SmsService\SmsAdapter;

use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;

class SmsVonageAdapter extends SmsAdapter
{

    private $client;

    public function __construct()
    {
        $key = config('sms.drivers.vonage.key');
        $secret = config('sms.drivers.vonage.secret');
        $basic = new Basic($key, $secret);
        $this->client = new Client($basic);
    }

    public function sendMessage($to, $message)
    {
        return $this->client->sms()->send(
            new SMS($to, config('app.name'), $message)
        );
    }
}
