<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'rate',
        'comment',
        'vendor_id',
        'farmer_id',
    ];
}
