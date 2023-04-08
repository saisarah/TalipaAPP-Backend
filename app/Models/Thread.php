<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thread extends Model
{
    use HasFactory;

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function messages() : HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function sendMessage(User $sender, string $message) : Message
    {
        return $this->messages()->create([
            'sender_id' => $sender->id,
            'content' => $message,
        ]);
    }
}
