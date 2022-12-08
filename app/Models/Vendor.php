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
        return $this->hasOne(User::class);
    }
}
