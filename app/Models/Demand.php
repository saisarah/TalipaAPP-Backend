<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'question',
        'answer'
    ];

    public function author()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'user_id'); 
    }

    public function crop()
    {
        return $this->belongsTo(Crop::class, 'crop_id');
    }
}
