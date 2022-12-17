<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\FarmerRegisterRequest;
use App\Http\Requests\Auth\VendorRegisterRequest;
use App\Models\Address;
use App\Models\Farmer;
use App\Models\User;
use App\Models\Vendor;
use App\Services\SmsService\SmsOtp\RegisterOtp;
use App\Services\SmsService\SmsOtp\SmsOtp;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function registerFarmer(FarmerRegisterRequest $request)
    {

        $otp = new RegisterOtp($request->contact_number);

        if (!$otp->verify($request->code)) {
            return abort(422, "Wrong verification code");
        }


        $user = new User();
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->contact_number = $request->contact_number;
        $user->email = $request->email;
        $user->user_type = User::TYPE_FARMER;
        $user->gender = $request->gender;
        $user->password = bcrypt($request->password);
        $user->save();


        $user->farmer = new Farmer();
        $user->farmer->user_id = $user->id;
        $user->farmer->farm_area = $request->farm_area;
        $user->farmer->farm_type = $request->farm_type;
        $user->farmer->ownership_type = $request->ownership_type;
        $user->farmer->document_type = $request->document_type;
        $user->farmer->document = $request->file('document')->store('farmers/authorization');
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

        $otp = new RegisterOtp($request->contact_number);

        if (!$otp->verify($request->code)) {
            return abort(422, "Wrong verification code");
        }

        $user = new User();
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->contact_number = $request->contact_number;
        $user->email = $request->email;
        $user->user_type = User::TYPE_VENDOR;
        $user->gender = $request->gender;
        $user->password = bcrypt($request->password);
        $user->save();

        $user->vendor = new Vendor();
        $user->vendor->user_id = $user->id;
        $user->vendor->authorization = $request->file('document')->store('vendors/authorization');
        $user->vendor->save();


        // $user->farmer = new Farmer();
        // $user->farmer->user_id = $user->id;
        // $user->farmer->farm_area = $request->farm_area;
        // $user->farmer->farm_type = $request->farm_type;
        // $user->farmer->ownership_type = $request->ownership_type;
        // $user->farmer->document_type = $request->document_type;
        // $user->farmer->document = $request->file('document')->store('farmers/authorization');
        // $user->farmer->save();

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

    public function validator(Request $request)
    {
        $this->validate($request, [
            'email' => 'sometimes|nullable|email|unique:users',
            'phone' => 'sometimes|digits:10|numeric|unique:users,contact_number'
        ]);

        return true;
    }

    public function sendOTP(Request $request)
    {
        $this->validate($request, [
            'contact_number' => ['required', 'numeric', 'digits:10'],
        ]);
        $otp = new RegisterOtp($request->contact_number);
        $otp->send();
        return response()->noContent();
    }
}
