<?php

namespace App\Middleware;

use \Slim\Http\Request;
use \Slim\Http\Response;
use App\Models\Log;

class LogActionMiddleware
{
    public function __invoke(Request $req, Response $res, $next)
    {
        $log = new Log();

        $log->resource = $req->getUri();
        $log->action = $req->getMethod();
        $log->user = $req->getAttribute("payload")->id;
        $log->role = $req->getAttribute("payload")->role;

        $log->create();

        return $next($req, $res);
    }
}
