<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ChangePasswordController extends Controller
{
    public function update(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required|current_password:sanctum',
            'new_password' => ['required', Password::min(8)->mixedCase(), 'confirmed']
        ]);
        $user = Auth::user();

        $new_password = $request->new_password;

        $user->update(['password' => bcrypt($new_password)]);

        return response()->noContent();
    }
}
