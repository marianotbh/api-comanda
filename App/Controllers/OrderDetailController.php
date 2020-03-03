<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use App\Core\Validation\Validator;
use App\Services\OrderDetailService;


class OrderDetailController
{
    private $orderDetailService;

    function __construct()
    {
        $this->orderDetailService = new OrderDetailService();
    }

    function list(Request $req, Response $res, $args)
    {
        $role = $req->getAttribute("payload")->role;

        $page = $req->getQueryParam("page") ?: 1;
        $length = $req->getQueryParam("length") ?: 100;
        $field = $req->getQueryParam("field") ?: "id";
        $order = $req->getQueryParam("order") ?: "ASC";

        [
            "data" => $details,
            "total" => $total
        ] = $this->orderDetailService->list($role, $page, $length, $field, $order);

        return $res->withHeader("X-Total-Count", $total)
            ->withJson($details, StatusCode::HTTP_OK);
    }

    function create(Request $req, Response $res, $args)
    {
        $order = $args["order"];

        $model = Validator::check([
            "menu" => "required",
            "amount" => ["required", "min" => 1, "max" => 100]
        ], $req->getParsedBody());

        $id = $this->orderDetailService->create($order, $model);

        return $res->withJson(["id" => $id], StatusCode::HTTP_CREATED);
    }

    function read(Request $req, Response $res, $args)
    {
        $order = $args["order"];
        $id = (int) $args["id"];

        $order = $this->orderDetailService->read($order, $id);

        return $res->withJson($order, StatusCode::HTTP_OK);
    }

    function update(Request $req, Response $res, $args)
    {
        $order = $args["order"];
        $id = (int) $args["id"];

        $model = Validator::check([
            "amount" => ["required", "min" => -100, "max" => 100]
        ],  $req->getParsedBody());

        $this->orderDetailService->update($order, $id, $model);

        return $res->withStatus(StatusCode::HTTP_NO_CONTENT, "Order detail edited");
    }

    function delete(Request $req, Response $res, $args)
    {
        $order = $args["order"];
        $id = (int) $args["id"];

        $this->orderDetailService->delete($order, $id);

        return $res->withStatus(StatusCode::HTTP_NO_CONTENT, "Order detail deleted");
    }

    function getStates(Request $req, Response $res, $args)
    {
        $states = $this->orderDetailService->states();

        return $res->withJson($states, StatusCode::HTTP_OK);
    }

    function take(Request $req, Response $res, $args)
    {
        $order = $args["order"];
        $id = (int) $args["id"];
        $user = $req->getAttribute("payload")->id;

        $model = Validator::check([
            "estimated" => ["required", "min" => 1, "max" => 60]
        ],  $req->getParsedBody());

        $this->orderDetailService->take($order, $id, $user, $model);

        return $res->withStatus(StatusCode::HTTP_NO_CONTENT, "Order taken");
    }

    function complete(Request $req, Response $res, $args)
    {
        $order = $args["order"];
        $id = (int) $args["id"];
        $user = $req->getAttribute("payload")->id;

        $this->orderDetailService->complete($order, $id, $user);

        return $res->withStatus(StatusCode::HTTP_NO_CONTENT, "Order completed");
    }
}
