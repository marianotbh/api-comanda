<?php

namespace App\Middleware;

use \Slim\Http\Request;
use \Slim\Http\Response;

class CorsMiddleware
{
    public function __invoke(Request $req, Response $res, $next)
    {
        $res = $next($req, $res);
        return $res->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Content-type', 'application/json; charset=utf-8')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
    }
}
