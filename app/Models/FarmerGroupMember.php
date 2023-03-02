<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerGroupMember extends Model
{
    use HasFactory;

    const STATUS_APPROVED = 'approved';
    const STATUS_PENDING = 'pending';
    const ROLE_MEMBER = 'member';
    const ROLE_PRESIDENT = 'president';



    public function isApproved(): bool
    {
        return $this->membership_status === static::STATUS_APPROVED;
    }

    public function isPending(): bool
    {
        return $this->membership_status === static::STATUS_PENDING;
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
