<?php

namespace App\Middleware;

use App\Core\Utils\JWTHelper as UtilsJWTHelper;
use \Slim\Http\Request;
use \Slim\Http\Response;

function extractToken($bearerToken)
{
    return trim(ltrim($bearerToken, "Bearer"));
}

class PayloadMiddleware
{
    public function __invoke(Request $req, Response $res, $next)
    {
        $authorization = $req->getHeader("Authorization");

        if (count($authorization) > 0) {
            $token = extractToken($authorization[0]);
            $decoded = UtilsJWTHelper::decode($token);
            $req = $req->withAttribute("payload", $decoded->payload);
        }

        return $next($req, $res);
    }
}
