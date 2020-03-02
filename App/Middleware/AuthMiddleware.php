<?php

namespace App\Middleware;

use \Slim\Http\Request;
use \Slim\Http\Response;
use Slim\Http\StatusCode;

class AuthMiddleware
{
    public function __invoke(Request $req, Response $res, $next)
    {
        $payload = $req->getAttribute("payload");

        if ($payload == null) {
            return $res->withStatus(StatusCode::HTTP_UNAUTHORIZED, "Unauthorized");
        }

        return $next($req, $res);
    }
}
