<?php

namespace App\Core;

use App\Utilities\Url;

class SimpleRouter
{
    private array $routes;

    public function __construct()
    {
        $this->routes = [
            '/' => 'home/home.php',
            '/color/red' => 'colors/red.php',
            '/color/green' => 'colors/green.php',
            '/color/blue' => 'colors/blue.php',
        ];
    }

    public function run(): void
    {
        $current_route = Url::current_route();
        foreach ($this->routes as $route => $view) {
            if ($current_route == $route) {
                $this->includeAndDie($view);
            }
        }
        header('http/1.1 404 Not Found');
        $this->includeAndDie('errors/404.php');
    }

    private function includeAndDie($viewPath): void
    {
        include 'views/' . $viewPath;
        die();
    }
}
