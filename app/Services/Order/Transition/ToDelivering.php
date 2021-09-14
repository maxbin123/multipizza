<?php


namespace App\Services\Order\Transition;


use App\Models\Order;
use App\Services\Order\State\Delivering;

class ToDelivering extends OrderTransition
{
    public function handle(): Order
    {
        $this->order->state = new Delivering($this->order);
        return parent::handle();
    }
}
