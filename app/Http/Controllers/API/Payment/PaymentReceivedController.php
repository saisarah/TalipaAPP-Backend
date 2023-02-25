<?php

namespace App\Http\Controllers\API\Payment;

use App\Http\Controllers\Controller;
use App\Models\PaymongoTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Luigel\Paymongo\Facades\Paymongo;

class PaymentReceivedController extends Controller
{
    public function __invoke(Request $request)
    {
        Log::channel('wallet')->info("Webhook triggered", $request->all());
        $payment_intent_id = $request->data['attributes']['data']['attributes']['payment_intent_id'];
        Log::debug('payment_intent_id', compact('payment_intent_id'));
        $transaction = PaymongoTransaction::find($payment_intent_id);
        $transaction->deposit();

        return response()->noContent();
    }
}
