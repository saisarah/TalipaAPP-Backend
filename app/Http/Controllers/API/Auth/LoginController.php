<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SmsService\SmsOtp\LoginOtp;
use App\Services\SmsService\SmsOtp\SmsOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function sendOtp(Request $request)
    {
        $validUser = User::where('contact_number', $request->contact_number)->exists();

        if (!$validUser)
            return abort(400, 'The number you entered is not registed on our database.');

        $otp = new LoginOtp($request->contact_number);
        $otp->send();

        return true;
    }

    public function verifyOtp(Request $request)
    {
        $otp = new LoginOtp($request->contact_number);

        if (!$otp->verify($request->code))
            return abort(400, 'Wrong Verification code');

        $user = User::where('contact_number', $request->contact_number)->firstOrFail();

        $token = $user->createToken($request->device_name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken,
        ];
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'contact_number' => 'required|exists:users',
            'password' => 'required',
        ], [
            'contact_number.exists' => "The contact number is not registed on Talipaapp"
        ]);

        $user = User::where('contact_number', $request->contact_number)->first();

        if (!Hash::check($request->password, $user->password)) 
            return abort(422, "The password is incorrect");

        $token = $user->createToken($request->server->get('HTTP_USER_AGENT'));

        return [
            'user' => $user,
            'token' => $token->plainTextToken,
        ];
    }

    public function loginAdmin(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $email)->first();

        if ($user === null) {
            return abort(400, "The email you entered did not match our record, Please try again");
        }
        if (!Hash::check($password, $user->password)) {
            return abort(400, "The password you've entered is incorrect");
        }
        $role = $user->user_type;
        if ($role != User::TYPE_ADMIN) {
            return abort(400, "The email or password you entered did not match our record, Please try again");
        }
        $token = $user->createToken($request->device_name);
        return [
            'user' => $user,
            'token' => $token->plainTextToken,
        ];
    }
}
