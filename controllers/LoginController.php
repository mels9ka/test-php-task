<?php

namespace controllers;

use services\db\DBConnection;
use services\ServiceManager;

class LoginController extends BaseController
{
    private array $errors = [];

    public function actionLogin()
    {
        if ($this->isPostRequest()) {
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($this->validateLogin($login, $password)) {
                // 1. login user
                // 2. redirect to profile page;
            }
        }

        $this->render('login', [
            'title' => 'Login page',
            'errors' => $this->errors,
        ]);
    }

    private function validateLogin($login, $password): bool
    {
        $this->errors = [];
        if (strlen($login) === 0) {
            $this->errors['login'] = 'Login field cannot be empty';
        }

        if (strlen($password) === 0) {
            $this->errors['password'] = 'Password field cannot be empty';
        }

        if (count($this->errors) === 0) {
            $dbConnection = ServiceManager::getInstance()->get(DBConnection::class);
            var_dump($dbConnection->get());
            return true;

        } else {
            return false;
        }
    }
}