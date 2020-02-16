<?php

namespace App\Middleware;

use \Slim\Http\Request;
use \Slim\Http\Response;
use Slim\Http\StatusCode;
use \Exception;
use App\Core\Exceptions\AppException;

class ErrorHandlerMiddleware
{
    public function __invoke(Request $req, Response $res, $next)
    {
        try {
            return $next($req, $res);
        } catch (AppException $e) {
            return $res->withJson([
                "code" => $e->getCode(),
                "message" => $e->getMessage(),
                "stackTrace" => $e->getTraceAsString(),
                "type" => get_class($e),
            ], StatusCode::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return $res->withJson([
                "code" => $e->getCode(),
                "message" => $e->getMessage(),
                "stackTrace" => $e->getTraceAsString(),
                "type" => get_class($e),
            ]);
        }
    }
}
