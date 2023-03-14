<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SmsService\SmsOtp\ForgotPasswordOtp;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function sendOtp(Request $request)
    {
        $this->validate($request, [
            'contact_number' => 'required|exists:users'
        ]);

        $otp = new ForgotPasswordOtp($request->contact_number);
        $otp->send();

        return response()->noContent();
    }

    public function verifyOtp(Request $request)
    {
        $this->validate($request, [
            'contact_number' => 'required|exists:users',
            'code' => 'required|numeric'
        ]);
        
        $otp = new ForgotPasswordOtp($request->contact_number);
        if (!$otp->verify($request->code))
            return abort(400, "Invalid Verfification Code");
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'contact_number' => 'required|exists:users',
            'code' => 'required|numeric',
            'password' => 'required|confirmed|min:8'
        ]);

        $user = User::where('contact_number', $request->contact_number)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->noContent();
    }
}
