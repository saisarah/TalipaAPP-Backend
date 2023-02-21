<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $confirm_password = $request->confirm_password;

        if (!Hash::check($old_password, $user->password))
        {
            abort(400, "Current password is incorrect");
        }
        if ($new_password != $confirm_password)
        {
            abort(400, "Password confirmation does not match.");
        }

    }
}
