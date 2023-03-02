<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $first = Message::select('receiver_id')->where('sender_id', $id)->distinct();
        $second = Message::select('sender_id')->where('receiver_id', $id)->distinct()->union($first)->get();

        $result = $second->map(function ($item, $key) {
            return $item['sender_id'];
        });

        $users = User::whereIn('id', $result)->get();
        return $users;
    }

    public function show($id)
    {
        $user_id = Auth::id();
        $message = Message::where('sender_id', $id)
            ->where('receiver_id', $user_id)
            ->orwhere('sender_id', $user_id)
            ->where('receiver_id', $id)
            ->oldest()
            ->get();
        return $message;
    }
    public function create(Request $request, $id)
    {
        $this->validate($request, [
            'content' => 'required'
        ]);

        $message = Message::create([
            'receiver_id' => $id,
            'sender_id' => Auth::id(),
            'content' => $request->content
        ]);
        return $message;
    }
}
