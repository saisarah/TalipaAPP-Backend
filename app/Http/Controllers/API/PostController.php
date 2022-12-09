<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
   public function index(Request $request)
   {
      if ($request->crop === null)
         return Post::paginate(10);

      return Post::where('crop_id', $request->crop)->paginate(10);        
   }
}
