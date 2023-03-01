<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FarmerGroupMember;
use App\Models\FarmerGroupPost;
use App\Models\FarmerGroupPostImage;
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

    public function create(Request $request)
    {
        $this->validate($request, [
            'farmer_id' => 'required|exists:farmers,user_id',
            'farmer_group_id' => 'required|exists:farmer_group_members,farmer_id',
            'title' => 'required',
            'description' => 'required',
            'tags' => 'required',
        ]);

        $discussion = new FarmerGroupPost();
        $discussion->farmer_id = Auth::id();
        $discussion->farmer_group_id = $request->farmer_group_id;
        $discussion->title = $request->title;
        $discussion->description = $request->description;
        $discussion->tags = $request->tags;
        $discussion->save();

        return $discussion;
    }
}
