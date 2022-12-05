<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SmsService\SmsOtp\SmsOtp;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function sendOtp(Request $request)
    {
        $validUser = User::where('contact_number', $request->contact_number)->exists();

        if (!$validUser) 
            return abort(400, 'The number you entered is not registed on our database.');

        $otp = new SmsOtp($request->contact_number);
        $otp->send();

        return true;
    }

    public function verifyOtp(Request $request)
    {
        $otp = new SmsOtp($request->contact_number);

        if (!$otp->verify($request->code))
            return abort(400, 'Wrong Verification code');
        
        $user = User::where('contact_number', $request->contact_number)->firstOrFail();

        $token = $user->createToken($request->device_name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken,
        ];
    }
}
