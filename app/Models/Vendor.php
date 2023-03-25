<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{

    use HasFactory;
    protected $primaryKey = 'user_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function crops()
    {
        return $this->belongsToMany(Crop::class, 'vendor_crops', 'vendor_id', 'crop_id', 'user_id', 'id');
    }
}
