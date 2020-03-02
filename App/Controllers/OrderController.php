<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use App\Core\Validation\Validator;
use App\Services\OrderService;

use function App\Services\jsonize;

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

        $filters = [];
        if ($req->getQueryParam("from") !== null) $filters["createdAt"] = array(">=", $req->getQueryParam("from"));
        if ($req->getQueryParam("to") !== null) $filters["createdAt"] = array("<=", $req->getQueryParam("to"));
        if ($req->getQueryParam("state") !== null) $filters["state"] = array("=", $req->getQueryParam("state"));
        if ($req->getQueryParam("user") !== null) $filters["user"] = array("=", $req->getQueryParam("user"));
        if ($req->getQueryParam("table") !== null) $filters["table"] = array("=", $req->getQueryParam("table"));

        [
            "data" => $orders,
            "total" => $total
        ] = $this->orderService->list($filters, $page, $length, $field, $order);

        return $res->withHeader("X-Total-Count", $total)
            ->withJson($orders, StatusCode::HTTP_OK);
    }

    function create(Request $req, Response $res, $args)
    {
        $model = Validator::check([
            "user" => "required",
            "table" => "required",
            "detail" => ["required", "min" => 1, "collection" => function ($item) {
                $errors = [];
                if (!isset($item["menu"]) || $item["menu"] === null) $errors[] = "Detail menu id is required";
                if (!isset($item["amount"]) || $item["amount"] === null) $errors[] = "Detail amount is required";
                if ($item["amount"] < 1) $errors[] = "Detail amount should be more than 0";
                return count($errors) > 0 ? $errors : true;
            }]
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

    function changeState(Request $req, Response $res, $args)
    {
        $code = $args["code"];

        $this->orderService->changeState($code);

        return $res->withStatus(StatusCode::HTTP_NO_CONTENT, "Order state updated");
    }
}
