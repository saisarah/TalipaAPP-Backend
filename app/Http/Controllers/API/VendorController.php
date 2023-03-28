<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        return Vendor::all();
    }

    public function approve(Vendor $vendor)
    {
        $user =  Vendor::where('user_id', $vendor->user_id)
            ->where('status', Vendor::STATUS_PENDING)
            ->first();
        if ($user !== null) {
            $user->update([
                'status' => Vendor::STATUS_APPROVED
            ]);
            return $user;
        }
        return abort(400, "Invalid vendor id");
    }
}
