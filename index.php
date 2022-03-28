<?php

use services\router\Router;
use services\ServiceManager;

require_once __DIR__ . '/autoload.php';

/** @var ServiceManager $serviceManager */
$serviceManager = require __DIR__ . '/services.php';
$router = $serviceManager->get(Router::class);
if ($router) {
    $router->route();

} else {
    throw new Exception('Router service not found');
}
