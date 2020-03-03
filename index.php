<?php

require './vendor/autoload.php';
require_once './App/Core/Utils/Functions.php';

date_default_timezone_set("America/Argentina/Buenos_Aires");

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

/* Controllers */
use App\Controllers\AuthController;
use App\Controllers\LogController;
use App\Controllers\MenuController;
use App\Controllers\OrderController;
use App\Controllers\OrderDetailController;
use App\Controllers\ReviewController;
use App\Controllers\TableController;
use App\Controllers\UserController;

/* Middleware */
use App\Middleware\CorsMiddleware;
use App\Middleware\ErrorHandlerMiddleware;
use App\Middleware\AuthMiddleware;
use App\Middleware\PayloadMiddleware;
use App\Middleware\RoleMiddleware;
use App\Middleware\LogActionMiddleware;

use App\Models\Role;
use App\Models\User;

$appConfig = require './config.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = new App($appConfig);

$app->add(new PayloadMiddleware());
$app->add(new ErrorHandlerMiddleware());
$app->add(new CorsMiddleware());

$user = User::find(34);
var_dump($user->stats());

$app->options('/{routes:.+}', function (Request $req, Response $res, $args) {
    return $res;
});

$app->group('/auth', function () use ($app) {
    $app->post('/login[/]', AuthController::class . ":login");
    $app->get('/status[/]', AuthController::class . ":status")
        ->add(new AuthMiddleware());
    $app->get('/roles[/]', AuthController::class . ":getRoles")
        ->add(new AuthMiddleware());
    $app->patch('/password[/]', AuthController::class . ":changePassword")
        ->add(new AuthMiddleware());
});

$app->group('/users', function () use ($app) {
    $app->get('[/]', UserController::class . ":list");
    $app->get('/{name}[/]', UserController::class . ":read");
    $app->post('[/]', UserController::class . ":create")
        ->add(new RoleMiddleware(fn ($role) => $role == Role::MANAGER));
    $app->put('/{id}[/]', UserController::class . ":update")
        ->add(new LogActionMiddleware());
    $app->delete('/{id}[/]', UserController::class . ":delete")
        ->add(new RoleMiddleware(fn ($role) => $role == Role::MANAGER));
    $app->patch('/{id}/state[/]', UserController::class . ":changeState")
        ->add(new RoleMiddleware(fn ($role) => $role == Role::MANAGER));
    $app->get('/{id}/statistics[/]', UserController::class . ":stats")
        ->add(new RoleMiddleware(fn ($role) => $role == Role::MANAGER));
})->add(new AuthMiddleware());

$app->group('/orders', function () use ($app) {
    $app->get('/states[/]', OrderController::class . ":getStates");
    $app->get('[/]', OrderController::class . ":list");
    $app->get('/{code}[/]', OrderController::class . ":read");
    $app->post('[/]', OrderController::class . ":create")
        ->add(new LogActionMiddleware())
        ->add(new RoleMiddleware(fn ($role) => in_array($role, [Role::MANAGER, Role::FLOOR])));
    $app->put('/{code}[/]', OrderController::class . ":update")
        ->add(new LogActionMiddleware())
        ->add(new RoleMiddleware(fn ($role) => in_array($role, [Role::MANAGER, Role::FLOOR])));
    $app->delete('/{code}[/]', OrderController::class . ":delete")
        ->add(new LogActionMiddleware())
        ->add(new RoleMiddleware(fn ($role) => in_array($role, [Role::MANAGER, Role::FLOOR])));
    $app->patch('/{code}[/]', OrderController::class . ":serve")
        ->add(new LogActionMiddleware())
        ->add(new RoleMiddleware(fn ($role) => in_array($role, [Role::MANAGER, Role::FLOOR])));
    $app->patch('/{code}/state[/]', OrderController::class . ":changeState")
        ->add(new LogActionMiddleware())
        ->add(new RoleMiddleware(fn ($role) => in_array($role, [Role::MANAGER, Role::FLOOR])));

    $app->group('/{order}/details', function () use ($app) {
        $app->get('/states[/]', OrderController::class . ":getStates");
        $app->get('[/]', OrderDetailController::class . ":list");
        $app->get('/{id}[/]', OrderDetailController::class . ":read");
        $app->post('[/]', OrderDetailController::class . ":create")
            ->add(new LogActionMiddleware())
            ->add(new RoleMiddleware(fn ($role) => in_array($role, [Role::MANAGER, Role::FLOOR])));
        $app->put('/{id}[/]', OrderDetailController::class . ":update")
            ->add(new LogActionMiddleware())
            ->add(new RoleMiddleware(fn ($role) => in_array($role, [Role::MANAGER, Role::FLOOR])));
        $app->delete('/{id}[/]', OrderDetailController::class . ":delete")
            ->add(new LogActionMiddleware())
            ->add(new RoleMiddleware(fn ($role) => in_array($role, [Role::MANAGER, Role::FLOOR])));
        $app->patch('/{id}/take[/]', OrderDetailController::class . ":take");
        $app->patch('/{id}/complete[/]', OrderDetailController::class . ":complete");
    });
})->add(new AuthMiddleware());

$app->group('/tables', function () use ($app) {
    $app->get('/states[/]', TableController::class . ":getStates");
    $app->get('[/]', TableController::class . ":list");
    $app->get('/{code}[/]', TableController::class . ":read");
    $app->post('[/]', TableController::class . ":create")
        ->add(new RoleMiddleware(fn ($role) => $role == Role::MANAGER));
    $app->put('/{code}[/]', TableController::class . ":update")
        ->add(new RoleMiddleware(fn ($role) => $role == Role::MANAGER));
    $app->delete('/{code}[/]', TableController::class . ":delete")
        ->add(new RoleMiddleware(fn ($role) => $role == Role::MANAGER));
    $app->patch('/{code}/state[/]', TableController::class . ":changeState")
        ->add(new RoleMiddleware(fn ($role) => $role == Role::MANAGER));
    $app->patch('/{code}[/]', TableController::class . ":close")
        ->add(new RoleMiddleware(fn ($role) => $role == Role::MANAGER));
})->add(new AuthMiddleware());

$app->group('/menu', function () use ($app) {
    $app->get('[/]', MenuController::class . ":list");
    $app->get('/{id}[/]', MenuController::class . ":read");
    $app->post('[/]', MenuController::class . ":create")
        ->add(new LogActionMiddleware())
        ->add(new RoleMiddleware(fn ($role) => in_array($role, [Role::MANAGER, Role::KITCHEN])));
    $app->put('/{id}[/]', MenuController::class . ":update")
        ->add(new LogActionMiddleware())
        ->add(new RoleMiddleware(fn ($role) => in_array($role, [Role::MANAGER, Role::KITCHEN])));
    $app->delete('/{id}[/]', MenuController::class . ":delete")
        ->add(new LogActionMiddleware())
        ->add(new RoleMiddleware(fn ($role) => in_array($role, [Role::MANAGER, Role::KITCHEN])));
    $app->patch('/{id}/state[/]', MenuController::class . ":changeState")
        ->add(new LogActionMiddleware())
        ->add(new RoleMiddleware(fn ($role) => in_array($role, [Role::MANAGER, Role::KITCHEN])));
})->add(new AuthMiddleware());

$app->group('/reviews', function () use ($app) {
    $app->get('[/]', ReviewController::class . ":list");
    $app->get('/averages[/]', ReviewController::class . ":getAverages");
    $app->get('/{id}[/]', ReviewController::class . ":read");
    $app->post('/{order}[/]', ReviewController::class . ":create");
    $app->put('/{id}[/]', ReviewController::class . ":update");
    $app->delete('/{id}[/]', ReviewController::class . ":delete");
});

$app->group('/logs', function () use ($app) {
    $app->get('[/]', LogController::class . ":list");
});

$app->get('/export', ExportController::class);

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function (Request $req, Response $res) {
    $handler = $this->notFoundHandler;
    return $handler($req, $res);
});

$app->run();
