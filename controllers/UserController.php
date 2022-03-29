<?php

namespace controllers;

use PDO;
use services\db\DBConnection;
use services\ServiceManager;

class UserController extends BaseController
{
    private array $errors = [];

    public function actionLogin()
    {
        if (!$this->userIsGuest()) {
            $this->redirect('/?route=profile');
        }

        if ($this->isPostRequest()) {
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($this->validateBeforeLogin($login, $password)) {
                if ($this->loginUser($login, $password)) {
                    $this->redirect('/?route=index');

                } else {
                    $this->errors['general'] = 'Wrong login or password';
                }
            }
        }

        $this->render('login', [
            'title' => 'Login page',
            'errors' => $this->errors,
        ]);
    }

    public function actionLogout()
    {
        if (!$this->userIsGuest()) {
           unset($_SESSION[self::KEY_USER_SESSION]);
        }

        $this->redirect('/?route=index');
    }

    public function actionRegistration()
    {
        if (!$this->userIsGuest()) {
            $this->redirect('/?route=index');
        }

        if ($this->isPostRequest()) {
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';
            $passwordRepeat = $_POST['password_repeat'] ?? '';

            if ($this->validateBeforeRegistration($login, $password, $passwordRepeat)) {
                $userRegistered = $this->registerUser($login, $password);
                if ($userRegistered) {
                    $this->redirect('/?route=profile');
                }
            }
        }

        $this->render('registration', [
            'title' => 'Registration',
            'errors' => $this->errors,
        ]);
    }

    private function validateBeforeLogin($login, $password): bool
    {
        $this->errors = [];
        if (strlen($login) === 0) {
            $this->errors['login'] = 'Login field cannot be empty';
        }

        if (strlen($password) === 0) {
            $this->errors['password'] = 'Password field cannot be empty';
        }

        return count($this->errors) === 0;
    }

    private function loginUser($login, $password): bool
    {
        /** @var PDO $dbConnection */
        $dbConnection = ServiceManager::getInstance()->get(DBConnection::class);
        $query = $dbConnection->prepare("select * from users where login=:login and password=:password;");
        $data = [
            'login' => $login,
            'password' => md5($password),
        ];
        $query->execute($data);
        if ($query->rowCount() === 1) {
            $_SESSION[self::KEY_USER_SESSION] = $login;
            return true;
        }

        return false;
    }

    private function validateBeforeRegistration($login, $password, $passwordRepeat)
    {
        $this->errors = [];
        if (strlen($login) === 0) {
            $this->errors['login'] = 'Login field cannot be empty';
        }

        if (strlen($password) === 0) {
            $this->errors['password'] = 'Password field cannot be empty';
        }

        if (strlen($passwordRepeat) === 0) {
            $this->errors['password_repeat'] = 'Repeat password field cannot be empty';
        }

        if (strlen($password) > 0 &&
            strlen($passwordRepeat) > 0 &&
            $password !== $passwordRepeat
        ) {
            $this->errors['password_repeat'] = 'Fields Password and Repeat password must be equal';
        }

        if (count($this->errors) === 0 &&
            $this->checkUserAlreadyExists($login)) {
            $this->errors['general'] = sprintf('User with login <b> %s </b> already exists', $login);
        }

        return count($this->errors) === 0;
    }

    private function checkUserAlreadyExists($login): bool
    {
        /** @var PDO $dbConnection */
        $dbConnection = ServiceManager::getInstance()->get(DBConnection::class);
        $query = $dbConnection->prepare("SELECT login FROM `users` WHERE `login` = :login");
        $query->execute(['login' => $login]);
        return $query->rowCount() > 0;
    }

    private function registerUser($login, $password): bool
    {
        /** @var PDO $dbConnection */
        $dbConnection = ServiceManager::getInstance()->get(DBConnection::class);
        $data = [
            'login' => $login,
            'password' => md5($password),
            'created_at' => time(),
            'updated_at' => time()
        ];
        $query = $dbConnection->prepare("INSERT INTO users (login, password, created_at, updated_at) VALUES (:login, :password, :created_at, :updated_at);");

        if ($query->execute($data)) {
            $_SESSION[self::KEY_USER_SESSION] = $login;
            return true;
        }

        return false;
    }
}