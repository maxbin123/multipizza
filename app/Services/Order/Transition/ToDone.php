<?php


namespace App\Services\Order\Transition;


use App\Jobs\OrderReport;
use App\Models\Order;
use App\Services\Order\State\Done;

class ToDone extends OrderTransition
{
    public function handle(): Order
    {
        OrderReport::dispatch($this->order);

        $this->order->state = new Done($this->order);
        return parent::handle();
    }
}
