<?php

namespace App\Http\Controllers\API;

use App\Facades\Transportify;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class TransportifyController extends Controller
{
    public function vehicles()
    {
        return Transportify::getVehicles();
    }

    public function getQuote(Request $request)
    {
        $this->validate($request, [
            'post_id' => 'required|exists:posts,id',
            'address' => 'required',
            'vehicle_id' => 'required|numeric',
        ]);
        $post = Post::find($request->post_id);
        $farmer_address = $post->author->shortAddress();

        $vehicle_id = $request->vehicle_id;
        $address = $request->address;

        try {
            return Transportify::getQuote($vehicle_id, $farmer_address, $address);
        } catch (Exception $ex) {
            abort(400, $ex->getMessage());
        }
    }
}
