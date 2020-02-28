<?php

namespace App\Middleware;

use \Slim\Http\Request;
use \Slim\Http\Response;
use \App\Models\Roles;

class RoleMiddleware
{
    private $allowedRole;

    function __construct($allowedRole)
    {
        $this->allowedRole = $allowedRole;
    }

    function __invoke(Request $request, Response $response, $next)
    {
        // $payload = $request->getAttribute('payload');
        // $role = $payload->role;
        // switch ($this->allowedRole) {
        //     case Roles::ADMIN:
        //         if ($role == Roles::ADMIN)
        //             return $next($request, $response);
        //     case Roles::MANAGER:
        //         if ($role == Roles::ADMIN || $role == Roles::MANAGER)
        //             return $next($request, $response);
        //     case Roles::WAITER:
        //         if (Roles::WAITER || $role == Roles::ADMIN || $role == Roles::MANAGER)
        //             return $next($request, $response);
        //     case Roles::BARTENDER:
        //         if (Roles::BARTENDER || $role == Roles::ADMIN || $role == Roles::MANAGER)
        //             return $next($request, $response);
        //     case Roles::COOK:
        //         if (Roles::COOK || $role == Roles::ADMIN || $role == Roles::MANAGER)
        //             return $next($request, $response);
        //     case Roles::BREWER:
        //         if (Roles::BREWER || $role == Roles::ADMIN || $role == Roles::MANAGER)
        //             return $next($request, $response);
        //     default:
        //         return $response->withStatus(403, "Not authorized");
        // }
    }
}
