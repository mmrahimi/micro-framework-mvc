<?php

function site_url($route = ''): string
{
    return $_ENV['HOST'] . $route;
}

function asset_url($route): string
{
    return site_url('assets/' . $route);
}

function view($destination, $data = []): void
{
    extract($data);
    $correctPath = str_replace('.', '/', $destination);
    include_once BASE_PATH . 'views/' . $correctPath . '.php';
    die();
}

function redirect(string $url): void
{
    header("Location: " . $url);
    die();
}

function uploaded($route): string
{
    return site_url('uploads/' . $route);
}

function forbidden()
{
    view("errors.403");
}
