<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderQuantity;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->isFarmer()) {
            $orders = Order::with('post','post.author', 'post.crop', 'post.thumbnail', 'quantities')
                ->whereHas('post', function ($q) {
                    $id = Auth::id();
                    $q->where('author_id', $id);
                })
                ->where('order_status', $request->status)
                ->get()
                ->each(function (Order $order) {
                    $order->append('total');
                    $order->post->append('location');
                });
            return  $orders;
        } else {
            $id = Auth::id();
            $orders = Order::with('post','post.author', 'post.crop', 'post.thumbnail', 'quantities')
                ->where('buyer_id', $id)
                ->where('order_status', $request->status)
                ->get()
                ->each(function (Order $order) {
                    $order->append('total');
                    $order->post->append('location');
                });
            return  $orders;
        }
    }

    public function show(Order $order)
    {
        return $order->load('post', 'buyer', 'post.author', 'post.thumbnail')->append('total');
    }

    public function create(Request $request, Post $post)
    {
        $this->validate($request, [
            'quantities.*.quantity' => 'required|numeric',
        ]);

        $user = auth()->user();

        $quantities = collect($request->quantities);
        $subtotal = $post->calculateTotalPrice($quantities);
        $fee = $subtotal*.08;
        $delivery_fee = 200;
        $total = $subtotal + $fee + $delivery_fee;

        if ($user->usableBalance() < $total) {
            abort(400, "You don't have enough balance");
        }

        $order = DB::transaction(function() use ($user, $total, $post, $quantities) {
            $user->wallet()->increment('locked', $total);

            $order = Order::create([
                'post_id' => $post->id,
                'payment_option' => 'TalipaAPP Wallet',
                'buyer_id' => $user->id,
                'delivery_option' => 'Tranportify',
                'order_status' => 'pending'
            ]);

            $quantities = $quantities->map(function ($quantity) use ($order, $post){
                return $quantity + [
                    'order_id' => $order->id,
                    'price' => $post->prices->firstWhere('variant', $quantity['variant'])->value
                ];
            })->toArray();

            OrderQuantity::insert($quantities);

            return $order;            
        });

        return $order;
    }
}
