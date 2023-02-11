<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $message = Message::where('receiver_id', $id)->orwhere('sender_id', $id)->get();
        return $message;
    }

}
