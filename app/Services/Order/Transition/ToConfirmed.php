<?php


namespace App\Services\Order\Transition;


use App\Models\Order;
use App\Notifications\OrderCreated;
use Illuminate\Support\Facades\Notification;

class ToConfirmed extends OrderTransition
{
    public function handle(): Order
    {
        Notification::send([auth()->user()], new OrderCreated());
        return parent::handle();
    }
}
