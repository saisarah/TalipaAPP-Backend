<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FarmerGroup;
use App\Models\FarmerGroupMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmerGroupMemberController extends Controller
{
    public function join($id)
    {
        $user = Auth::user();
        $group = FarmerGroupMember::where('farmer_id', $user->id)->first();
        
        if($group->isApproved()|| $group->isPending())
        {
            return abort(400, "You have reached the maximum number of joining group");

        }

            $joinGroup = new FarmerGroupMember();
            $joinGroup->farmer_group_id = $id;
            $joinGroup->farmer_id = Auth::id();
            $joinGroup->role = FarmerGroupMember::ROLE_MEMBER;
            $joinGroup->membership_status = FarmerGroupMember::STATUS_PENDING;
            $joinGroup->save();

            return $joinGroup;
        
    }
}
