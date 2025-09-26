<?php

const BASE_PATH = __DIR__ . '/../';

include BASE_PATH . '/vendor/autoload.php';
include BASE_PATH . '/helpers/helpers.php';

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

$request = new App\Core\Request();

include BASE_PATH . '/routes/web.php';
