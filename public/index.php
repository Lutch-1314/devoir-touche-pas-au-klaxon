<?php

require_once __DIR__ . '/../config/paths.php';
require_once ROOT_PATH . '/vendor/autoload.php';

use App\Core\Router;
use App\Controllers\HomeController;

$router = new Router();

$router->get('/', [HomeController::class, 'index']);

$router->run();
