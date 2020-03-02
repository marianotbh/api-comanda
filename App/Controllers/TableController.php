<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use App\Core\Validation\Validator;
use App\Services\TableService;

class TableController
{
    private $tableService;

    function __construct()
    {
        $this->tableService = new TableService();
    }

    function list(Request $req, Response $res, $args)
    {
        $tables = $this->tableService->list();

        return $res->withJson($tables, StatusCode::HTTP_OK);
    }

    function create(Request $req, Response $res, $args)
    {
        $model = Validator::check([
            "code" => ["required", "length" => 5],
            "capacity" => "required",
        ], $req->getParsedBody());

        $this->tableService->create($model);

        return $res->withJson(StatusCode::HTTP_CREATED, "Table created");
    }

    function read(Request $req, Response $res, $args)
    {
        $code = $args["code"];

        $table = $this->tableService->read($code);

        return $res->withJson($table, StatusCode::HTTP_OK);
    }

    function update(Request $req, Response $res, $args)
    {
        $code = $args["code"];

        $model = Validator::check([
            "capacity" => "required",
            "state" => "required"
        ],  $req->getParsedBody());

        $this->tableService->update($code, $model);

        return $res->withStatus(StatusCode::HTTP_NO_CONTENT, "Table edited");
    }

    function delete(Request $req, Response $res, $args)
    {
        $code = $args["code"];

        $this->tableService->delete($code);

        return $res->withStatus(StatusCode::HTTP_NO_CONTENT, "Table deleted");
    }

    function getStates(Request $req, Response $res, $args)
    {
        $states = $this->tableService->states();

        return $res->withJson($states, StatusCode::HTTP_OK);
    }
}
