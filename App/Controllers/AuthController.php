<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

use App\Core\Validator;
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

    public function register(Request $req, Response $res, $args)
    {
        $model = Validator::check([
            "name" => ["required", "minLength:5"],
            "password" => ["required", "minLength:5"],
            "passwordRepeat" => ["required", "minLength:5"],
            "email" => ["required", "email"],
            "role" => ["required", "in:1;2;3"]
        ], $req->getParsedBody());

        $this->authService->register($model);

        return $res->withJson(["message" => "User created"], StatusCode::HTTP_OK);
    }

    public function status(Request $req, Response $res, $args)
    {
        $token = $req->getAttribute("payload", null);

        if ($token == null) {
            throw new AppException("Payload is null");
        }

        return $res->withJson(["message" => "OK"], StatusCode::HTTP_OK);
    }

    public function changePassword(Request $req, Response $res, $args)
    {
    }
}
