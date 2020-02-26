<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

use App\Core\Validator;
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
            "name" => ["required", "minLength:5"],
            "description" => ["required", "minLength:5"]
        ], $req->getParsedBody());

        $this->reviewService->create($model);

        return $res->withJson(["message" => "Review created"], StatusCode::HTTP_OK);
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
            "firstName" => ["required", "minLength:2"],
            "lastName" => ["required", "minLength:2"],
            "email" => ["required", "email"],
            "role" => ["required"]
        ],  $req->getParsedBody());

        $this->reviewService->update($id, $model);

        return $res->withJson(["message" => "Review edited"], StatusCode::HTTP_OK);
    }

    function delete(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $this->reviewService->delete($id);

        return $res->withJson(["message" => "Review deleted"], StatusCode::HTTP_OK);
    }
}
