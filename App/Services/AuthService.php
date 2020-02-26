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

    function roles()
    {
        return Role::all()->fetch();
    }
}
