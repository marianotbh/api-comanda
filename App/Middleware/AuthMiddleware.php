<?php

namespace App\Middleware;

use App\Core\Exceptions\AppException;
use App\Core\Utils\JWTHelper as UtilsJWTHelper;
use \Slim\Http\Request;
use \Slim\Http\Response;
use \Exception;

class AuthMiddleware
{
    public function __invoke(Request $req, Response $res, $next)
    {
        $header = $req->getHeader("Authorization");

        try {
            if (count($header) > 0) {
                $bearer = $header[0];
                $token = trim(ltrim($bearer, "Bearer"));
                $decoded = UtilsJWTHelper::decode($token);
                $req->withAttribute("payload", $decoded->payload ?? null);
                return $next($req, $res);
            } else {
                throw new AppException("Missing Authorization header");
            }
        } catch (AppException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new AppException("Invalid Authorization header value", -1, $e);
        }
    }
}
