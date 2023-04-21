<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;
use App\Models\Attachment;
use App\Models\Farmer;
use App\Models\PriceTable;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function create(CreatePostRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $author = Auth::user();
            $post = new Post($request->only('crop_id', 'title', 'caption', 'unit', 'is_straight'));

            //temp
            $post->min_order = 0;


            $post->status = 'available';

            //associate author
            $post->author()->associate($author);

            //Save Post
            $post->save();

            //save prices
            $post->prices()->createMany(array_map(fn ($price) => ([
                'variant' => @$price['variant'],
                'stocks' => $price['stock'],
                'value' => $price['price'],
            ]), $request->prices));

            //save attachments
            $post->attachments()->createMany(array_map(fn ($attachment) => ([
                'source' => $attachment->store("farmers/posts/" . auth()->id() . "", "public"),
                'type' => 'upload'
            ]), $request->attachments));

            return $post;
        });
    }

    public function index(Request $request)
    {
        if ($request->has('crop_ids')) {
            $crop_id = explode(',', $request->crop_ids);
            return Post::whereIn('crop_id', $crop_id)->with('thumbnail', 'author', 'prices', 'crop')->latest()->get()->each->append('display_price', 'location');
        } else {
            return Post::with('thumbnail', 'author', 'prices', 'crop')->latest()->get()->each->append('display_price', 'location');
        }
    }

    public function show(Post $post)
    {
        $post->load('author', 'author.address', 'attachments', 'prices', 'crop')->append('display_price');
        $post->author->append('rate');
        return $post;
    }

    public function getFromUser(User $user)
    {
        return $user->posts()->with('thumbnail', 'author', 'prices', 'crop')->get()->each->append('display_price', 'location');
    }
}
