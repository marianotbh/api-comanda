<?php

namespace App\Services;

use App\Models\User;
use App\Core\Exceptions\AppException;

class UserService
{
    function list()
    {
        return User::all()->fetch();
    }

    /** @return User */
    function read($id)
    {
        return User::findById($id);
    }

    /** @return bool */
    function update($id, $model)
    {
        /** @var User */
        $user = User::findById($id);

        if ($user == null) {
            throw new AppException("User not found");
        }

        $user->first_name = $model->firstName;
        $user->last_name = $model->lastName;
        $user->updated_at = date('Y-m-d H:i:s');

        return $user->edit();
    }

    /** @return bool */
    function delete(int $id)
    {
        /** @var User */
        $user = User::findById($id);

        if ($user == null) {
            throw new AppException("User not found");
        }

        return $user->delete();
    }
}
