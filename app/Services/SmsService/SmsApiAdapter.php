<?php

namespace App\Services\SmsService;

use Illuminate\Support\Facades\Http;

abstract class SmsApiAdapter extends SmsAdapter
{

    // protected string $method = 'POST';
    protected string $url;
    protected string $send_to_param_name;
    protected string $message_param_name;
    protected $params = [];
    protected $headers = [];
    private $client;
    protected $request_type = "json";

    public function __construct()
    {
        $this->client = 
            $this->request_type === "form"
                ? Http::asForm()
                : Http::asJson();
    }

    public function sendMessage($to, $message)
    {
        return $this->client->withHeaders($this->headers)
            ->post($this->url, $this->getParams($to, $message));
    }

    private function getParams($to, $message)
    {
        $params = $this->params;
        $params[$this->send_to_param_name] = $to;
        $params[$this->message_param_name] = $message;
        return $params;
    }
}