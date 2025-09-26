<?php

namespace App\Core\Routing;

use App\Core\Request;
use App\Middleware\GlobalMiddleware;
use Exception;

class Router
{
    private array $routes;
    private Request $request;
    private ?array $currentRoute;
    const BASE_CONTROLLER = '\App\Controllers\\';

    public function __construct(Request $request, GlobalMiddleware $middleware)
    {
        $this->routes = Route::getRoutes();
        $this->request = $request;
        $this->currentRoute = $this->findRoute($this->request);

        $this->runGlobalMiddleware($middleware);

        if ($this->currentRoute) {
            $this->runRouteMiddleware();
        }
    }

    private function runGlobalMiddleware(GlobalMiddleware $middleware)
    {
        $middleware->handle();
    }

    private function runRouteMiddleware()
    {
        foreach ($this->currentRoute['middleware'] as $middlewareClass) {
            (new $middlewareClass())->handle();
        }
    }

    private function findRoute(Request $request)
    {
        foreach ($this->routes as $route) {
            if ($this->doesRegexMatch($route)) {
                if (in_array($request->getMethod(), $route['method'])) {
                    return $route;
                }

                $this->dispatch405($route['method']);
                exit;
            }
        }

        return null;
    }

    private function doesRegexMatch(array $route)
    {
        $pattern = "/^" . str_replace(['/', '{', '}'], ['\/', '(?<', '>[-%\w]+)'], $route['uri']) . "$/";
        $result = preg_match($pattern, $this->request->getUri(), $matches);

        if (!$result) {
            return false;
        }

        foreach ($matches as $key => $value) {
            if (!is_numeric($key)) {
                $this->request->addRouteParam($key, $value);
            }
        }

        return true;
    }

    public function run()
    {
        if (is_null($this->currentRoute)) {
            $this->dispatch404();
        } else {
            $this->dispatch($this->currentRoute);
        }
    }

    private function dispatch(array $route)
    {
        $action = $route['action'];

        if (empty($action)) return;

        if (is_callable($action)) {
            call_user_func($action);
            return;
        }

        if (is_string($action)) {
            $action = explode('@', $action);
        }

        $className = self::BASE_CONTROLLER . $action[0];
        $method = $action[1] ?? null;

        if (!class_exists($className)) {
            throw new Exception("Class {$className} not found");
        }
        if (!$method || !method_exists($className, $method)) {
            throw new Exception("Method {$method} not found in class {$className}");
        }

        (new $className())->{$method}();
    }

    private function dispatch404()
    {
        header("HTTP/1.0 404 Not Found");
        view("errors.404");
    }

    private function dispatch405(array $allowedMethods)
    {
        header("HTTP/1.0 405 Method Not Allowed");
        header("Allow: " . implode(", ", $allowedMethods));
        view("errors.405", ['methods' => $allowedMethods]);
    }
}
