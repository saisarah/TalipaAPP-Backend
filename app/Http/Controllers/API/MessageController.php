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
        $message = Message::where('receiver_id', $id)->select('sender_id')->get();
        return $message;
    }

    public function show($id)
    {
        
        $message = Message::where('sender_id', $id)
        ->orwhere('receiver_id', $id)
            
        ->orwhere(function ($query){
            $user_id = Auth::id();
           
                $query = Message::orwhere('receiver_id', $user_id);

           })
        ->get();

        if ($message == null)
        {
            abort(400, "Conversation not found");
        }
        return $message;
    }

}
