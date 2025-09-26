<?php

namespace App\Core;

class Request
{
    private array $routeParams = [];
    private array $params;
    private $agent;
    private $method;
    private $ip;
    private $uri;

    public function __construct()
    {
        foreach ($_REQUEST as $key => $value) {
            $_REQUEST[$key] = filter_var(htmlspecialchars($value), FILTER_SANITIZE_STRING);
        }

        $this->params = $_REQUEST;
        $this->agent = $_SERVER['HTTP_USER_AGENT'];
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->uri = '/' . trim(str_replace(dirname($_SERVER['SCRIPT_NAME']), '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)), '/');
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getAgent()
    {
        return $this->agent;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function input($key)
    {
        return $this->params[$key] ?? null;
    }

    public function issetInput($key)
    {
        return isset($this->params[$key]);
    }

    public function redirect($url)
    {
        header('Location: ' . site_url($url));
        die();
    }

    public function addRouteParam(int|string $key, string $value): void
    {
        $this->routeParams[$key] = $value;
    }

    public function getRouteParams(): array
    {
        return $this->routeParams;
    }

    public function getRouteParam(string $key)
    {
        return $this->routeParams[$key] ?? null;
    }
}
