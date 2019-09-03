<?php
require 'vendor/autoload.php';

$router = new \finddb\Router();
$router->newRouter('/', 'Init');
$router->newRouter('/search', 'Init');
$router->run();
