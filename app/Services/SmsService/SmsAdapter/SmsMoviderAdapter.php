<?php

namespace App\Services\SmsService\SmsAdapter;

class SmsMoviderAdapter extends SmsApiAdapter
{
    protected string $url = 'https://api.movider.co/v1/sms';
    protected string $send_to_param_name = "to";
    protected string $message_param_name = "text";
    protected $headers = [];
    protected $request_type = "form";

    public function __construct()
    {
        $this->params = [
            'api_key' => config('sms.drivers.movider.api_key'),
            'api_secret' => config('sms.drivers.movider.api_secret'),
            'from' => config('sms.drivers.movider.from'),
        ];
        parent::__construct();
    }
}
