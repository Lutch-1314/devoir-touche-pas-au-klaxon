<?php

require_once __DIR__ . '/../config/paths.php';
require_once ROOT_PATH . '/vendor/autoload.php';

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\AdminController;
use App\Controllers\AgencyController;
use App\Controllers\TripController;

$router = new Router();

$router->get('/', [HomeController::class, 'index']);

$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'authenticate']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/agencies/create', [AgencyController::class, 'create']);
$router->post('/agencies/create', [AgencyController::class, 'store']);
$router->get('/agencies/edit', [AgencyController::class, 'edit']);
$router->post('/agencies/edit', [AgencyController::class, 'update']);
$router->post('/agencies/delete', [AgencyController::class, 'delete']);

$router->get('/trips/my-trips', [TripController::class, 'myTrips']);
$router->get('/trips/create', [TripController::class, 'create']);
$router->post('/trips/create', [TripController::class, 'store']);
$router->post('/trips/delete', [TripController::class, 'delete']);

$router->get('/admin', [AdminController::class, 'index']);
$router->get('/admin/users', [AdminController::class, 'users']);
$router->get('/admin/agencies', [AdminController::class, 'agencies']);
$router->get('/admin/trips', [AdminController::class, 'trips']);

$router->run();
