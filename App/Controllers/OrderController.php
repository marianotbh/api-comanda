<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

use App\Core\Validator;
use App\Services\OrderService;

class OrderController
{
    private $orderService;

    function __construct()
    {
        $this->orderService = new OrderService();
    }

    function list(Request $req, Response $res, $args)
    {
        $data = $this->orderService->list();

        return $res->withJson(["orders" => $data], StatusCode::HTTP_OK);
    }

    function create(Request $req, Response $res, $args)
    {
        $model = Validator::check([
            "user" => "required",
            "table" => "required"
        ], $req->getParsedBody());

        $this->orderService->create($model);

        return $res->withJson(["message" => "Order created"], StatusCode::HTTP_OK);
    }

    function read(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $order = $this->orderService->read($id);

        return $res->withJson(["order" => $order ?: null], StatusCode::HTTP_OK);
    }

    function update(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $model = Validator::check([
            "firstName" => ["required", "minLength:2"],
            "lastName" => ["required", "minLength:2"],
            "email" => ["required", "email"],
            "role" => ["required"]
        ],  $req->getParsedBody());

        $this->orderService->update($id, $model);

        return $res->withJson(["message" => "Order edited"], StatusCode::HTTP_OK);
    }

    function delete(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $this->orderService->delete($id);

        return $res->withJson(["message" => "Order deleted"], StatusCode::HTTP_OK);
    }
}
