<?php

namespace App\Nova\Actions;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

class ChangeOrderState extends Action
{
    use InteractsWithQueue, Queueable;

    private $id;

    public function __construct($id = null)
    {
        $this->id = $id;
    }

    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $model->state->transitionTo($fields->state);
        }
    }

    public function fields()
    {
        $order = Order::find($this->id);
        $options = [];
        $states = $order ? $order->state->transitionableStates() : Order::getStatesFor('state');
        foreach ($states as $state) {
            $options[$state] = Str::ucfirst($state);
        }
        return [
            Select::make('State')->options($options),
        ];
    }
}
