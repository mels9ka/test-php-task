<?php

namespace controllers;

use PDO;
use services\db\DBConnection;
use services\ServiceManager;

abstract class BaseController
{
    protected const KEY_USER_SESSION = 'session_user';
    protected const KEY_USER_NOTIFICATIONS = 'session_notifications';

    protected array $errors = [];

    /** @var PDO */
    protected $dbConnection;

    public function __construct()
    {
        $this->dbConnection = ServiceManager::getInstance()->get(DBConnection::class);
    }

    public function render(string $view, array $_data_ = [])
    {
        $className = strtolower($this::class);
        $className = str_replace('controller', '', $className);
        $parts = explode('\\', $className);
        $controllerViewDir = end($parts);
        $viewFileName = sprintf('%s/../views/%s/%s.php',
            __DIR__,
            $controllerViewDir,
            $view
        );
        if (file_exists($viewFileName)) {
            extract($_data_);
            include $viewFileName;

        } else {
            throw new \Exception('View not found');
        }
    }

    protected function isPostRequest(): bool
    {
        return (string)$_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function userIsGuest(): bool
    {
        return array_key_exists(self::KEY_USER_SESSION, $_SESSION) === false;
    }

    protected function redirect($url, $code = 301)
    {
        $location = sprintf('Location: %s', $url);
        header($location,TRUE,$code);
        exit();
    }

    protected function setNotification(string $notification)
    {
        $notificationsList = $_SESSION[self::KEY_USER_NOTIFICATIONS] ?? [];
        $notificationsList[] = $notification;
        $_SESSION[self::KEY_USER_NOTIFICATIONS] = $notificationsList;
    }

    protected function getNotifications(): string
    {
        $notificationsList = $_SESSION[self::KEY_USER_NOTIFICATIONS] ?? [];
        unset($_SESSION[self::KEY_USER_NOTIFICATIONS]);
        return implode('<br>', $notificationsList);
    }
}