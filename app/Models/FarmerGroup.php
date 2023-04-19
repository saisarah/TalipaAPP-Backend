<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerGroup extends Model
{
    use HasFactory;

    const STATUS_VERIFIED = 'verified';
    const STATUS_PENDING = 'pending';

    protected $fillable = [
        'name',
        'address',
        'type',
        'year_founded',
        'authorization',
        'group_description',
        'contact_no',
        'email',
        'status'
    ];

    protected $with = ['image'];
    protected $appends = ['image_url'];
    protected $hidden = ['image'];


    // public function members()
    // {
    //     return $this->hasMany(FarmerGroupMember::class)->where('membership_status', 'approved');
    // }
    public function members()
    {
        return $this->belongsToMany(User::class, 'farmer_group_members', 'farmer_group_id', 'farmer_id')
            ->where('membership_status', FarmerGroupMember::STATUS_APPROVED);
    }

    // public function pendings()
    // {
    //     return $this->hasMany(FarmerGroupMember::class)->where('membership_status', 'pending');
    // }
    public function pendings()
    {
        return $this->belongsToMany(User::class, 'farmer_group_members', 'farmer_group_id', 'farmer_id')
            ->where('membership_status', FarmerGroupMember::STATUS_PENDING);
    }

    public function setPresident($farmer_id)
    {
        $this->president()->updateOrCreate(
            ['role' => 'president'],
            [
                'farmer_id' => $farmer_id,
                'membership_status' => FarmerGroupMember::STATUS_APPROVED
            ]
        );
        return $this;
    }

    public function setImageUrl($url)
    {
        return $this->image->storeUrl($url);
    }

    public function invites()
    {
        return $this->hasMany(FarmerGroupMember::class)->where('membership_status', 'invited');
    }

    public function president()
    {
        return $this->hasOne(FarmerGroupMember::class)->where('role', 'president');
    }

    public function image()
    {
        return $this->morphOne(File::class, 'fileable')->withDefault([
            'source' => 'https://res.cloudinary.com/djasbri35/image/upload/v1625929593/assets/error_ay6j96.jpg',
            'source_type' => 'url'
        ]);
    }

    public function getImageUrlAttribute()
    {
        return $this->image->url;
    }
}
