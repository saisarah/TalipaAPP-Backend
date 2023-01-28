<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FarmerGroupPost;
use Illuminate\Http\Request;

class FarmerGroupPostController extends Controller
{
    public function index()
    {
        return FarmerGroupPost::all();
    }
}
