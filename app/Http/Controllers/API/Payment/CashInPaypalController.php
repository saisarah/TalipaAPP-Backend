<?php

namespace App\Http\Controllers\API\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use PayPal;
use App\Models\PaymentTransaction;

class CashInPaypalController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric|min:500',
            'return_url' => 'required|url'
        ]);
        $paypal = PayPal::setProvider();
        $paypal->getAccessToken();
        $paymentIntent = $paypal->createOrder([
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

        $id = $paymentIntent["id"];

        PaymentTransaction::create([
            'id' => "paypal_{$id}",
            'user_id' => auth()->id(),
            'amount' => $request->amount,
        ]);

        return $paymentIntent;
    }
}
