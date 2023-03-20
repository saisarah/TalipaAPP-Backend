<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'buyer_id',
        'payment_option',
        'delivery_option',
        'order_status'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_COMPLETED = 'completed';

    public function isPending()
    {
        return $this->order_status === static::STATUS_PENDING;
    }

    public function isProcessing()
    {
        return $this->order_status === static::STATUS_PROCESSING;
    }

    public function isShipped()
    {
        return $this->order_status === static::STATUS_SHIPPED;
    }

    public function isCancelled()
    {
        return $this->order_status === static::STATUS_CANCELLED;
    }

    public function isCompleted()
    {
        return $this->order_status === static::STATUS_COMPLETED;
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function quantities()
    {
        return $this->hasMany(OrderQuantity::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function total(): Attribute
    {
        $total = $this->quantities->reduce(function ($acm, $quantity) {
            return [
                'quantity' => $acm['quantity'] + $quantity->quantity,
                'price' => $acm['price'] + $quantity->subtotal
            ];
        }, ['quantity' => 0, 'price' => 0]);

        return Attribute::make(
            get: fn() => $total
        );
    }
}
