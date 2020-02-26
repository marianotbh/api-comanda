<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

use App\Core\Validator;
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
            "name" => ["required", "minLength:3"],
            "description" => ["required", "minLength:5"],
            "price" => "required",
            "stock" => "required",
            "category" => "required"
        ], $req->getParsedBody());

        $this->menuService->create($model);

        return $res->withJson(["message" => "Menu created"], StatusCode::HTTP_OK);
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
            "name" => ["required", "minLength:3"],
            "description" => ["required", "minLength:5"],
            "price" => "required",
            "stock" => "required",
            "category" => "required"
        ],  $req->getParsedBody());

        $this->menuService->update($id, $model);

        return $res->withJson(["message" => "Menu edited"], StatusCode::HTTP_OK);
    }

    function delete(Request $req, Response $res, $args)
    {
        $id = (int) $args["id"];

        $this->menuService->delete($id);

        return $res->withJson(["message" => "Menu deleted"], StatusCode::HTTP_OK);
    }
}
