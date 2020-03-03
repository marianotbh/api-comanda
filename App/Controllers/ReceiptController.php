<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use App\Core\Validation\Validator;
use App\Services\ReceiptService;

class ReceiptController
{
    private $receiptService;

    function __construct()
    {
        $this->receiptService = new ReceiptService();
    }

    function list(Request $req, Response $res, $args)
    {
        $receipt = $this->receiptService->list();

        return $res->withJson($receipt, StatusCode::HTTP_OK);
    }

    function create(Request $req, Response $res, $args)
    {
        $model = Validator::check([
            "user" => ["required"],
            "table" => ["required"],
            "order" => "required"
        ], $req->getParsedBody());

        $id = $this->receiptService->create($model);

        return $res->withJson(["id" => $id], StatusCode::HTTP_CREATED);
    }
}
