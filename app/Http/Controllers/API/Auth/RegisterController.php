<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\FarmerRegisterRequest;
use App\Http\Requests\Auth\VendorRegisterRequest;
use App\Models\Address;
use App\Models\Farmer;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function registerFarmer(FarmerRegisterRequest $request)
    {

        $user = new User();
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->contact_number = $request->contact_number;
        $user->email = $request->email;
        $user->user_type = User::TYPE_FARMER;
        $user->gender = $request->gender;
        $user->save();


        $user->farmer = new Farmer();
        $user->farmer->user_id = $user->id;
        $user->farmer->farm_area = $request->farm_area;
        $user->farmer->farm_type = $request->farm_type;
        $user->farmer->ownership_type = $request->ownership_type;
        $user->farmer->save();

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

    public function registerVendor(VendorRegisterRequest $request)
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

    public function validator(Request $request)
    {
        $this->validate($request, [
            'email' => 'sometimes|email|unique:users',
            'phone' => 'sometimes|digits:10|numeric|unique:users,contact_number'
        ]);

        return true;
    }
}
