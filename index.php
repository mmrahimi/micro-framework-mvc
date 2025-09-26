<?php

//The Front Controller
use App\Core\Routing\Router;
use App\Middleware\GlobalMiddleware;

include __DIR__ . '/bootstrap/init.php';

$router = new Router($request, new GlobalMiddleware());
$router->run();
