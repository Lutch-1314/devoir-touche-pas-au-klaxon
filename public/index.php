<?php

require_once __DIR__ . '/../config/paths.php';
require_once ROOT_PATH . '/vendor/autoload.php';

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;

$router = new Router();

$router->get('/', [HomeController::class, 'index']);

$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'authenticate']);

$router->get('/logout', [AuthController::class, 'logout']);

$router->run();
