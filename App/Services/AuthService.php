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
                User::editLast_login_at($user->id, date('Y-m-d H:i:s'));
                $user = User::find($user->id);
                return JWTHelper::encode(json_decode(json_encode($user)), $remember ? false : true);
            } else {
                throw new AppException("Password is incorrect");
            }
        } else {
            throw new AppException("User not found");
        }
    }

    function register($model)
    {
        [
            'name' => $username,
            'password' => $password,
            'passwordRepeat' => $passwordRepeat,
            'email' => $email,
            'role' => $role
        ] = $model;

        $user = User::findByName($username);

        if ($user == null) {
            if ($password == $passwordRepeat) {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                User::create([
                    "name" => $username,
                    "password" => $passwordHash,
                    "email" => $email,
                    "role" => $role
                ]);
            } else {
                throw new AppException("Passwords don't match");
            }
        } else {
            throw new AppException("Username already taken");
        }
    }
}
