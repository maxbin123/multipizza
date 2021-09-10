<?php


namespace App\Services\Order\Transition;


use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderCreated;
use App\Services\Order\State\Confirmed;
use Illuminate\Support\Facades\Notification;

class ToConfirmed extends OrderTransition
{
    public function handle(): Order
    {
        Notification::send(User::admins()->get(), new OrderCreated());

        $this->order->state = new Confirmed($this->order);
        return parent::handle();
    }
}
