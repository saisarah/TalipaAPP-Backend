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

class PostController extends Controller
{
    public function create(Request $request)
    {
        // return $request->file('attachments');
        // dd($request->file('attachments'));

        $post = new Post;
        $post->author_id = Auth::id();
        $post->author_type = User::class;
        $post->crop_id = $request->commodity;
        $post->caption = $request->details;
        $post->payment_option = $request->payment_options;
        $post->delivery_option = $request->delivery_options;
        $post->unit = $request->unit;
        $post->pricing_type = $request->boolean('is_straight') ? "Straight" : "Not Straight";
        $post->status = "Available";
        $post->min_order = 0;
        $post->save();

        $post->price_table = new PriceTable();
        $post->price_table->post_id = $post->id;
        $post->price_table->value = $request->prices;
        $post->price_table->variant = $request->sizes;
        $post->price_table->stocks = $request->stocks;
        $post->price_table->save();

        // for
        $post->attachments = new Attachment();
        $post->attachments->post_id = $post->id;
        $post->attachments->source = $request->file('attachments')->store("farmers/posts/{$post->id}", "public");
        $post->attachments->type = "image";
        $post->attachments->save();

        return $post;
        // $post->attachments->

        return $post;
    }

    public function index(Request $request)
    {
        return Post::with('attachments', 'author')->get();
    }
}
