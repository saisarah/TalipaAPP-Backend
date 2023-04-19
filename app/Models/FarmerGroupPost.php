<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerGroupPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'tags'
    ];

    public function images()
    {
        return $this->hasMany(FarmerGroupPostImage::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }
}
