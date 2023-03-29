<?php

namespace App\Http\Controllers\API;

use App\Facades\Transportify;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransportifyController extends Controller
{
    public function vehicles()
    {
        return Transportify::getVehicles();
    }
}
