<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

use App\Core\Validator;
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
        $data = $this->tableService->list();

        return $res->withJson(["tables" => $data], StatusCode::HTTP_OK);
    }

    function create(Request $req, Response $res, $args)
    {
        $model = Validator::check([
            "name" => ["required", "minLength:5"],
            "description" => ["required", "minLength:5"]
        ], $req->getParsedBody());

        $this->tableService->create($model);

        return $res->withJson(["message" => "Table created"], StatusCode::HTTP_OK);
    }

    function read(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $table = $this->tableService->read($id);

        return $res->withJson(["table" => $table ?: null], StatusCode::HTTP_OK);
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

        $this->tableService->update($id, $model);

        return $res->withJson(["message" => "Table edited"], StatusCode::HTTP_OK);
    }

    function delete(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $this->tableService->delete($id);

        return $res->withJson(["message" => "Table deleted"], StatusCode::HTTP_OK);
    }
}
