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

        if ($group !== null) {
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

    public function invite(Request $request, $id)
    {
        $user = Auth::user();
        $group = FarmerGroupMember::where('farmer_id', $user->id)->first();
        $member = FarmerGroupMember::where('farmer_id', $id)->first();

        if (!$member->isPresident() && $group == null) {

            return abort(403, "Access to the requested resource has been denied.");
        }

        if ($member->isPending() || $member->isInvited() || $member->isPresident()) {

            return abort(400, "Invitation failed: User is already a part of different group");
        }

        $invite = new FarmerGroupMember();
        $invite->farmer_group_id = $id;
        $invite->farmer_id = $request->farmer_id;
        $invite->role = FarmerGroupMember::ROLE_MEMBER;
        $invite->membership_status = FarmerGroupMember::STATUS_INVITED;
        $invite->save();

        return "Invitation sent sucessfully";
    }
}
