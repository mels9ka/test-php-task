<?php

use services\ServiceManager;
use services\db\DBConnection;
use services\db\MYSQLConnection;
use services\router\Router;
use services\router\SimpleRouter;
use controllers\UserController;
use controllers\SiteController;
use controllers\ProfileController;

$serviceManager = ServiceManager::getInstance();
$serviceManager->add(DBConnection::class, function () {
    $dbConnectParams = [
        MYSQLConnection::KEY_HOST => 'db',
        MYSQLConnection::KEY_USER => 'mels9ka',
        MYSQLConnection::KEY_PASSWORD => 'password',
        MYSQLConnection::KEY_DATABASE => 'mels9ka_bd',
    ];
    return (new MYSQLConnection($dbConnectParams))->get();
});
$serviceManager->add(Router::class, function () {
    $router = new SimpleRouter();
    $router->addRule('index', [SiteController::class => 'actionIndex']);
    $router->addRule('error', [SiteController::class => 'actionError']);
    $router->addRule('login', [UserController::class => 'actionLogin']);
    $router->addRule('registration', [UserController::class => 'actionRegistration']);
    $router->addRule('restore', [UserController::class => 'actionRestore']);
    $router->addRule('change-password', [UserController::class => 'actionChangePassword']);
    $router->addRule('logout', [UserController::class => 'actionLogout']);
    $router->addRule('profile', [ProfileController::class => 'actionProfile']);
    return $router;
});

return $serviceManager;