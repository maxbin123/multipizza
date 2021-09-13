<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization, PolicyByRoles;

    public function deliveryView(User $user, Order $order)
    {
        return $order->delivery->id === $user->id || $order->state =='confirmed';
    }

    public function managerView(User $user, Order $order)
    {
        return $order->restaurant->id === $user->restaurant->id;
    }

    public function cookView(User $user, Order $order)
    {
        return $order->restaurant->id === $user->restaurant->id;
    }

}
