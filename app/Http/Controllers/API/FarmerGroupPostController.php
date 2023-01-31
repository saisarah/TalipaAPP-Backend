<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FarmerGroupMember;
use App\Models\FarmerGroupPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmerGroupPostController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $group = FarmerGroupMember::where('farmer_id', $id)->first();
        if ($group == null)
        {
            abort(400, "Join Group to view Discussions");
        }
        $group_id = $group->farmer_group_id;
        $group_posts = FarmerGroupPost::where('farmer_group_id', $group_id)->get();
        return $group_posts;
    }
}
