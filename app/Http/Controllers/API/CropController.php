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

    public function demands()
    {
        return Crop::query()
            ->withSum('demands', 'budget')
            ->with([
                'demands:vendor_id,crop_id' => [
                    'author:id,profile_picture'
                ]
            ])
            ->get();
    }
}
