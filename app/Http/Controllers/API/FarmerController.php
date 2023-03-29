<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use Illuminate\Http\Request;

class FarmerController extends Controller
{
    public function index()
    {
        return Farmer::all();
    }

    public function approve(Farmer $farmer)
    {
        if ($farmer->isPending()) {
            $farmer->update([
                'status' => Farmer::STATUS_APPROVED
            ]);
            return $farmer;
        }
        return abort(400, "Invalid farmer id");
    }
}
