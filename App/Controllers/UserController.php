<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

use App\Core\Mapper;
use App\Core\Validator;
use App\Services\UserService;
use App\Models\User;

class UserController
{
    private $userService;

    function __construct()
    {
        $this->userService = new UserService();
    }

    function list(Request $req, Response $res, $args)
    {
        $data = $this->userService->list();

        return $res->withJson(["users" => $data], StatusCode::HTTP_OK);
    }

    function read(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"] ?? -1;

        $user = $this->userService->read($id);

        return $res->withJson(["user" => $user ?: null], StatusCode::HTTP_OK);
    }

    function update(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"] ?? -1;

        $model = Mapper::map(Validator::check([
            "firstName" => "minLength:2",
            "lastName" => "minLength:2",
            "email" => "email",
            "role" => "in:ADMIN;MANAGER;USER"
        ],  $req->getParsedBody()), User::class);

        $this->userService->update($id, $model);

        return $res->withJson(["message" => "User edited"], StatusCode::HTTP_OK);
    }

    function delete(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"] ?? -1;

        $this->userService->delete($id);

        return $res->withJson(["message" => "User deleted"], StatusCode::HTTP_OK);
    }
}
