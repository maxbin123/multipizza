<?php


namespace App\Policies;


use App\Models\User;
use Illuminate\Support\Str;

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

//        dd($method);

        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $params);
        } else {
//            dump($method);
            return false;
        }
    }
//
//    public function create(User $user)
//    {
//        //
//    }
//
//    public function update(User $user, $model)
//    {
//        //
//    }
//
//    public function delete(User $user, $model)
//    {
//        //
//    }
//
//    public function restore(User $user, $model)
//    {
//        //
//    }
//
//    public function forceDelete(User $user, $model)
//    {
//        //
//    }

}
