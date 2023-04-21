<?php

namespace App\Http\Controllers\API;

use App\Events\DemandsUpdated;
use App\Http\Controllers\Controller;
use App\Models\Crop;
use App\Models\Demand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->isVendor()) {
            return  Demand::where('vendor_id', $user->id)->with('author', 'crop')->get();
        }
        $crop_id = $request->input('crop_id');
        $demand = Demand::where('crop_id', $crop_id)->with('author', 'crop')->get();

        return $demand;
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

        event(new DemandsUpdated());
        return $demand;
    }

    public function show($id)
    {
        return Demand::findOrFail($id);
    }
}
