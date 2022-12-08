<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\FarmerRegisterRequest;
use App\Models\Farmer;
use App\Models\User;
use Illuminate\Http\Request;

class FarmerRegisterController extends Controller
{
    public function register(FarmerRegisterRequest $request)
    {
        $user = new User();
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->contact_number = $request->contact_number;
        $user->email = $request->email;
        $user->user_type = User::TYPE_FARMER;
        $user->gender = $request->gender;
        $user->profile_picture = $request->profile_picture;
        $user->save();


        $farmer = new Farmer();
        $farmer->user_id = $user->id;
        $farmer->farm_area = $request->farm_area;
        $farmer->farm_type = $request->farm_type;
        $farmer->ownership_type = $request->ownership_type;
        $farmer->save();

        return $user;
    }
}
