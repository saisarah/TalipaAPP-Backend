<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    public function index()
    {
        $threads = Auth::user()
            ->threads()
            ->whereHas('messages')
            ->with('users')
            ->latest()
            ->get();

        return $threads;        
    }

    public function show(Thread $thread)
    {
        return $thread->load('users');
    }

    public function messages(Thread $thread)
    {
        return $thread->messages;
    }

    public function sendMessage(Thread $thread, Request $request)
    {
        $this->validate($request, [
            'content' => 'required'
        ]);

        $message = $thread->sendMessage(
            sender: Auth::user(),
            message: $request->content
        );
        
        return $message;
    }
}
