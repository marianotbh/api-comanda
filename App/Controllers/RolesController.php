<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

use App\Core\Mapper;
use App\Core\Validator;
use App\Services\RoleService;
use App\Models\Role;

class RolesController
{
    private $roleService;

    function __construct()
    {
        $this->roleService = new RoleService();
    }

    function list(Request $req, Response $res, $args)
    {
        $data = $this->roleService->list();

        return $res->withJson(["roles" => $data], StatusCode::HTTP_OK);
    }

    function read(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"] ?? -1;

        $user = $this->roleService->read($id);

        return $res->withJson(["role" => $user], StatusCode::HTTP_OK);
    }

    function create(Request $req, Response $res, $args)
    {
        $model = Validator::check([
            "name" => ["required", "minLength:5"],
            "description" => ["minLength:5"]
        ], $req->getParsedBody());

        $this->roleService->create($model);

        return $res->withJson(["message" => "User created"], StatusCode::HTTP_OK);
    }

    function update(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"] ?? -1;

        $model = Mapper::map(Validator::check([
            "name" => "required",
        ],  $req->getParsedBody()), Role::class);

        $this->roleService->update($id, $model);

        return $res->withJson(["message" => "Role edited"], StatusCode::HTTP_OK);
    }

    function delete(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"] ?? -1;

        $this->roleService->delete($id);

        return $res->withJson(["message" => "Role deleted"], StatusCode::HTTP_OK);
    }
}
