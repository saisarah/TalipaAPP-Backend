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
        $user =  Farmer::where('user_id', $farmer->user_id)
            ->where('status', Farmer::STATUS_PENDING)
            ->first();
        if ($user !== null) {
            $user->update([
                'status' => Farmer::STATUS_APPROVED
            ]);
            return $user;
        }

        return abort(400, "Invalid farmer id");
    }
}
