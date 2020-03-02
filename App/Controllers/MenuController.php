<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use App\Core\Validation\Validator;
use App\Services\MenuService;

class MenuController
{
    private $menuService;

    function __construct()
    {
        $this->menuService = new MenuService();
    }

    function list(Request $req, Response $res, $args)
    {
        $menu = $this->menuService->list();

        return $res->withJson($menu, StatusCode::HTTP_OK);
    }

    function create(Request $req, Response $res, $args)
    {
        $model = Validator::check([
            "name" => ["required", "min" => 3],
            "description" => ["required", "min" => 5],
            "price" => "required",
            "stock" => ["required", "min" => 1, "max" => 100],
            "role" => "required"
        ], $req->getParsedBody());

        $id = $this->menuService->create($model);

        return $res->withJson(["id" => $id], StatusCode::HTTP_CREATED);
    }

    function read(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $menu = $this->menuService->read($id);

        return $res->withJson($menu, StatusCode::HTTP_OK);
    }

    function update(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $model = Validator::check([
            "name" => ["required", "min" => 3],
            "description" => ["required", "min" => 5],
            "price" => "required",
            "stock" => ["required", "min" => 1, "max" => 100],
            "role" => "required"
        ],  $req->getParsedBody());

        $this->menuService->update($id, $model);

        return $res->withStatus(StatusCode::HTTP_NO_CONTENT, "Menu item edited");
    }

    function delete(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $this->menuService->delete($id);

        return $res->withStatus(StatusCode::HTTP_NO_CONTENT, "Menu item deleted");
    }
}
