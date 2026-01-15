<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;

// $controller = new HomeController();
// $controller->index();

$Router = new Router();

$Router->add('/brief-11/public/' , 'HomeController' , 'index');
$Router->add('/brief-11/' , 'HomeController' , 'index');
$Router->add('index.php' , 'HomeController' , 'index');

$url = parse_url($_SERVER['REQUEST_URI'] , PHP_URL_PATH);

$Router->dispatch($url);

?>