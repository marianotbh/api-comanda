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
        $reviews = $this->reviewService->list();

        return $res->withJson($reviews, StatusCode::HTTP_OK);
    }

    function create(Request $req, Response $res, $args)
    {
        $model = Validator::check([
            "name" => ["required", "min" => 5],
            "description" => ["required", "min" => 5]
        ], $req->getParsedBody());

        $id = $this->reviewService->create($model);

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
            "firstName" => ["required", "min" => 2],
            "lastName" => ["required", "min" => 2],
            "email" => ["required", "email"],
            "role" => ["required"]
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

        $this->menuService->changeState($id);

        return $res->withStatus(StatusCode::HTTP_NO_CONTENT, "Menu state updated");
    }
}
