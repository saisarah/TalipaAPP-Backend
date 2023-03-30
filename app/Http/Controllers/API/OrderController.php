<?php

namespace App\Http\Controllers\API;

use App\Facades\Transportify;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderQuantity;
use App\Models\Post;
use App\Notifications\OrderPlaced;
use App\Notifications\OrderReceived;
use App\Services\Wallet\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->isFarmer()) {
            $orders = Order::with('post', 'post.author', 'post.crop', 'post.thumbnail', 'quantities')
                ->whereHas('post', function ($q) {
                    $id = Auth::id();
                    $q->where('author_id', $id);
                })
                ->where('order_status', $request->status)
                ->latest()
                ->get()
                ->each(function (Order $order) {
                    $order->append('total');
                    $order->post->append('location');
                });
            return  $orders;
        } else if ($user->isVendor()) {
            $id = Auth::id();
            $orders = Order::with('post', 'post.author', 'post.crop', 'post.thumbnail', 'quantities')
                ->where('buyer_id', $id)
                ->where('order_status', $request->status)
                ->latest()
                ->get()
                ->each(function (Order $order) {
                    $order->append('total');
                    $order->post->append('location');
                });
            return  $orders;
        }
        $orders = Order::with('post', 'post.author', 'post.crop', 'post.thumbnail', 'quantities')
            ->where('order_status', Order::STATUS_COMPLETED)
            ->latest()
            ->get()
            ->each(function (Order $order) {
                $order->append('total');
                $order->post->append('location');
            });
        return $orders;
    }

    public function show(Order $order)
    {
        $user = Auth::id();
        $seller = $order->post->author_id;
        if ($seller == $user || $user == $order->buyer_id) {
            return $order->load('post', 'buyer', 'post.author', 'post.thumbnail')->append('total');
        }

        return abort(401, "Unauthorized Access");
    }

    public function create(Request $request, Post $post)
    {
        $this->validate($request, [
            'quantities.*.quantity' => 'required|numeric',
            'address' => 'required',
            'vehicle_id' => 'required',
        ]);

        $buyer = auth()->user();
        $seller = $post->author;

        $quote = Transportify::getQuote($request->vehicle_id, $seller->shortAddress(), $request->address);
        $quantities = collect($request->quantities);
        $subtotal = $post->calculateTotalPrice($quantities);
        $fee = $subtotal * config('app.transaction_fee');
        $delivery_fee = $quote['total_fees'];
        $total = $subtotal + $fee + $delivery_fee;

        if ($buyer->usableBalance() < $total) {
            abort(400, "You don't have enough balance");
        }

        $order = DB::transaction(function () use ($buyer, $seller, $total, $post, $quantities, $request, $quote) {
            $buyer->wallet()->increment('locked', $total);

            $order = Order::create([
                'post_id' => $post->id,
                'payment_option' => 'TalipaAPP Wallet',
                'buyer_id' => $buyer->id,
                'delivery_option' => $quote,
                'order_status' => 'pending',
                'address' => $request->address,
                'address_note' => $request->address_note
            ]);

            $quantities = $quantities->map(function ($quantity) use ($order, $post) {
                return [
                    'quantity' => $quantity['quantity'],
                    'variant' => $quantity['variant'],
                    'order_id' => $order->id,
                    'price' => $post->prices->firstWhere('variant', $quantity['variant'])->value
                ];
            })->toArray();

            OrderQuantity::insert($quantities);

            $seller->notify(new OrderReceived($order));

            return $order;
        });

        return $order;
    }

    public function cancel($id)
    {
        $user = Auth::id();
        $order = Order::where('id', $id)
            ->where('order_status', Order::STATUS_PENDING)
            ->first();

        if (!$order) {
            return abort(400, "Invalid order id");
        }
        $seller = $order->post->author_id;
        if ($seller == $user || $user == $order->buyer_id) {
            $order->order_status = Order::STATUS_CANCELLED;
            $order->save();
            return $order;
        }

        return abort(401, "Unauthorized Access");
    }

    public function handleOrder($id)
    {
        $user = Auth::id();
        $order = Order::where('id', $id)
            ->where('order_status', Order::STATUS_PENDING)
            ->first();
        if (!$order) {
            return abort(400, "Invalid order id");
        }
        $seller_id = $order->post->author_id;
        $amount = $order->total['price'];

        if ($seller_id == $user) {
            $seller = $order->post->author;
            $buyer = $order->buyer;
            $order->order_status = Order::STATUS_PROCESSING;
            $new_amount = Order::DELIVERY_FEE + $amount * (1 + Order::TRANSACTION_FEE);
            $buyer->wallet()->decrement('locked', $new_amount);
            $buyer->transferMoney($seller, $new_amount);
            $seller->wallet()->increment('locked', $new_amount);
            $order->save();
            return $order;
        }

        return abort(401, "Unauthorized Access");
    }
}
