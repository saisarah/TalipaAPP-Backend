<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FarmerGroup;
use App\Models\FarmerGroupMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmerGroupController extends Controller
{
    public function index()
    {
        return FarmerGroup::withCount('members')->get();
    }

    public function show($id)
    {
        return FarmerGroup::find($id);
    }

    public function getCurrentGroup()
    {
        return Auth::user()->groups()->withCount('pendings')->first();
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

        if ($member !== null) {
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

    public function approved($id)
    {
        $user = Auth::user();
        $group = $user->farmer->member->farmer_group_id;
        $member = FarmerGroupMember::where('farmer_id', $id)
            ->where('farmer_group_id', $group)
            ->where('membership_status', FarmerGroupMember::STATUS_PENDING)
            ->first();

        if ($member !== null) {
            $member->update([
                'membership_status' => FarmerGroupMember::STATUS_APPROVED
            ]);
            return  $member;
        }

        return abort(400, "Invalid farmer");
    }

    public function invitation()
    {
        $id = Auth::id();
        $groups = FarmerGroupMember::where('farmer_id', $id)
            ->where('membership_status', FarmerGroupMember::STATUS_INVITED)
            ->get();

        return $groups;
    }

    public function pendingRequest()

    {
        $user = Auth::user();
        $id = $user->farmer->member->farmer_group_id;
        $group = FarmerGroupMember::query()
            ->with('user', 'user.address')
            ->where('farmer_group_id', $id)
            ->where('membership_status', FarmerGroupMember::STATUS_PENDING)
            ->get();

        return $group;
    }

    public function invitedMembers()
    {
        $user = Auth::user();
        $id = $user->farmer->member->farmer_group_id;
        $group = FarmerGroupMember::query()
            ->with('user')
            ->where('farmer_group_id', $id)
            ->where('membership_status', FarmerGroupMember::STATUS_INVITED)->get();

        return $group;
    }

    public function showPendingGroup()
    {
        $id = Auth::id();
        $group_member = FarmerGroupMember::query()
            ->where('farmer_id', $id)
            ->where('membership_status', FarmerGroupMember::STATUS_PENDING)
            ->first();

        if ($group_member == null) {
            return null;
        }

        return FarmerGroup::find($group_member->farmer_group_id);
    }
}
