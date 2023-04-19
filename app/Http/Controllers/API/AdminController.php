<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAdminRequest;
use App\Models\Admin;
use App\Models\User;
use App\Services\Address\Address;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function createAdmin(CreateAdminRequest $request)
    {
        $user = new User();
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->contact_number = $request->contact_number;
        $user->email = $request->email;
        $user->user_type = User::TYPE_ADMIN;
        $user->gender = $request->gender;
        $user->password = bcrypt($request->password);
        $user->save();

        $user->admin = new Admin();
        $user->admin->user_id = $user->id;
        $user->admin->role = $request->role;
        $user->admin->save();

        return $user;
    }
}
