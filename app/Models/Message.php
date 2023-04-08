<?php

namespace App\Models;

use App\Events\MessageReceived;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id',
        'sender_id',
        'content'
    ];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    protected static function booted()
    {
        static::created(function(Message $message) {
            MessageReceived::dispatch($message);
        });
    }
}
