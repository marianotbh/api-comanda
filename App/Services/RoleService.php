<?php

namespace App\Services;

use App\Models\Role;
use App\Core\Exceptions\AppException;

class RoleService
{
    function list()
    {
        return Role::all();
    }

    function read($id)
    {
        return Role::findById($id);
    }

    function create(Role $model)
    {
        if (Role::findByName($model->name)) {
            throw new AppException("Rolename already taken");
        }

        return Role::create($model);
    }

    function update($id, Role $model)
    {
        if (Role::findById($id)) {
            throw new AppException("Role not found");
        }

        return Role::edit($id, $model);
    }

    function delete($id)
    {
        if (Role::findById($id)) {
            throw new AppException("Role not found");
        }

        return Role::delete($id);
    }
}
