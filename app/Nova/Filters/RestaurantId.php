<?php

namespace App\Nova\Filters;

use App\Models\Branch;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class RestaurantId extends Filter
{
    public $component = 'select-filter';

    public $name = 'Restaurant Filter';

    public function apply(Request $request, $query, $value)
    {
        return $query->where('restaurant_id', $value);
    }

    public function options(Request $request)
    {
        return Restaurant::all()->pluck('id', 'address');
    }
}
