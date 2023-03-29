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
        Vendor::where('user_id', $vendor->user_id)
            ->first();
        if ($vendor->isPending()) {
            $vendor->update([
                'status' => Vendor::STATUS_APPROVED
            ]);
            return $vendor;
        }
        return abort(400, "Invalid vendor id");
    }
}
