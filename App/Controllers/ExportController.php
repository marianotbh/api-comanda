<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use App\Services\ExportService;

class ExportController
{
    private $exportService;

    public function __construct()
    {
        $this->exportService = new ExportService();
    }

    function list(Request $req, Response $res, $args)
    {
        $page = $req->getQueryParam("page", 1);
        $length = $req->getQueryParam("length", 100);
        $field = $req->getQueryParam("field", "id");
        $order = $req->getQueryParam("order", "ASC");

        $filters = [];
        if ($req->getQueryParam("resource") !== null) $filters["resource"] = array("~", $req->getQueryParam("resource"));
        if ($req->getQueryParam("from") !== null) $filters["createdAt"] = array(">=", $req->getQueryParam("from"));
        if ($req->getQueryParam("to") !== null) $filters["createdAt"] = array("<=", $req->getQueryParam("to"));
        if ($req->getQueryParam("user") !== null) $filters["user"] = array("=", $req->getQueryParam("user"));
        if ($req->getQueryParam("role") !== null) $filters["role"] = array("=", $req->getQueryParam("role"));

        $result = $this->exportService->export($filters, $page, $length, $field, $order);

        return $res->withHeader("Content-Type", "");
    }
}