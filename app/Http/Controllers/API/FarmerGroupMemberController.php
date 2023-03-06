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
        $president = FarmerGroupMember::where('farmer_id', $user->id)
            ->where('farmer_group_id', $id)
            ->where('role', FarmerGroupMember::ROLE_PRESIDENT)
            ->first();
        $group = FarmerGroupMember::where('farmer_id', $request->farmer_id)
            ->where('farmer_group_id', $id)
            ->first();
        $status = FarmerGroupMember::where('farmer_id', $request->farmer_id)
            ->first();

        if ($president == null) {
            return abort(403, "Access to the requested resource has been denied.");
        }

        if (($group !== null && $group->isPending()) || ($group !== null && $group->isInvited())) {
            $group->update([
                'membership_status' => FarmerGroupMember::STATUS_APPROVED
            ]);
            return  $group;
        }

        if (($status !== null && $status->isPending()) || ($status !== null && $status->isApproved())) {

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
