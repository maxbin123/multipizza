<?php

namespace App\Nova\Filters;

use App\Models\Role;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class UserType extends BooleanFilter
{
    public function apply(Request $request, $query, $value)
    {
        foreach ($value as $role_id => $flag) {
            if ($flag) {
                $query->orWhere('role_id', $role_id);
            }
        }
        return $query;
    }

    public function options(Request $request)
    {
        return Role::all()->pluck('id', 'name');
    }
}
