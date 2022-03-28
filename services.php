<?php

use services\ServiceManager;
use services\db\DBConnection;
use services\db\MYSQLConnection;
use services\router\Router;
use services\router\SimpleRouter;
use controllers\LoginController;
use controllers\RegistrationController;
use controllers\RestoreController;
use controllers\SiteController;

$serviceManager = ServiceManager::getInstance();
$serviceManager->add(DBConnection::class, function () {
    $dbConnectParams = [
        MYSQLConnection::KEY_HOST => 'db',
        MYSQLConnection::KEY_USER => 'mels9ka',
        MYSQLConnection::KEY_PASSWORD => 'password',
        MYSQLConnection::KEY_DATABASE => 'mels9ka_bd',
    ];
    return new MYSQLConnection($dbConnectParams);
});
$serviceManager->add(Router::class, function () {
    $router = new SimpleRouter();
    $router->addRule('login', [LoginController::class => 'actionLogin']);
    $router->addRule('registration', [RegistrationController::class => 'actionRegistration']);
    $router->addRule('restore', [RestoreController::class => 'actionRestore']);
    $router->addRule('index', [SiteController::class => 'actionIndex']);
    $router->addRule('error', [SiteController::class => 'actionError']);
    return $router;
});

return $serviceManager;