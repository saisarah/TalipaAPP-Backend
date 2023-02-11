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
        $curGroup = FarmerGroupMember::where('farmer_group_id', $group_id)->get();
        return $curGroup;
    }
}
