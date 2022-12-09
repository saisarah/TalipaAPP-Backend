<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Crop;
use Illuminate\Http\Request;

class CropController extends Controller
{
    public function index()
    {
        return Crop::all();
    }
}
