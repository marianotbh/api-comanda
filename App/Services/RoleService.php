<?php

namespace App\Services;

use App\Models\Role;
use App\Core\Exceptions\AppException;

class RoleService
{
    function list()
    {
        /** @var Role[] */
        $roles = Role::whereRemoved_at(null)
            ->orderBy("name")
            ->take(10)
            ->fetch();

        return $roles;
    }

    function read($id)
    {
        /** @var Role */
        $role = Role::findById($id);

        return $role;
    }

    function create($model)
    {
        $role = new Role();

        $role->name = $model->name;
        $role->description = $model->description;

        return $role->create();
    }

    function update($id, $model)
    {
        /** @var Role */
        $role = Role::findById($id);

        if ($role == null) {
            throw new AppException("Role not found");
        }

        $role->name = $model->name;
        $role->description = $model->description;
        $role->updated_at = date('Y-m-d H:i:s');

        return $role->edit();
    }

    function remove($id)
    {
        /** @var Role */
        $role = Role::findById($id);

        if ($role == null) {
            throw new AppException("Role not found");
        }

        $role->removed_at = date('Y-m-d H:i:s');

        return $role->edit();
    }

    function delete($id)
    {
        /** @var Role */
        $role = Role::findById($id);

        if ($role == null) {
            throw new AppException("Role not found");
        }

        return $role->delete();
    }
}
