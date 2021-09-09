<?php


namespace App\Services\Order\State;


use App\Services\Order\Action\Take;
use Spatie\ModelStates\StateConfig;

class Created extends OrderState
{
    public static $name = 'created';

    public function actions()
    {
        return array_merge(parent::actions(), [
            Take::class,
        ]);
    }

}
