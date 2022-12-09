<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Models\Farmer;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function create(CreatePostRequest $request)
    {
        return Post::create($request->validated() + [
            'author_id' => Auth::id(),
            'author_type' => Farmer::class,
            'status' => 'Available',
        ]);
    }
}
