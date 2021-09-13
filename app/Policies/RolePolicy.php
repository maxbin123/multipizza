<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization, PolicyByRoles;

    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

}
