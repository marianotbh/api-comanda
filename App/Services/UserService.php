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
        if (User::findByName($model->name) != null) throw new AppException("Username already taken");
        if ($model->password != $model->passwordRepeat) throw new AppException("Passwords don't match");
        if ($model->role == Role::ADMIN && User::findByRole(Role::ADMIN) != null) throw new AppException("There can only be one Admin user");
        if (!in_array($model->role, array_map(fn (Role $role) => $role->id, Role::all()->fetch()))) throw new AppException("Invalid role");

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
    function read($name)
    {
        return User::findByName($name);
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
        $user->role = $model->role;
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
