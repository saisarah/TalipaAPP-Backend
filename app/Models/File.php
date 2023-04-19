<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    const TYPE_URL = 'url';

    public function getUrlAttribute()
    {
        switch ($this->source_type) {
            case self::TYPE_URL: 
                return $this->source;
        }
        return $this->source;
    }

    public function storeUrl(string $url)
    {
        $this->source = $url;
        $this->source_type = self::TYPE_URL;
        $this->save();
    }
}
