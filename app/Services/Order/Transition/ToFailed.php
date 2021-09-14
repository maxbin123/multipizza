<?php


namespace App\Services\Order\Transition;


use App\Models\Order;
use App\Services\Order\State\Failed;

class ToFailed extends OrderTransition
{
    public function handle(): Order
    {
        $this->order->state = new Failed($this->order);
        return parent::handle();
    }
}
