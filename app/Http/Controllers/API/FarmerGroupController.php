<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use App\Models\FarmerGroup;
use App\Models\FarmerGroupMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmerGroupController extends Controller
{
    public function index()
    {
        return FarmerGroup::all();
    }

    public function show($id)
    {
       return FarmerGroup::where('id', $id)->first();
    }
    
    public function getCurrentGroup()
    {
        $id = Auth::id();
        $group = FarmerGroupMember::where('farmer_id', $id)->first();
        if ($group == null)
        {
            abort(400, 'Join group first');
        }
        $group_id = $group->farmer_group_id;
        $curGroup = FarmerGroupMember::where('farmer_group_id', $group_id)->first();
        return $curGroup;
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' =>  'required',
            'year_founded' =>  'required|integer|digits:4',
            'type' => 'required',
            'authorization' => 'required',
            'contact_no' => 'required',
            'email' => 'required|email:rfc,dns'

        ]);

        $member = FarmerGroupMember::where('farmer_id', Auth::id())->first();

        if ($member !== null)
        {
            return abort(400, "Sorry, you have reached the maximum limit of groups allowed per user");
        }

        $group = new FarmerGroup();
        $group->name = $request->name;
        $group->address = $request->address;
        $group->year_founded = $request->year_founded;
        $group->type = $request->type;
        $group->authorization = $request->authorization;
        $group->group_description = $request->group_description;
        $group->contact_no = $request->contact_no;
        $group->email = $request->email;
        $group->status = FarmerGroup::STATUS_PENDING;
        $group->save();

        $member = new FarmerGroupMember();
        $member->farmer_group_id = $group->id;
        $member->farmer_id = Auth::id();
        $member->role = FarmerGroupMember::ROLE_PRESIDENT;
        $member->membership_status = FarmerGroupMember::STATUS_APPROVED;
        $member->save();
        
        return $group;

    }
}
