<?php


namespace App\Services\Order\Transition;


use App\Models\Order;
use App\Services\Order\State\Cooking;

class ToCooking extends OrderTransition
{
    public function handle(): Order
    {
        $this->order->state = new Cooking($this->order);
        return parent::handle();
    }
}
