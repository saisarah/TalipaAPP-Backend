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

    protected $with = ['images'];

    protected $hidden = ['images'];

    protected $appends = ['image_urls'];

    public function images()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function getImageUrlsAttribute()
    {
        return $this->images->map(fn($image) => $image->url);
    }
    
    public function attachImage($file)
    {
        $image = new File();
        $image->fileable()->associate($this);
        $image->store($file, "farmers/{$this->farmer_id}/group-posts");
        $image->save();
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }
}
