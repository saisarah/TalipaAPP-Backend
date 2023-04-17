<?php

namespace App\Models;

use App\Events\MessageReceived;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id',
        'sender_id',
        'content'
    ];

    protected $touches = ['thread'];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function scopeUnread(Builder $query)
    {
        return $query->where('read_at', null)
            ->when(Auth::check(), function ($query) {
                $query->where('sender_id', '!=', Auth::id());
            });
    }

    protected static function booted()
    {
        static::created(function(Message $message) {
            MessageReceived::dispatch($message);
        });
    }
}
