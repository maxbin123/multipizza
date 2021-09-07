<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class CategoryRoot extends BooleanFilter
{

    public $name = 'Filter';

    public function default()
    {
        return [
            'root' => true,
        ];
    }

    public function apply(Request $request, $query, $value)
    {
        if ($value['root']) {
            return $query->whereNull('parent_id');
        }
    }

    public function options(Request $request)
    {
        return [
            'Root only' => 'root',
        ];
    }
}
