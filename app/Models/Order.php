<?php

namespace App\Models;

use App\Events\OrderCreated;
use App\Services\Order\State\OrderState;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Malhal\Geographical\Geographical;
use Spatie\ModelStates\HasStates;

class Order extends Model
{
    use HasFactory, HasStates, Geographical;

    protected $guarded = [
        'state',
    ];

    protected $casts = [
        'state' => OrderState::class,
    ];

    protected $dispatchesEvents = [
        'created' => OrderCreated::class, // Auto confirm orders
    ];

    protected $with = [
        'items',
        'user',
        'branch',
        'restaurant'
    ];

    protected static $kilometers = true;

    public function items()
    {
        return $this->morphMany(Item::class, 'itemable');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->with('restaurant');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function delivery()
    {
        return $this->belongsTo(User::class, 'delivery_id');
    }

    public function getSumAttribute()
    {
        return $this->items->sum(fn($item) => $item->sum);
    }

    public function getNearestRestaurant(): Restaurant
    {
        return Restaurant::where('branch_id', $this->branch->id)->distance($this->latitude, $this->longitude)->orderBy('distance', 'ASC')->first();
    }

    public function restaurantDistance()
    {
        return round($this->getNearestRestaurant()->distance, 1);
    }

    public function scopeInDelivery(Builder $query)
    {
        return $query->whereIn('state', ['confirmed', 'taken', 'delivering']);
    }

}
