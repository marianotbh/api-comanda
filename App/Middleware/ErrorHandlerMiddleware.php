<?php

namespace App\Middleware;

use \Slim\Http\Request;
use \Slim\Http\Response;
use Slim\Http\StatusCode;
use App\Core\Exceptions\AppException;
use App\Core\Exceptions\ValidatorException;
use \Exception;

class ErrorHandlerMiddleware
{
    public function __invoke(Request $req, Response $res, $next)
    {
        try {
            return $next($req, $res);
        } catch (ValidatorException $e) {
            return $res->withJson([
                "errors" => $e->errors,
                "message" => $e->getMessage(),
            ], StatusCode::HTTP_BAD_REQUEST);
        } catch (AppException $e) {
            return $res->withStatus(StatusCode::HTTP_BAD_REQUEST, $e->getMessage());
        } catch (Exception $e) {
            return $res->withJson([
                "code" => $e->getCode(),
                "message" => $e->getMessage(),
                "stackTrace" => $e->getTraceAsString(),
            ], StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
