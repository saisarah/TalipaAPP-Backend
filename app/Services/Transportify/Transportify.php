<?php

namespace App\Services\Transportify;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Transportify
{
    private string $apiKey = '';
    private string $baseurl = '';
    
    
    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function setBaseUrl(string $baseurl)
    {
        $this->baseurl = $baseurl;
    }

    public function getVehicles()
    {
        $result = Cache::remember(
            'transportify:vehicles',
            now()->addDay(),
            fn() => $this->http()->get('/vehicle_types')->json(),

        );

        return $result['data'];
    }

    public function getQuote($vehicle_id, ...$addresses)
    {
        $result = $this->http()->post('/deliveries/get_quote', [
            'time_type' => 'now',
            'vehicle_type_id' => $vehicle_id,
            'locations' => collect($addresses)->map(fn($address) => compact('address'))
        ])->json();

        if (!array_key_exists('data', $result))
            throw new Exception($result['message']);

        return $result['data'];
    }

    private function http()
    {
        return Http::baseUrl($this->baseurl)
            ->withHeaders([
                'Authorization' => $this->apiKey,
                'Accept-Language' => 'en'
            ]);
    }
}