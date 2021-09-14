<?php


namespace App\Services\Order\Transition;


use App\Jobs\OrderReport;
use App\Models\Order;
use App\Models\User;
use App\Notifications\Staff\OrderCreated;
use App\Services\Order\State\Confirmed;
use Illuminate\Support\Facades\Notification;

class ToConfirmed extends OrderTransition
{
    public function handle(): Order
    {
        OrderReport::dispatch($this->order);
        Notification::send(User::admins()->get(), new OrderCreated());

        $this->order->state = new Confirmed($this->order);
        return parent::handle();
    }
}
