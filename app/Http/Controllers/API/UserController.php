<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function getCurrentUser()
    {
        $user = Auth::user();
        if ($user->isVendor()) {
            $user->load('vendor', 'vendor.crops');
        } elseif ($user->isFarmer()) {
            $user->load('farmer', 'farmer.crops');
        }
        return $user;
    }

    public function show(User $user)
    {
        return $user;
    }

    public function thread(User $user)
    {
        return Auth::user()->thread($user)->load('users');
    }

    public function showBalance()
    {
        try {
            $pendingTransactions = PaymentTransaction::query()
                ->where('user_id', Auth::id())
                ->where('status', PaymentTransaction::STATUS_PENDING)
                ->get();
            $pendingTransactions->each(fn ($transaction) => $transaction->deposit());
        } catch (Exception $ex) {
            Log::error("Checking Pending Balance", [$ex->getMessage()]);
        }

        return auth()->user()->usableBalance();
    }

    public function transactions()
    {
        return auth()->user()->transactions;
    }

    public function showCompleteAddress()
    {
        return auth()->user()->completeAddress();
    }
}
