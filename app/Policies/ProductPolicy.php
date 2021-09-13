<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization, PolicyByRoles;

    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->isManager();
    }

    public function managerView(User $user, Product $product): bool
    {
        return $product->branch->id === $user->restaurant->branch->id;
    }

    public function managerUpdate(User $user, Product $product): bool
    {
        return $product->branch->id === $user->restaurant->branch->id;
    }

    public function managerDelete(User $user, Product $product): bool
    {
        return $product->branch->id === $user->restaurant->branch->id;
    }

}
