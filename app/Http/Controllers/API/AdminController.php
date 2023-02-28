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

        $user->address =  new Address();
        $user->address->user_id = $user->id;
        $user->address->region = $request->region;
        $user->address->province = $request->province;
        $user->address->municipality = $request->municipality;
        $user->address->barangay = $request->barangay;
        $user->address->street = $request->street;
        $user->address->house_number = $request->house_number;
        $user->address->save();

        return $user;
    }
}
