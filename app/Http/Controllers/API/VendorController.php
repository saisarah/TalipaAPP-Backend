<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        return Farmer::all();
    }
}
