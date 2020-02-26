<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

use App\Core\Validator;
use App\Services\UserService;

class UserController
{
    private $userService;

    function __construct()
    {
        $this->userService = new UserService();
    }

    function list(Request $req, Response $res, $args)
    {
        $page = $req->getQueryParam("page", 1);
        $length = $req->getQueryParam("length", 100);
        $field = $req->getQueryParam("field", "id");
        $order = $req->getQueryParam("order", "ASC");

        [
            "data" => $users,
            "total" => $total
        ] = $this->userService->list($page, $length, $field, $order);

        return $res->withHeader("X-Total-Count", $total)
            ->withJson($users, StatusCode::HTTP_OK);
    }

    function create(Request $req, Response $res, $args)
    {
        $model = Validator::check([
            "name" => ["required", "minLength:5"],
            "password" => ["required", "minLength:5"],
            "passwordRepeat" => ["required", "minLength:5"],
            "firstName" => ["required", "minLength:2"],
            "lastName" => ["required", "minLength:2"],
            "email" => ["required", "email"],
            "role" => ["required"]
        ],  $req->getParsedBody());

        $this->userService->create($model);

        return $res->withJson(["message" => "User created"], StatusCode::HTTP_CREATED);
    }

    function read(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $user = $this->userService->read($id);

        return $res->withJson($user, StatusCode::HTTP_OK);
    }

    function update(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $model = Validator::check([
            "firstName" => ["required", "minLength:2"],
            "lastName" => ["required", "minLength:2"],
            "email" => ["required", "email"]
        ],  $req->getParsedBody());

        $this->userService->update($id, $model);

        return $res->withJson(["message" => "User edited"], StatusCode::HTTP_OK);
    }

    function delete(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $this->userService->delete($id);

        return $res->withJson(["message" => "User deleted"], StatusCode::HTTP_OK);
    }
}
