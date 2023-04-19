<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image'
    ];

    private static ?Collection $crops = null;

    public static function getRandomCrop()
    {
        if (is_null(static::$crops)) {
            static::$crops = Crop::all();
        }

        return static::$crops->random()->id;
    }

    public function demands()
    {
        return $this->hasMany(Demand::class);
    }
}
