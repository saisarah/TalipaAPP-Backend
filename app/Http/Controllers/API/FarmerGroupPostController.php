<?php

namespace App\Http\Controllers\API;

use App\Events\FarmerGroupPostCreated;
use App\Http\Controllers\Controller;
use App\Models\FarmerGroupMember;
use App\Models\FarmerGroupPost;
use App\Models\FarmerGroupPostComment;
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

    public function createComment(Request $request, $id)
    {
        $this->validate($request, [
            'content' => 'required',
        ]);

        $discussion = new FarmerGroupPostComment();
        $discussion->farmer_group_post_id = $id;
        $discussion->farmer_id = Auth::id();
        $discussion->content = $request->content;
        $discussion->save();
        return $discussion;
    }

    public function show($id)
    {
        $group = FarmerGroupMember::where('farmer_id', Auth::id())->first();
        $group_id = $group->farmer_group_id;
        $post = FarmerGroupPost::where('id', $id)
            ->where('farmer_group_id', $group_id)->first();

        if ($post == null) {
            return abort(400, "Invalid Group discussion");
        }
        return $post;
    }

    public function comments($id)
    {
        // $group = FarmerGroupMember::where('farmer_id', Auth::id())->first();
        // $group_id = $group->farmer_group_id;
        // $post = FarmerGroupPost::where('farmer_group_id', $group_id)->get();
        $comment = FarmerGroupPostComment::where('farmer_group_post_id', $id)->get();
        return $comment;
    }
}
