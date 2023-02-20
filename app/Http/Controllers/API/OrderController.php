<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->isFarmer()) {
            $orders = Order::whereHas('post', function ($q) {
                $id = Auth::id();
                $q->where('author_id', $id);
            })->where('order_status', $request->status)->get();
            return  $orders;
        } else {
            $id = Auth::id();
            $orders = Order::where('buyer_id', $id)
                ->where('order_status', $request->status)
                ->get();
            return  $orders;
        }
    }
}
