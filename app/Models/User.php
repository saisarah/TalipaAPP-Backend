<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use function PHPSTORM_META\map;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const TYPE_FARMER = 'farmer';
    const TYPE_VENDOR = 'vendor';
    const TYPE_ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'gender',
        'profile_picture',
        'pin',
        'user_type',
        'email',
        'contact_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'pin',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isFarmer() : bool 
    {
        return $this->type === static::TYPE_FARMER;
    }

    public function isVendor() : bool
    {
        return $this->type === static::TYPE_VENDOR;
    }

    public function isAdmin() : bool
    {
        return $this->type === static::TYPE_ADMIN;
    }

}
