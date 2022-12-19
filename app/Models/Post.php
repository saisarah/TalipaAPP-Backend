<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'author_type',
        'status',
        'caption',
        'payment_option',
        'delivery_option',
        'unit',
        'pricing_type',
        'min_order',
        'crop_id',
    ];

    public function author()
    {
        return $this->morphTo();
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function prices()
    {
        return $this->hasMany(PriceTable::class);
    }
}
