<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BranchPolicy
{
    use HandlesAuthorization, PolicyByRoles;

    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }
}
