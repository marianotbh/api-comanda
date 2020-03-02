<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use App\Core\Validation\Validator;
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
        $page = $req->getQueryParam("page") ?: 1;
        $length = $req->getQueryParam("length") ?: 100;
        $field = $req->getQueryParam("field") ?: "code";
        $order = $req->getQueryParam("order") ?: "ASC";

        [
            "data" => $orders,
            "total" => $total
        ] = $this->orderService->list($page, $length, $field, $order);

        return $res->withHeader("X-Total-Count", $total)
            ->withJson($orders, StatusCode::HTTP_OK);
    }

    function create(Request $req, Response $res, $args)
    {
        $model = Validator::check([
            "user" => "required",
            "table" => "required",
            "detail" => "required"
        ], $req->getParsedBody());

        $code = $this->orderService->create($model);

        return $res->withJson(["code" => $code], StatusCode::HTTP_CREATED);
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

        return $res->withStatus(StatusCode::HTTP_NO_CONTENT, "Order edited");
    }

    function delete(Request $req, Response $res, $args)
    {
        $code = $args["code"];

        $this->orderService->delete($code);

        return $res->withStatus(StatusCode::HTTP_NO_CONTENT, "Order deleted");
    }

    function getStates(Request $req, Response $res, $args)
    {
        $states = $this->orderService->states();

        return $res->withJson($states, StatusCode::HTTP_OK);
    }
}
