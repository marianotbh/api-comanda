<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

use App\Core\Validator;
use App\Services\RoleService;

class RoleController
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
        $id = (int) $args["id"];

        $user = $this->roleService->read($id);

        return $res->withJson(["role" => $user], StatusCode::HTTP_OK);
    }

    function create(Request $req, Response $res, $args)
    {
        $model = Validator::check([
            "name" => ["required", "minLength:5"],
            "description" => ["required", "minLength:5"]
        ], $req->getParsedBody());

        $this->roleService->create($model);

        return $res->withJson(["message" => "User created"], StatusCode::HTTP_OK);
    }

    function update(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $model = Validator::check([
            "name" => ["required", "minLength:5"],
            "description" => ["required", "minLength:5"]
        ],  $req->getParsedBody());

        $this->roleService->update($id, $model);

        return $res->withJson(["message" => "Role edited"], StatusCode::HTTP_OK);
    }

    function delete(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $this->roleService->delete($id);

        return $res->withJson(["message" => "Role deleted"], StatusCode::HTTP_OK);
    }
}
