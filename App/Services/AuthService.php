<?php

namespace App\Services;

use App\Core\Exceptions\AppException;
use App\Core\Utils\JWTHelper;
use App\Models\Role;
use App\Models\User;

class AuthService
{
    function login($username, $password, $remember = false)
    {
        $user = User::findByName($username);

        if ($user == null) throw new AppException("User not found");
        if (!password_verify($password, $user->password)) throw new AppException("Password is incorrect");

        $user->last_login_at = date('Y-m-d H:i:s');
        $user->edit();
        $payload = json_decode(json_encode($user));

        return JWTHelper::encode($payload, $remember);
    }

    function register($model)
    {
        $user = User::findByName($model->name);

        if ($user != null) throw new AppException("Username already taken");
        if ($model->password != $model->passwordRepeat) throw new AppException("Passwords don't match");

        $roles = array_map(function (Role $role) {
            return $role->id;
        }, Role::whereRemoved_at(null)->fetch());

        if (!in_array($model->role, $roles)) throw new AppException("Invalid role");

        $user = new User();

        $user->name = $model->name;
        $user->password = password_hash($model->password, PASSWORD_DEFAULT);
        $user->email = $model->email;
        $user->role = $model->role;

        return $user->create();
    }
}
