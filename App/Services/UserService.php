<?php

namespace App\Services;

use App\Models\User;
use App\Core\Exceptions\AppException;
use App\Models\Role;

use function App\Core\Utils\kebabize;

class UserService
{
    function list($page = 1, $length = 100, $field = "id", $order = "ASC")
    {
        return [
            "data" => User::all()
                ->skip(($page - 1) * $length)
                ->take($length)
                ->orderBy(kebabize($field), $order)
                ->fetch(),
            "total" => User::count()
        ];
    }

    function create($model)
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
        $user->first_name = $model->firstName;
        $user->last_name = $model->lastName;
        $user->password = password_hash($model->password, PASSWORD_DEFAULT);
        $user->email = $model->email;
        $user->role = $model->role;

        return $user->create();
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

        if ($user == null) throw new AppException("User not found");

        $user->email = $model->email;
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

        if ($user == null) throw new AppException("User not found");

        return $user->delete();
    }
}
