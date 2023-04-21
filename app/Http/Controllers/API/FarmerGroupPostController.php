<?php

namespace App\Http\Controllers\API;

use App\Events\FarmerGroupPostCreated;
use App\Http\Controllers\Controller;
use App\Models\FarmerGroup;
use App\Models\FarmerGroupMember;
use App\Models\FarmerGroupPost;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmerGroupPostController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $group = FarmerGroupMember::where('farmer_id', $id)->first();
        $group_id = $group->farmer_group_id;
        $group_posts = FarmerGroupPost::with('author')->where('farmer_group_id', $group_id)->latest()->get();
        return $group_posts;
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            // 'title' => 'required',
            'description' => 'required',
            // 'tags' => 'required',
            'images' => 'nullable|array',
            'images.*' => 'image',
        ]);

        $id = Auth::id();
        $group = FarmerGroupMember::where('farmer_id', $id)->first();

        $discussion = new FarmerGroupPost();
        $discussion->farmer_id = Auth::id();
        $discussion->farmer_group_id = $group->farmer_group_id;
        $discussion->title = $request->title ?? "N/A";
        $discussion->description = $request->description;
        $discussion->tags = $request->tags ?? "N/A";
        $discussion->save();

        foreach($request->images ?? [] as $image) {
            $discussion->attachImage($image);
        }

        event(new FarmerGroupPostCreated($group->farmer_group_id));

        return $discussion;
    }
}
