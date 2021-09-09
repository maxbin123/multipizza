<?php

namespace App\Listeners;

use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\ModelStates\Events\StateChanged;

class OrderStateChange
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  StateChanged  $event
     * @return void
     */
    public function handle(StateChanged $event)
    {
        if (!$event->model instanceof Order) {
            return;
        }
    }
}
