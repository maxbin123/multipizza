<?php

namespace App\Models;

use App\Events\OrderCreated;
use App\Services\Order\Action\OrderAction;
use App\Services\Order\State\OrderState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStates;

class Order extends Model
{
    use HasFactory, HasStates;

    protected $fillable = [
        'user_id',
        'branch_id',
        'restaurant_id',
    ];

    protected $casts = [
        'state' => OrderState::class,
    ];

    protected $dispatchesEvents = [
        'created' => OrderCreated::class, // Auto confirm orders
    ];

    public function items()
    {
        return $this->morphMany(Item::class, 'itemable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function getSumAttribute()
    {
        return $this->items->sum(fn($item) => $item->sum);
    }

    public function runAction($action)
    {
        OrderAction::run($action, $this);
    }

}
