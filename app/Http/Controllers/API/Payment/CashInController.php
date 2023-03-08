<?php

namespace App\Http\Controllers\API\Payment;

use App\Http\Controllers\Controller;
use App\Models\PaymongoTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Luigel\Paymongo\Facades\Paymongo;

class CashInController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric',
            'return_url' => 'required|url'
        ]);

        $paymentIntent = Paymongo::paymentIntent()->create([
            'amount' => $request->amount,
            'payment_method_allowed' => ['gcash'],
            'description' => 'Cash in to TalipaAPP',
            'statement_descriptor' => 'TalipaAPP',
            'currency' => 'PHP',
        ]);

        $paymentMethod = Paymongo::paymentMethod()->create([
            'type' => 'gcash',
        ]);

        PaymongoTransaction::create([
            'id' => $paymentIntent->id,
            'user_id' => auth()->id(),
            'amount' => $request->amount * .975,
        ]);

        Log::channel('wallet')->info('Transaction Created', [$paymentIntent->id]);

        $attachedPaymentIntent = $paymentIntent->attach($paymentMethod->id, $request->return_url);

        // dd($attachedPaymentIntent);
        return response()->json($attachedPaymentIntent->next_action);
    }
}
