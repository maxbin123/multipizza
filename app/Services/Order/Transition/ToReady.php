<?php


namespace App\Services\Order\Transition;


use App\Models\Order;
use App\Services\Order\State\Ready;

class ToReady extends OrderTransition
{
    public function handle(): Order
    {
        $this->order->state = new Ready($this->order);
        return parent::handle();
    }
}
