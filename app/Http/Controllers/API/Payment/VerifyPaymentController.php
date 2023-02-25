<?php

namespace App\Http\Controllers\API\Payment;

use App\Http\Controllers\Controller;
use App\Models\PaymongoTransaction;
use Illuminate\Http\Request;

class VerifyPaymentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(PaymongoTransaction $transaction)
    {
        $transaction->deposit();

        return $transaction;
    }
}
