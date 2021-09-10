<?php


namespace App\Services\Order\Transition;


use App\Models\Order;
use Spatie\ModelStates\Transition;

abstract class OrderTransition extends Transition
{
    protected Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle(): Order
    {
        $this->order->save();
        return $this->order;
    }

}
