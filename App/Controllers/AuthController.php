<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use App\Core\Validation\Validator;
use App\Core\Exceptions\AppException;
use App\Services\AuthService;

class AuthController
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login(Request $req, Response $res, $args)
    {
        $model = Validator::check([
            "username" => "required",
            "password" => "required",
            "remember" => "required"
        ], $req->getParsedBody());

        $token = $this->authService->login(
            $model->username,
            $model->password,
            $model->remember
        );

        return $res->withJson(["token" => $token], StatusCode::HTTP_OK);
    }

    public function status(Request $req, Response $res, $args)
    {
        $token = $req->getAttribute("payload");

        if ($token == null) {
            throw new AppException("Payload is null");
        }

        return $res->withStatus(StatusCode::HTTP_OK);
    }

    public function getRoles(Request $req, Response $res, $args)
    {
        $roles = $this->authService->roles();

        return $res->withJson($roles, StatusCode::HTTP_OK);
    }

    public function changePassword(Request $req, Response $res, $args)
    {
        $id = $req->getAttribute("payload")->id;

        $model = Validator::check([
            "oldPassword" => "required",
            "newPassword" => ["required", "min" => 5],
            "newPasswordRepeat" => ["required", "min" => 5]
        ], $req->getParsedBody());

        $this->authService->changePassword(
            $id,
            $model->oldPassword,
            $model->newPassword,
            $model->newPasswordRepeat
        );

        return $res->withStatus(StatusCode::HTTP_NO_CONTENT, "Password changed");
    }
}
