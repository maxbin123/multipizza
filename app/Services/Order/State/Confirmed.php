<?php


namespace App\Services\Order\State;


use App\Services\Order\Action\Take;
use Spatie\ModelStates\StateConfig;

class Confirmed extends OrderState
{
    public static $name = 'confirmed';
}
