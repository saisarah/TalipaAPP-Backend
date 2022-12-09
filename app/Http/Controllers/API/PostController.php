<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
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
