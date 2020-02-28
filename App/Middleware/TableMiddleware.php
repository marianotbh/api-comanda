<?php

namespace App\Middleware;

use \Slim\Http\Request;
use \Slim\Http\Response;
use \App\Data\TableData;
use \Exception;

class TableMiddleware
{
    private $dataSource;

    function __construct()
    {
        $this->dataSource = new TableData();
    }

    public function cerrada(Request $request, Response $response, $next)
    {
        $response = $next($request, $response);
        try {
            $mesa = $request->getParsedBodyParam("mesa");
            $this->dataSource->cambiarEstado($mesa, 0);
            return $response;
        } catch (Exception $e) {
            //return $response->withJson($this->handleException($e), 400);
        }
    }

    public function esperando(Request $request, Response $response, $next)
    {
        $response = $next($request, $response);
        try {
            $mesa = $request->getParsedBodyParam("mesa");
            $this->dataSource->cambiarEstado($mesa, 1);
            return $response;
        } catch (Exception $e) {
            //return $response->withJson($this->handleException($e), 400);
        }
    }

    public function comiendo(Request $request, Response $response, $next)
    {
        $response = $next($request, $response);
        try {
            $mesa = $request->getParsedBodyParam("mesa");
            $this->dataSource->cambiarEstado($mesa, 2);
            return $response;
        } catch (Exception $e) {
            //return $response->withJson($this->handleException($e), 400);
        }
    }

    public function pagando(Request $request, Response $response, $next)
    {
        $response = $next($request, $response);
        try {
            $mesa = $request->getParsedBodyParam("mesa");
            $this->dataSource->cambiarEstado($mesa, 3);
            return $response;
        } catch (Exception $e) {
            //return $response->withJson($this->handleException($e), 400);
        }
    }
}
