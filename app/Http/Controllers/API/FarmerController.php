<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use App\Models\FarmerReview;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmerController extends Controller
{
    public function index()
    {
        return Farmer::all();
    }

    public function approve(Farmer $farmer)
    {
        if ($farmer->isPending()) {
            $farmer->update([
                'status' => Farmer::STATUS_APPROVED
            ]);
            return $farmer;
        }
        return abort(400, "Invalid farmer id");
    }

    public function rate(Farmer $farmer, Request $request)
    {
        $this->validate($request, [
            'rate' => 'required|integer'
        ]);

        $hasOrder =  $farmer->orders()
            ->where('buyer_id', Auth::id())
            ->where('order_status', Order::STATUS_COMPLETED)
            ->exists();
        if ($hasOrder) {
            $review = FarmerReview::firstOrNew([
                'vendor_id' => Auth::id(),
                'farmer_id' => $farmer->user_id
            ]);
            $review->rate = $request->rate;
            $review->comment = $request->comment;
            $review->save();

            return $review;
        }
        return abort(400, "You are only allowed to rate Farmers you have transaction with");
    }

    public function showRate(Farmer $farmer)
    {
        return $farmer->reviewBy(Auth::user());
    }

    public function review(Farmer $farmer, Request $request)
    {
        if ($request->has('latest'))
        {
            return FarmerReview::where('farmer_id', $farmer->user_id)->limit(5)->latest()->get();
        }
        return FarmerReview::where('farmer_id', $farmer->user_id)->get();
    }
}
