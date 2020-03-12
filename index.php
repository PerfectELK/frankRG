<?
require 'app/autoload.php';


$router = new \App\Router();
$router->run(\App\Router::parseUrl());
