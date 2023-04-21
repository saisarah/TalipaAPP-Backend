<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    protected $fillable = [
        'status'
    ];

    const STATUS_APPROVED = 'approved';
    const STATUS_PENDING = 'pending';
    const STATUS_RESUBMIT = 'resubmit';

    protected $primaryKey = 'user_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function member()
    {
        return $this->hasOne(FarmerGroupMember::class, 'farmer_id', 'user_id')->where('membership_status', FarmerGroupMember::STATUS_APPROVED);
    }

    public function invites()
    {
        return $this->hasMany(FarmerGroupMember::class, 'farmer_id', 'user_id')->where('membership_status', FarmerGroupMember::STATUS_INVITED);
    }

    public function crops()
    {
        return $this->belongsToMany(Crop::class, 'farmer_crops', 'farmer_id', 'crop_id', 'user_id', 'id');
    }

    public function isPending(): bool
    {
        return $this->status === static::STATUS_PENDING;
    }

    public function orders()
    {
        return $this->hasManyThrough(Order::class, Post::class, 'author_id', 'post_id');
    }

    public function reviews()
    {
        return $this->hasMany(FarmerReview::class, 'farmer_id', 'user_id')
            ->where('rate', '>', 0);
    }

    public function reviewBy(User $user)
    {
        return $this->hasOne(FarmerReview::class, 'farmer_id', 'user_id')
            ->where('vendor_id', $user->id)
            ->firstOr(function () {
                return new FarmerReview([
                    'rate' => 0,
                    'comment' => ''
                ]);
            });
    }
}
