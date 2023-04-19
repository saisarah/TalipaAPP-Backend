<?php

namespace App\Models;

use App\Services\Address\HasAddress;
use App\Services\Wallet\HasWallet;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasWallet, HasAddress;

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
        'username',
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

    public function vendor()
    {
        return $this->hasOne(Vendor::class);
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

    public function threads()
    {
        return $this->belongsToMany(Thread::class);
    }

    public function groups()
    {
        return $this->belongsToMany(FarmerGroup::class, 'farmer_group_members', 'farmer_id')
            ->where('membership_status', 'approved')
            ->withPivot('membership_status', 'role');
        // return $this->hasOneThrough(FarmerGroup::class, FarmerGroupMember::class, 'id', 'id');
    }

    public function sendMessage(User $user, string $message)
    {
        return $this->thread($user)
            ->sendMessage(
                sender: $this, 
                message: $message
            );
    }

    public function thread(User $user)
    {
        return $this->threads()
            ->where('type', 'direct')
            ->whereHas('users', function ($q) use($user){
                $q->where('user_id', $user->id);
            })
            ->firstOr(function () use ($user) {
                $thread = Thread::create();
                $thread->users()->attach([$this->id, $user->id]);
                return $thread;
            });
    }

    public static function generateUserName($firstname)
    {
        $firstname = explode(" ", $firstname)[0];
        $digits = 4;
        $id = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
        $result = "$firstname#$id";
        return $result;
    }
    protected static function booted(): void
    {

        static::creating(function (User $user) {
            $user->profile_picture = $user->profile_picture;
        });

        static::created(function (User $user) {
            $user->update(['username' => User::generateUserName($user->firstname)]);
        });
    }
}
