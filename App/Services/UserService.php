<?php

namespace App\Services;

use App\Models\User;
use App\Core\Exceptions\AppException;

class UserService
{
    function list()
    {
        return User::all();
    }

    function read($id)
    {
        return User::findById($id);
    }

    function create(User $model)
    {
        if (User::findByName($model->name)) {
            throw new AppException("Username already taken");
        }

        return User::create($model);
    }

    function update($id, User $model)
    {
        if (User::findById($id) == null) {
            throw new AppException("User not found");
        }

        User::edit($id, $model);
        User::editUpdated_at($id, date('Y-m-d H:i:s'));

        return true;
    }

    function delete($id)
    {
        if (User::findById($id) == null) {
            throw new AppException("User not found");
        }

        return User::delete($id);
    }
}
