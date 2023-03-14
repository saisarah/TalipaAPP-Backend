<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    const TYPE_CASH_IN = 'cash in';
    const TYPE_RECEIVED = 'received';
    const TYPE_SENT = 'sent';
    const TYPE_WITHDRAW = 'withdraw';

    protected $casts = [
        'amount' => 'decimal:3'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
