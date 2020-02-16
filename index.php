<?php

require './vendor/autoload.php';

date_default_timezone_set("America/Argentina/Buenos_Aires");

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

use App\Controllers\AuthController;
use App\Controllers\RolesController;
use App\Controllers\UsersController;
use App\Middleware\CorsMiddleware;
use App\Middleware\ErrorHandlerMiddleware;
use App\Middleware\AuthMiddleware;

$appConfig = require './config.php';

$app = new App($appConfig);

$app->add(new ErrorHandlerMiddleware());
$app->add(new CorsMiddleware());

$app->options('/{routes:.+}', function ($req,  $res, $args) {
    return $res;
});

$app->post('/login[/]', AuthController::class . ":login");
$app->post('/register[/]', AuthController::class . ":register");
$app->get('/status[/]', AuthController::class . ":status");

$app->group('/users', function (App $app) {
    $app->get('[/]', UsersController::class . ":list");
    $app->get('/{id}[/]', UsersController::class . ":read");
    $app->post('[/]', UsersController::class . ":create");
    $app->put('/{id}[/]', UsersController::class . ":update");
    $app->delete('/{id}[/]', UsersController::class . ":delete");
}); //->add(new AuthMiddleware());

$app->group('/roles', function (App $app) {
    $app->get('[/]', RolesController::class . ":list");
    $app->get('/{id}[/]', RolesController::class . ":read");
    $app->post('[/]', RolesController::class . ":create");
    $app->put('/{id}[/]', RolesController::class . ":update");
    $app->delete('/{id}[/]', RolesController::class . ":delete");
});


$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($req, $res) {
    $handler = $this->notFoundHandler;
    return $handler($req, $res);
});

$app->run();
