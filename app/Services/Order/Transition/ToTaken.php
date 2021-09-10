<?php


namespace App\Services\Order\Transition;


use App\Models\Order;
use App\Models\User;
use App\Notifications\Staff\OrderTaken;
use App\Services\Order\State\Taken;
use Illuminate\Support\Facades\Notification;

class ToTaken extends OrderTransition
{
    public function handle(): Order
    {
        Notification::send(User::admins()->get(), new OrderTaken());

        $this->order->state = new Taken($this->order);
        return parent::handle();
    }

}
