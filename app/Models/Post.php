<?php

namespace App\Models;

use App\Services\Address\HasAddress;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, HasAddress;
    
    protected $addressKey = 'author_id';

    protected $guarded = [];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }

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

    public function getDisplayPriceAttribute()
    {
        $prices = $this->prices;
        if ($prices->count() === 0)
            return 0;

        return $prices->reduce(function ($acm, $price) {
            if ($price->value < $acm) return $price->value;
            return $acm;
        }, INF);
    }

    public function calculateTotalPrice($quantities) {
        return $this->prices->reduce(function($acm, $price) use ($quantities) {
            $quantity = $quantities->firstWhere('variant', $price->variant);
            return $acm + ($price->value * $quantity['quantity']);
        }, 0);
    }

    public function location(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->address->municipality}, {$this->address->province}"
        );
    }
}
