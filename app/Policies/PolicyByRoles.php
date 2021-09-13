<?php


namespace App\Policies;

trait PolicyByRoles
{
    public function __call(string $method, array $params): bool
    {
        $user = $params[0];
        $role = $user->role->slug;

        if ($role === 'admin') {
            return true;
        }

        $method = $role . ucfirst($method);
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $params);
        } else {
            return false;
        }
    }
}
