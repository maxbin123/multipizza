<?php

namespace App\Listeners;

use App\Events\OrderCreated;

class ConfirmNewOrder
{
    public function handle(OrderCreated $event)
    {
        $event->order->state->transitionTo('confirmed');
    }
}
