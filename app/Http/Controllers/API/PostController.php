<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
   public function index(Request $request)
   {
         
        return Post::paginate(10);

        
   }
}
