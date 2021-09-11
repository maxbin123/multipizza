<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::make());
    }

    public function scopeAdmins(Builder $query)
    {
        return $query->whereHas('role', function (Builder $query) {
            $query->where('slug', 'admin');
        });
    }

    public function routeNotificationForTwilio()
    {
        return $this->phone;
    }

    public static function findOrCreateByPhone($phone)
    {
        $user = User::where('phone', $phone)->first();
        if (!$user) {
            $user = User::create([
                'phone' => $phone,
            ]);
        }
        return $user;
    }
}

