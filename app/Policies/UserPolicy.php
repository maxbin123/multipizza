<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization, PolicyByRoles;

    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->isManager();
    }

    public function deliveryView(User $user, User $model): bool
    {
        return $model->deliveries()->contains($user->id);
    }

    public function managerView(User $user, User $model): bool
    {
        return $model->orders->pluck('restaurant_id')->contains($user->restaurant->id);
    }

    public function managerUpdate(User $user, User $model): bool
    {
        return $model->orders->pluck('restaurant_id')->contains($user->restaurant->id);
    }
}
