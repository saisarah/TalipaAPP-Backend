<?php

namespace App\Services\Bux;

use Illuminate\Support\Facades\Http;

class Bux
{
    private string $apikey;
    private string $clientId;
    private string $clientSecret;
    private string $endpoint;

    public function __construct()
    {
        $this->apikey = config('bux.apikey');
        $this->clientId = config('bux.clientId');
        $this->clientSecret = config('bux.clientSecret');
        $this->endpoint = config('bux.endpoint');
    }

    public function checkout($amount, $redirect_url)
    {
        $result = $this->http()->post("/open/checkout", [
            'req_id' => str()->uuid(),
            'client_id'=> $this->clientId,
            'amount' => $amount,
            'description' => 'Cashin to Talipaapp',
            'notification_url' => $redirect_url,
            'redirect_url'=> $redirect_url,
            "enabled_channels" => [
                "711_direct",
                "grabpay",
                "gcash"
            ]
        ])->json();
        return $result;
    }

    public function find($id)
    {
        return $this->http()->get("/check_code", [
            "req_id" => $id,
            "client_id" => $this->clientId,
            "mode" => "API"
        ])->json();
    }

    private function http()
    {
        return Http::baseUrl($this->endpoint)
        ->withHeaders([
            'X-Api-Key' => $this->apikey
        ]);
    }
}