<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Jitsi\Jitsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JitsiController extends Controller
{
    public function meet(User $user, Jitsi $jitsi)
    {
        return [
            $jitsi->generateToken(Auth::user()),
            $jitsi->generateToken($user),
        ];
    }
}
