<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
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

    public function isFarmer(): bool
    {
        return $this->user_type === static::TYPE_FARMER;
    }

    public function isVendor(): bool
    {
        return $this->user_type === static::TYPE_VENDOR;
    }

    public function isAdmin(): bool
    {
        return $this->user_type === static::TYPE_ADMIN;
    }

    public function farmer()
    {
        return $this->hasOne(Farmer::class);
    }

    public function fullname(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->firstname} {$this->lastname}"
        );
    }

    public function profilePicture(): Attribute
    {
        $name = strtolower(urlencode($this->fullname));

        return Attribute::make(
            get: fn ($pic) => $pic ?? "https://avatars.dicebear.com/api/initials/$name.svg"
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
        $id = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
        $result = "$firstname#$id";
        return $result;
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function activateWallet()
    {
        if ($this->wallet === null) {
            $this->wallet = $this->wallet()->create();
        }
    }

    public function transferMoney($receiver, $amount)
    {
        if ($this->wallet === null) {
            throw new Exception("Activate your wallet first");
        }

        if ($receiver->wallet === null) {
            throw new Exception("Invalid user");
        }

        if ($this->wallet->balance < $amount) {
            throw new Exception("Insufficient Balance");
        }

        if ($this->user_type !== $receiver->user_type) {
            throw new Exception("Transfer failed");
        }

        $this->wallet->balance = $this->wallet->balance - $amount;
        $receiver->wallet->balance = $receiver->wallet->balance + $amount;

        $this->wallet->update();
        $receiver->wallet->update();
    }
}
