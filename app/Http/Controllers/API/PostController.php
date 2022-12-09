<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;
use App\Models\Farmer;
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

    public function index(Request $request)
    {
       return Post::query()
          ->with('author')
          ->when($request->crop !== null, function ($query) use ($request) {
             $query->where('crop_id', $request->crop);
            })
          ->latest()
          ->paginate(10);
    }
}
