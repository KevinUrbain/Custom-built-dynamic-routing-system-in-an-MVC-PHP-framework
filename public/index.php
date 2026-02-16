<?php
require_once dirname(__DIR__) . '/src/Core/Router.php';

$router = new Router();

$router->routeRequest();