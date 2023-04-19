<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FarmerGroup;
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
        $group_id = $group->farmer_group_id;
        $group_posts = FarmerGroupPost::where('farmer_group_id', $group_id)->get();
        return $group_posts;
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'tags' => 'required',
            'images' => 'nullable|array',
            'images.*' => 'image',
        ]);

        $id = Auth::id();
        $group = FarmerGroupMember::where('farmer_id', $id)->first();

        $discussion = new FarmerGroupPost();
        $discussion->farmer_id = Auth::id();
        $discussion->farmer_group_id = $group->farmer_group_id;
        $discussion->title = $request->title;
        $discussion->description = $request->description;
        $discussion->tags = $request->tags;
        $discussion->save();

        $discussion->images()->createMany(array_map(fn ($image) => ([
            'image' => $image->store("farmers/" . auth()->id() . "/group-posts", "public"),
        ]), $request->images));

        return $discussion;
    }
}
