<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected $appends = ['fullname'];

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

    public function farmer()
    {
        return $this->hasOne(Farmer::class);
    }

    public function fullname() : Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->firstname} {$this->lastname}"
        );
    }

    public function profilePicture() : Attribute
    {
        $name = strtolower(urlencode($this->fullname));

        return Attribute::make(
            get: fn($pic) => $pic ?? "https://avatars.dicebear.com/api/initials/$name.svg"
        );
    }

    public function posts()
    {
        return $this->morphMany(Post::class, 'author');
    }

    public static function generateUserName($firstname)
    {
        $firstname = explode(" ", $firstname)[0];
        $digits = 4;
        $id = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
        $result = "$firstname#$id";
        return $result;
    }
}
