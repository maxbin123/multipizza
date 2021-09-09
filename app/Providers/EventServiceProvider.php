<?php

namespace App\Providers;

use App\Events\OrderCreated;
use App\Listeners\ConfirmNewOrder;
use App\Listeners\OrderStateChange;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Spatie\ModelStates\Events\StateChanged;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        StateChanged::class => [
            OrderStateChange::class,
        ],
        OrderCreated::class => [
            ConfirmNewOrder::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
