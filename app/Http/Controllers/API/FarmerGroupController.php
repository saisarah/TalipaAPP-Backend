<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use App\Models\FarmerGroup;
use Illuminate\Http\Request;

class FarmerGroupController extends Controller
{
    public function index()
    {
        return FarmerGroup::all();
    }

    public function show($id)
    {
       return FarmerGroup::where('id', $id)->first();
    }
}
