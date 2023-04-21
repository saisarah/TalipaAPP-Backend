<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    const TYPE_URL = 'url';
    const TYPE_LOCAL = 'local';

    public function getUrlAttribute()
    {
        switch ($this->source_type) {
            case self::TYPE_URL: 
                return $this->source;
            case self::TYPE_LOCAL:
                return url(Storage::url($this->source));
        }
        return $this->source;
    }

    public function fileable()
    {
        return $this->morphTo();
    }

    public function storeUrl(string $url)
    {
        $this->source = $url;
        $this->source_type = self::TYPE_URL;
        $this->save();
    }

    public function store($file, $folder, $contexts = null)
    {
        $this->source = $file->store($folder, "public");
        $this->source_type = self::TYPE_LOCAL;
    }
}
