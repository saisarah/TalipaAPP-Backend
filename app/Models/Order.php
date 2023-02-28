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

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function quantities()
    {
        return $this->hasMany(OrderQuantity::class);
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
