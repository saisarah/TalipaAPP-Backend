<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Thread extends Model
{
    use HasFactory;

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function messages() : HasMany
    {
        return $this->hasMany(Message::class)->latest();
    }

    public function unreadMessages() : HasMany
    {
        return $this->messages()->unread();
    }

    public function latest() : HasOne
    {
        return $this->hasOne(Message::class)->latest();
    }

    public function sendMessage(User $sender, string $message) : Message
    {
        return $this->messages()->create([
            'sender_id' => $sender->id,
            'content' => $message,
        ]);
    }

    public function readMessages()
    {
        $this->unreadMessages()
            ->where('created_at', '<=', now())
            ->update(['read_at' => now()]);
        return $this->refresh();
    }
}
