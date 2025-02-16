<?php

namespace App\Controllers;

use App\Core\Exceptions\AppException;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use App\Core\Validation\Validator;
use App\Services\UserService;
use App\Models\Role;

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
        $body = $req->getParsedBody();
        $files = $req->getUploadedFiles();

        $model = Validator::check([
            "name" => ["required", "min" => 5],
            "password" => ["required", "min" => 5],
            "passwordRepeat" => ["required", "min" => 5],
            "firstName" => ["required", "min" => 2],
            "lastName" => ["required", "min" => 2],
            "email" => ["required", "min" => 2, "email"],
            "role" => "required"
        ], $body);

        $id = $this->userService->create($model, isset($files["avatar"]) ? $files["avatar"] : null);

        return $res->withJson(["id" => $id], StatusCode::HTTP_CREATED);
    }

    function read(Request $req, Response $res, $args)
    {
        $name = $args["name"];

        $user = $this->userService->read($name);

        return $res->withJson($user, StatusCode::HTTP_OK);
    }

    function update(Request $req, Response $res, $args)
    {
        $body = $req->getParsedBody();
        $files = $req->getUploadedFiles();

        $id = (int) $args["id"];
        $requester = $req->getAttribute("payload");

        if ($requester->id != $id && $requester->role != Role::ADMIN && $requester->role != Role::MANAGER)
            throw new AppException("You cannot edit other users' personal information");

        $model = Validator::check([
            "firstName" => ["required", "min" => 2],
            "lastName" => ["required", "min" => 2],
            "email" => ["required", "email"]
        ],  $body);

        if (isset($model->role) && ($requester->role != Role::ADMIN && $requester->role != Role::MANAGER))
            throw new AppException("Insufficient permissions to edit the users' role");

        $this->userService->update($id, $model, isset($files["avatar"]) ? $files["avatar"] : null);

        return $res->withStatus(StatusCode::HTTP_NO_CONTENT, "User edited");
    }

    function delete(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $this->userService->delete($id);

        return $res->withStatus(StatusCode::HTTP_NO_CONTENT, "User deleted");
    }

    function changeState(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $this->userService->changeState($id);

        return $res->withStatus(StatusCode::HTTP_NO_CONTENT, "User state updated");
    }

    function stats(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $stats = $this->userService->stats($id);

        return $res->withJson($stats, StatusCode::HTTP_OK);
    }
}
