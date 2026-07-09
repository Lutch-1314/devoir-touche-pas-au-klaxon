<?php

require_once __DIR__ . '/../config/paths.php';
require_once ROOT_PATH . '/vendor/autoload.php';

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\TripController;

$router = new Router();

$router->get('/', [HomeController::class, 'index']);

$router->get('/trips/create', [TripController::class, 'create']);
$router->post('/trips/create', [TripController::class, 'store']);

$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'authenticate']);

$router->get('/logout', [AuthController::class, 'logout']);

$router->run();
