<?php

namespace App\Http\Controllers\API;

use App\Facades\Transportify;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function webhook(Request $request)
    {
        Log::channel('transportify')->info("Transportify", $request->all());
        
        $order = Order::where('delivery_status->id', $request->id)->first();

        if ($order !== null) {

            $order->update([
                'delivery_status' => $request->all()
            ]);

            if ($request->status === "delivery_in_progress") {
                $order->update([
                    'status' => Order::STATUS_SHIPPED
                ]);
            }

            if ($request->status === "delivery_completed") {
                $order->update([
                    'status' => Order::STATUS_COMPLETED
                ]);
            }
        }

        return response()->noContent();
    }
}
