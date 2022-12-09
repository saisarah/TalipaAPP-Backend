<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VendorRegisterRequest;
use App\Models\Address;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorRegisterController extends Controller
{
    public function register(VendorRegisterRequest $request)
    {
        $user = new User();
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->contact_number = $request->contact_number;
        $user->email = $request->email;
        $user->user_type = User::TYPE_VENDOR;
        $user->gender = $request->gender;
        $user->profile_picture = $request->profile_picture;
        $user->save();


        $vendor = new Vendor();
        $vendor->user_id = $user->id;
        $vendor->public_market_id = $request->public_market_id;
        $vendor->authorization = $request->authorization;
        $vendor->save();

        $address =  new Address();
        $address->user_id = $user->id;
        $address->region = $request->region;
        $address->province = $request->province;
        $address->municipality = $request->municipality;
        $address->barangay = $request->barangay;
        $address->street = $request->street;
        $address->house_number = $request->house_number;


        return $user;
    }
}
