<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerGroup extends Model
{
    use HasFactory;

    public function members()
    {
        return $this->hasMany(FarmerGroupMember::class)->where('membership_status', 'approved');
    }

    public function pendings()
    {
        return $this->hasMany(FarmerGroupMember::class)->where('membership_status', 'pending');
    }

    public function invites()
    {
        return $this->hasMany(FarmerGroupMember::class)->where('membership_status', 'invited');
    }

    public function president()
    {
        return $this->hasOne(FarmerGroupMember::class)->where('role', 'president');
    }
}

