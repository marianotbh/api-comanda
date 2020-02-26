<?php

require './vendor/autoload.php';
require_once './App/Core/Utils/Functions.php';

date_default_timezone_set("America/Argentina/Buenos_Aires");

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

/* Controllers */
use App\Controllers\AuthController;
use App\Controllers\MenuController;
use App\Controllers\OrderController;
use App\Controllers\ReviewController;
use App\Controllers\TableController;
use App\Controllers\UserController;

/* Middleware */
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

$app->group('/auth', function (App $app) {
    $app->post('/login[/]', AuthController::class . ":login");
    $app->get('/status[/]', AuthController::class . ":status");
    $app->get('/roles[/]', AuthController::class . ":getRoles");
    $app->post('/password[/]', AuthController::class . ":changePassword");
});

$app->group('/users', function (App $app) {
    $app->get('[/]', UserController::class . ":list");
    $app->get('/{id}[/]', UserController::class . ":read");
    $app->post('[/]', UserController::class . ":create");
    $app->put('/{id}[/]', UserController::class . ":update");
    $app->delete('/{id}[/]', UserController::class . ":delete");
}); //->add(new AuthMiddleware());

$app->group('/orders', function (App $app) {
    $app->get('/states[/]', OrderController::class . ":getStates");
    $app->get('[/]', OrderController::class . ":list");
    $app->get('/{id}[/]', OrderController::class . ":read");
    $app->post('[/]', OrderController::class . ":create");
    $app->put('/{id}[/]', OrderController::class . ":update");
    $app->delete('/{id}[/]', OrderController::class . ":delete");
});

$app->group('/tables', function (App $app) {
    $app->get('/states[/]', TableController::class . ":getStates");
    $app->get('[/]', TableController::class . ":list");
    $app->get('/{id}[/]', TableController::class . ":read");
    $app->post('[/]', TableController::class . ":create");
    $app->put('/{id}[/]', TableController::class . ":update");
    $app->delete('/{id}[/]', TableController::class . ":delete");
});

$app->group('/menu', function (App $app) {
    $app->get('[/]', MenuController::class . ":list");
    $app->get('/{id}[/]', MenuController::class . ":read");
    $app->post('[/]', MenuController::class . ":create");
    $app->put('/{id}[/]', MenuController::class . ":update");
    $app->delete('/{id}[/]', MenuController::class . ":delete");
});

$app->group('/reviews', function (App $app) {
    $app->get('[/]', ReviewController::class . ":list");
    $app->get('/{id}[/]', ReviewController::class . ":read");
    $app->post('[/]', ReviewController::class . ":create");
    $app->put('/{id}[/]', ReviewController::class . ":update");
    $app->delete('/{id}[/]', ReviewController::class . ":delete");
});

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function (Request $req, Response $res) {
    $handler = $this->notFoundHandler;
    return $handler($req, $res);
});

$app->run();
