<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Demand;
use Illuminate\Http\Request;

class DemandController extends Controller
{
    public function index()
    {
        return Demand::all();
    }
}
