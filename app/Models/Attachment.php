<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory;

    const TYPE_URL = 'url';

    public function source(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->type === self::TYPE_URL ? $value : url(Storage::url($value))
        );
    }
}
