<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use App\Core\Validation\Validator;
use App\Services\ReviewService;

class ReviewController
{
    private $reviewService;

    function __construct()
    {
        $this->reviewService = new ReviewService();
    }

    function list(Request $req, Response $res, $args)
    {
        $page = $req->getQueryParam("page") ?: 1;
        $length = $req->getQueryParam("length") ?: 100;
        $field = $req->getQueryParam("field") ?: "id";
        $order = $req->getQueryParam("order") ?: "ASC";

        [
            "data" => $reviews,
            "total" => $total
        ] = $this->reviewService->list($page, $length, $field, $order);

        return $res->withHeader("X-Total-Count", $total)
            ->withJson($reviews, StatusCode::HTTP_OK);
    }

    function create(Request $req, Response $res, $args)
    {
        $order = $args["order"];

        $model = Validator::check([
            "name" => ["required", "min" => 1, "max" => 45],
            "description" => ["required", "min" => 1, "max" => 66],
            "email" => ["required", "email", "min" => 1, "max" => 45],
            "menuScore" => ["required", "min" => 1, "max" => 10],
            "tableScore" => ["required", "min" => 1, "max" => 10],
            "serviceScore" => ["required", "min" => 1, "max" => 10],
            "environmentScore" => ["required", "min" => 1, "max" => 10]
        ], $req->getParsedBody());

        $id = $this->reviewService->create($order, $model);

        return $res->withJson(["id" => $id], StatusCode::HTTP_CREATED);
    }

    function read(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $review = $this->reviewService->read($id);

        return $res->withJson($review, StatusCode::HTTP_OK);
    }

    function update(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $model = Validator::check([
            "name" => ["required", "min" => 1, "max" => 45],
            "description" => ["required", "min" => 1, "max" => 66],
            "email" => ["required", "email", "min" => 1, "max" => 45],
            "menuScore" => ["required", "min" => 1, "max" => 10],
            "tableScore" => ["required", "min" => 1, "max" => 10],
            "serviceScore" => ["required", "min" => 1, "max" => 10],
            "environmentScore" => ["required", "min" => 1, "max" => 10]
        ],  $req->getParsedBody());

        $this->reviewService->update($id, $model);

        return $res->withStatus(StatusCode::HTTP_OK, "Review edited");
    }

    function delete(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $this->reviewService->delete($id);

        return $res->withStatus(StatusCode::HTTP_OK, "Review deleted");
    }

    function changeState(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $this->reviewService->changeState($id);

        return $res->withStatus(StatusCode::HTTP_NO_CONTENT, "Menu state updated");
    }

    function getAverages(Request $req, Response $res, $args)
    {
        $averages = $this->reviewService->averages();

        return $res->withJson($averages, StatusCode::HTTP_OK);
    }
}
