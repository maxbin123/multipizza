<?php


namespace App\Services\Order\Transition;


use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderCreated;
use Illuminate\Support\Facades\Notification;

class ToConfirmed extends OrderTransition
{
    public function handle(): Order
    {
        Notification::send(User::admins()->get(), new OrderCreated());
        return parent::handle();
    }
}
