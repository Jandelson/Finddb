<?php

require 'vendor/autoload.php';

try {
    $router = new \ActiveRouter\Router();
    $router->newRouter('/', 'finddb\Init');
    $router->newRouter('/search', 'finddb\Init');
    $router->run();
} catch (\Exception $error) {
    echo $error->getMessage();
}
