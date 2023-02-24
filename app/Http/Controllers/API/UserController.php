<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getCurrentUser()
    {
        return Auth::user();
    }

    public function show(User $user)
    {
        return $user;
    }

    public function showBalance()
    {
        return auth()->user()->checkBalance();
    }

    public function showCompleteAddress()
    {
        return auth()->user()->completeAddress();
    }
}
