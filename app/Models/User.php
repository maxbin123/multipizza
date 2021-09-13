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
        return $this->hasMany(Order::class);
    }

    public function delivery()
    {
        return $this->hasMany(Order::class, 'delivery_id');
    }

    public function deliveryActive()
    {
        return $this->hasMany(Order::class, 'delivery_id')->where('state', 'delivering');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function scopeAdmins(Builder $query)
    {
        return $query->whereHas('role', function (Builder $query) {
            $query->where('slug', 'admin');
        });
    }

    public function deliveries()
    {
        static $deliveries;

        if (!$deliveries) {
            $deliveries = $this->orders->pluck('delivery_id');
        }
        return $deliveries;
    }

    public function scopeOrdersInRestaurant(Builder $query, $restaurant_id)
    {
        return $query->whereHas('orders', function (Builder $query) use ($restaurant_id) {
            $query->where('restaurant_id', $restaurant_id);
        });
    }

    public function isAdmin(): bool
    {
        return $this->role->id === Role::ADMINISTRATOR;
    }

    public function isDelivery(): bool
    {
        return $this->role->id === Role::DELIVERY;
    }

    public function isManager(): bool
    {
        return $this->role->id === Role::MANAGER;
    }

    public function isCook(): bool
    {
        return $this->role->id === Role::COOK;
    }

    public function hasActiveDelivery()
    {
        return $this->delivery()->where('state', 'delivering');
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

