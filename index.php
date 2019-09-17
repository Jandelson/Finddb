<?php
require 'vendor/autoload.php';

$router = new \ActiveRouter\Router();
$router->newRouter('/', 'finddb\Init');
$router->newRouter('/search', 'finddb\Init');
$router->run();
