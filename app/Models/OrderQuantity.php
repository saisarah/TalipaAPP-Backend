<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderQuantity extends Model
{
    use HasFactory;

    protected $table = 'order_quantity';
    protected $fillable = [
        'quantity',
        'variant'
    ];
}
