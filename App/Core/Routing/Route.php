<?php

namespace App\Core\Routing;

class Route
{
    private static array $routes = [];

    public static function addRoute($method, $uri, $action = null, $middleware = []): void
    {
        $method = is_array($method) ? $method : [$method];
        self::$routes[] = ['method' => $method, 'uri' => $uri, 'action' => $action, 'middleware' => $middleware];
    }

    public static function get($uri, $action = null, $middleware = []): void
    {
        self::addRoute('get', $uri, $action, $middleware);
    }

    public static function post($uri, $action = null, $middleware = []): void
    {
        self::addRoute('post', $uri, $action, $middleware);
    }

    public static function put($uri, $action = null, $middleware = []): void
    {
        self::addRoute('put', $uri, $action, $middleware);
    }

    public static function patch($uri, $action = null, $middleware = []): void
    {
        self::addRoute('patch', $uri, $action, $middleware);
    }

    public static function delete($uri, $action = null, $middleware = []): void
    {
        self::addRoute('delete', $uri, $action, $middleware);
    }

    public static function options($uri, $action = null, $middleware = []): void
    {
        self::addRoute('options', $uri, $action, $middleware);
    }

    public static function getRoutes(): array
    {
        return self::$routes;
    }
}
