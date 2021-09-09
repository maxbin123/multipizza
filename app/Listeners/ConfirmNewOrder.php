<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Services\Order\State\Confirmed;

class ConfirmNewOrder
{
    public function handle(OrderCreated $event)
    {
        if ($event->order->state->getValue() === 'created') {
            $event->order->state->transitionTo(Confirmed::class);
        }
    }
}
