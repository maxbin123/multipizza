<?php

namespace App\Nova;

use App\Nova\Actions\ChangeOrderState;
use App\Nova\Filters\BranchId;
use App\Nova\Filters\RestaurantId;
use GeneaLabs\NovaMapMarkerField\MapMarker;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Status;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Panel;

class Order extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Order::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static $group = "Orders";

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            BelongsTo::make('User')->showCreateRelationButton()->searchable(),

            Currency::make('Sum')->currency('RUB')->hideWhenCreating()->hideWhenUpdating(),
            DateTime::make('Created At'),

            Status::make('State')
                ->loadingWhen(['confirmed', 'delivering'])
                ->failedWhen(['failed']),

            new Panel('Address Information', $this->addressFields()),

            MapMarker::make('Location')
                ->latitude('latitude')
                ->longitude('longitude')
                ->defaultZoom(16)
                ->searchProvider('openstreetmap'),

            Text::make('Distance', function () {
                return $this->model()->restaurantDistance() . ' km';
            }),

            MorphMany::make('Items'),

            BelongsTo::make('Delivery', 'delivery', User::class)->nullable()->searchable(),

            BelongsTo::make('Branch'),
            BelongsTo::make('Restaurant'),

        ];
    }

    protected function addressFields()
    {
        return [
            Text::make('Address'),
            Text::make('Door')->hideFromIndex(),
            Text::make('Floor')->hideFromIndex(),
            Text::make('Flat')->hideFromIndex(),
            Text::make('Code')->hideFromIndex(),
        ];
    }


    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new BranchId(),
            new RestaurantId(),
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            (new ChangeOrderState($request->resourceId))->onlyOnDetail(),
        ];
    }
}
