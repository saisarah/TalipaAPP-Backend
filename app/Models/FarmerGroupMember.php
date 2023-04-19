<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerGroupMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'membership_status',
        'farmer_id',
        'role',
    ];

    const STATUS_APPROVED = 'approved';
    const STATUS_PENDING = 'pending';
    const STATUS_INVITED = 'invited';
    const ROLE_MEMBER = 'member';
    const ROLE_PRESIDENT = 'president';

    public function group()
    {
        return $this->belongsTo(FarmerGroup::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    public function isApproved(): bool
    {
        return $this->membership_status === static::STATUS_APPROVED;
    }

    public function isPending(): bool
    {
        return $this->membership_status === static::STATUS_PENDING;
    }

    public function isInvited(): bool
    {
        return $this->membership_status === static::STATUS_INVITED;
    }

    public function isMember(): bool
    {
        return $this->role === static::ROLE_MEMBER;
    }

    public function isPresident(): bool
    {
        return $this->role === static::ROLE_PRESIDENT;
    }
}
