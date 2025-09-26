<?php

namespace App\Utilities;

class Asset
{
    public static function __callStatic($name, $arguments): string
    {
        $folders = [
            'css' => 'assets/css/',
            'js' => 'assets/js/',
            'img' => 'assets/img/'
        ];

        $route = $arguments[0];
        $prefix = $folders[$name] ?? '';

        return $_ENV['HOST'] . $prefix . $route;
    }
}
