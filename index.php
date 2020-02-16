<?php

require './vendor/autoload.php';

date_default_timezone_set("America/Argentina/Buenos_Aires");

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

use App\Controllers\AuthController;
use App\Controllers\RoleController;
use App\Controllers\UserController;
use App\Middleware\CorsMiddleware;
use App\Middleware\ErrorHandlerMiddleware;
use App\Middleware\AuthMiddleware;

$appConfig = require './config.php';

$app = new App($appConfig);

$app->add(new ErrorHandlerMiddleware());
$app->add(new CorsMiddleware());

$app->options('/{routes:.+}', function (Request $req, Response $res, $args) {
    return $res;
});

$app->post('/login[/]', AuthController::class . ":login");
$app->post('/register[/]', AuthController::class . ":register");
$app->get('/status[/]', AuthController::class . ":status");

$app->group('/users', function (App $app) {
    $app->get('[/]', UserController::class . ":list");
    $app->get('/{id}[/]', UserController::class . ":read");
    $app->post('[/]', UserController::class . ":create");
    $app->put('/{id}[/]', UserController::class . ":update");
    $app->delete('/{id}[/]', UserController::class . ":delete");
}); //->add(new AuthMiddleware());

$app->group('/roles', function (App $app) {
    $app->get('[/]', RoleController::class . ":list");
    $app->get('/{id}[/]', RoleController::class . ":read");
    $app->post('[/]', RoleController::class . ":create");
    $app->put('/{id}[/]', RoleController::class . ":update");
    $app->delete('/{id}[/]', RoleController::class . ":delete");
});


$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function (Request $req, Response $res) {
    $handler = $this->notFoundHandler;
    return $handler($req, $res);
});

$app->run();
