<?php

namespace App\Http\Controllers\API;

use App\Events\MessageReceived;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $threads = Auth::user()
            ->threads()
            ->whereHas('messages')
            ->with('users')
            ->get();

        return $threads;
    }

    public function show(Thread $thread)
    {
        return $thread->messages;
    }

    public function create(Request $request, Thread $thread)
    {
        $this->validate($request, [
            'content' => 'required'
        ]);

        $message = $thread->sendMessage(
            sender: Auth::user(),
            message: $request->content
        );

        MessageReceived::dispatch($message);

        return $message;
    }
}
