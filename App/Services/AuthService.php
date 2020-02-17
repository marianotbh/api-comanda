<?php

namespace App\Services;

use App\Core\Exceptions\AppException;
use App\Core\Utils\JWTHelper;
use App\Models\User;

class AuthService
{
    function login($username, $password, $remember = false)
    {
        $user = User::findByName($username);

        if ($user != null) {
            if (password_verify($password, $user->password)) {
                $user->last_login_at = date('Y-m-d H:i:s');
                $user->edit();
                return JWTHelper::encode(json_decode(json_encode($user)), $remember);
            } else {
                throw new AppException("Password is incorrect");
            }
        } else {
            throw new AppException("User not found");
        }
    }

    function register($model)
    {
        $user = User::findByName($model->name);

        if ($user == null) {
            if ($model->password == $model->passwordRepeat) {
                $passwordHash = password_hash($model->password, PASSWORD_DEFAULT);

                $user = new User();

                $user->name = $model->name;
                $user->password = $passwordHash;
                $user->email = $model->email;
                $user->role = $model->role;

                return $user->create();
            } else {
                throw new AppException("Passwords don't match");
            }
        } else {
            throw new AppException("Username already taken");
        }
    }
}
