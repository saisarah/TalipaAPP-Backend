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
}
