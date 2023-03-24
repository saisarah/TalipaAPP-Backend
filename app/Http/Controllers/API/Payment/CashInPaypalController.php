<?php

namespace App\Http\Controllers\API\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class CashInPaypalController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric|min:500',
            'return_url' => 'required|url'
        ]);
        
        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();        
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => $request->return_url,
                "cancel_url" => $request->return_url,
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "PHP",
                        "value" => $request->amount
                    ]
                ]
            ]
        ]);        
        return $response;
    }
}
