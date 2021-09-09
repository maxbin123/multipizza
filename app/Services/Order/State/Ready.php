<?php


namespace App\Services\Order\State;


use Spatie\ModelStates\StateConfig;

class Ready extends OrderState
{
    public static $name = 'ready';
}
