<?php

namespace App\Middleware;

use App\Models\Role;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

class RoleMiddleware
{
    /**
     * @var function
     */
    private $evaluator;

    function __construct($evaluator)
    {
        $this->evaluator = $evaluator;
    }

    function __invoke(Request $request, Response $response, $next)
    {
        $evaluator = $this->evaluator;
        $role = $request->getAttribute('payload')->role;

        if ($role == Role::ADMIN || $evaluator($role)) {
            return $next($request, $response);
        } else {
            return $response->withStatus(StatusCode::HTTP_UNAUTHORIZED, "Insufficient permissions");
        }
    }
}
