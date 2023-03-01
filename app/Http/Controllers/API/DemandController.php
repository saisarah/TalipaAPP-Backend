<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Crop;
use App\Models\Demand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandController extends Controller
{
    public function index()
    {
        return Demand::with('author', 'crop')->get();
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'budget' => 'required|numeric',
            'quantity' => 'required|numeric',
            'description' => 'required',
            'crop_id' => 'required|exists:crops,id'
        ]);
        
        $demand = new Demand();
        $demand->vendor_id = Auth::id();
        $demand->budget = $request->budget;
        $demand->quantity = $request->quantity;
        $demand->description = $request->description;
        $demand->crop_id = $request->crop_id;
        $demand->save();

        return $demand;
    }
    
}
