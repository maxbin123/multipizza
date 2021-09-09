<?php


namespace App\Services\Order\State;


use App\Services\Order\Transition\ToConfirmed;
use App\Services\Order\Transition\ToCooking;
use App\Services\Order\Transition\ToDelivering;
use App\Services\Order\Transition\ToDone;
use App\Services\Order\Transition\ToFailed;
use App\Services\Order\Transition\ToReady;
use App\Services\Order\Transition\ToTaken;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class OrderState extends State
{

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Created::class)
            ->allowTransitions([
                [Created::class, Confirmed::class, ToConfirmed::class],
                [Confirmed::class, Taken::class, ToTaken::class],
                [Confirmed::class, Failed::class, ToFailed::class],
                [Taken::class, Cooking::class, ToCooking::class],
                [Taken::class, Failed::class, ToFailed::class],
                [Cooking::class, Ready::class, ToReady::class],
                [Cooking::class, Failed::class, ToFailed::class],
                [Ready::class, Delivering::class, ToDelivering::class],
                [Ready::class, Failed::class, ToFailed::class],
                [Delivering::class, Done::class, ToDone::class],
                [Delivering::class, Failed::class, ToFailed::class],
            ]);
    }

    public function actions()
    {
        return [

        ];
    }

}
