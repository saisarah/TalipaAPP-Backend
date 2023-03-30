<?php

namespace App\Http\Controllers\API\Payment;

use App\Facades\Bux;
use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CashInBuxController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric|min:500',
            'return_url' => 'required|url',
            'id' => 'required'
        ]);

        $paymentIntent = Bux::checkout($request->amount, $request->return_url);

        PaymentTransaction::create([
            'id' => "bux_{$request->id}",
            'user_id' => auth()->id(),
            'amount' => $request->amount,
        ]);

        Log::channel('wallet')->info('Transaction Created', $paymentIntent);

        return response()->json($paymentIntent);
    }
}
