<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderQuantity extends Model
{
    use HasFactory;

    protected $table = 'order_quantity';
    protected $fillable = [
        'quantity',
        'variant',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:3'
    ];

    public function subtotal(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $attributes['price'] * $attributes['quantity']
        );
    }
}
