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
        $this->validate($request, [
            'crop_id' => 'required|exists:crops,id',
            'delivery_options' => 'required|array',
            'payment_options' => 'required|array',
            'unit' => 'required',
            'is_straight' => 'required|boolean',
            'details' => 'required|max:1000',
            'attachments' => 'required|array',
            'attachments.*' => 'image',
            'sizes' => 'required|array',
            'sizes.*.size' => 'required',
            'sizes.*.price' => 'required|numeric|min:1',
            'sizes.*.stock' => 'required|numeric|min:1'
        ]);

        $post = new Post;
        $post->author_id = Auth::id();
        $post->author_type = User::class;
        $post->crop_id = $request->crop_id;
        $post->caption = $request->details;
        $post->payment_option = json_encode($request->payment_options);
        $post->delivery_option = json_encode($request->delivery_options);
        $post->unit = $request->unit;
        $post->pricing_type = $request->boolean('is_straight') ? "Straight" : "Not Straight";
        $post->status = "Available";
        $post->min_order = 0;
        $post->save();

        foreach($request->sizes as $size) {
            $price = new PriceTable();
            $price->post_id = $post->id;
            $price->value = $size["price"];
            $price->variant = $size["size"];
            $price->stocks = $size["stock"];
            $price->save();
        }

        foreach($request->attachments as $attachment) {
            $file = new Attachment();
            $file->post_id = $post->id;
            $file->source = $attachment->store("farmers/posts/{$post->id}", "public");
            $file->type = "image";
            $file->save();
        }

        return $post;
    }

    public function index()
    {
        return Post::with('attachments', 'author', 'prices')->get()->each->append('display_price');
    }

    public function show(Post $post)
    {
        return $post->load('author', 'attachments');
    }

    public function getFromUser(User $user)
    {
        return $user->posts()->with('attachments', 'author', 'prices')->get()->each->append('display_price');
    }
}
