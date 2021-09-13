<?php

namespace App\Policies;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RestaurantPolicy
{
    use HandlesAuthorization, PolicyByRoles;

    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->isManager();
    }

    public function managerView(User $user, Restaurant $restaurant)
    {
        return $user->restaurant->id === $restaurant->id;
    }

    public function managerUpdate(User $user, Restaurant $restaurant)
    {
        return $user->restaurant->id === $restaurant->id;
    }

}
