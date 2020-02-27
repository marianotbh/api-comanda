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
        $orders = $this->orderService->list();

        return $res->withJson($orders, StatusCode::HTTP_OK);
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
        $code = $args["code"];

        $order = $this->orderService->read($code);

        return $res->withJson($order, StatusCode::HTTP_OK);
    }

    function update(Request $req, Response $res, $args)
    {
        $code = $args["code"];

        $model = Validator::check([
            "user" => "required",
            "table" => "required",
            "detail" => "required"
        ],  $req->getParsedBody());

        $this->orderService->update($code, $model);

        return $res->withJson(["message" => "Order edited"], StatusCode::HTTP_OK);
    }

    function delete(Request $req, Response $res, $args)
    {
        $code = $args["code"];

        $this->orderService->delete($code);

        return $res->withJson(["message" => "Order deleted"], StatusCode::HTTP_OK);
    }

    function getStates(Request $req, Response $res, $args)
    {
        $states = $this->orderService->states();

        return $res->withJson($states, StatusCode::HTTP_OK);
    }
}
