<?php

namespace controllers;

use PDO;
use services\db\DBConnection;
use services\ServiceManager;

class UserController extends BaseController
{
    protected const KEY_USER_RESTORE_SESSION = 'session_restore_user';
    protected const KEY_RESTORE_QUERY_PARAM = 'restore';
    protected const USER_RESTORE_SCENARIO = 'user_restore';
    protected const GUEST_RESTORE_SCENARIO = 'guest_restore';

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

    public function actionLogout()
    {
        if (!$this->userIsGuest()) {
            unset($_SESSION[self::KEY_USER_SESSION]);
        }

        $this->redirect('/?route=index');
    }

    public function actionRestore()
    {
        if (!$this->userIsGuest()) {
            $this->redirect('/?route=index');
        }

        $restoreLink = null;
        if ($this->isPostRequest()) {
            $login = $_POST['login'] ?? '';
            if ($this->validateBeforeRestore($login)) {
                if ($this->checkUserExists($login)) {
                    $hash = md5($login);
                    $_SESSION[self::KEY_USER_RESTORE_SESSION] = $login;
                    $restoreLink = sprintf('/?route=change-password&%s=%s',
                        self::KEY_RESTORE_QUERY_PARAM,
                        $hash
                    );

                } else {
                    $this->errors['general'] = 'Restore error (user not exists)';
                }
            }
        }

        $this->render('restore', [
            'restoreLink' => $restoreLink,
            'errors' => $this->errors
        ]);
    }

    public function actionChangePassword()
    {
        $scenario = self::USER_RESTORE_SCENARIO;
        if ($this->userIsGuest()) {
            $login = $_SESSION[self::KEY_USER_RESTORE_SESSION] ?? null;
            $clientRestoreHash = $_GET[self::KEY_RESTORE_QUERY_PARAM] ?? null;
            if (!$login || !$clientRestoreHash || md5($login) != $clientRestoreHash) {
                $this->redirect('/?route=error');
            }

            $scenario = self::GUEST_RESTORE_SCENARIO;
        } else {
            $login = $_SESSION[self::KEY_USER_SESSION];
        }

        if ($this->isPostRequest()) {
            $oldPassword = $_POST['password_old'] ?? '';
            if ($scenario === self::GUEST_RESTORE_SCENARIO) {
                $oldPassword = false;
            }

            $newPassword = $_POST['password_new'] ?? '';
            $newPasswordRepeat = $_POST['password_new_repeat'] ?? '';
            if ($this->validateBeforeChangePassword($oldPassword, $newPassword, $newPasswordRepeat)) {
                $passwordChanged = $this->changeUserPassword($login, $oldPassword, $newPassword);
                if ($passwordChanged) {
                    $this->setNotification('Password changed successfully!');
                    $this->redirect('/?route=profile');

                } else {
                    $this->errors['general'] = 'Password not changed';
                }
            }
        }

        $this->render('change_password', [
            'title' => sprintf('Change password for user %s', $login),
            'scenario' => $scenario,
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
            $this->checkUserExists($login)) {
            $this->errors['general'] = sprintf('User with login <b> %s </b> already exists', $login);
        }

        return count($this->errors) === 0;
    }

    private function checkUserExists($login): bool
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

    private function validateBeforeChangePassword($oldPassword, $newPassword, $newPasswordRepeat): bool
    {
        $this->errors = [];
        if ($oldPassword !== false && strlen($oldPassword) === 0) {
            $this->errors['password_old'] = '<b>Old password</b> field cannot be empty';
        }

        if (strlen($newPassword) === 0) {
            $this->errors['password_new'] = '<b>New password</b> field cannot be empty';
        }

        if (strlen($newPasswordRepeat) === 0) {
            $this->errors['password_new_repeat'] = '<b>Repeat new password</b> field cannot be empty';
        }

        if (strlen($newPassword) > 0 &&
            strlen($newPasswordRepeat) > 0 &&
            $newPassword !== $newPasswordRepeat
        ) {
            $this->errors['password_new_repeat'] = 'Fields <b>New password</b> and <b>Repeat new password</b> must be equal';
        }

        return count($this->errors) === 0;
    }

    private function changeUserPassword($login, $oldPassword, $newPassword): bool
    {
        if ($oldPassword === false) {
            $sql = "select * from users where login=:login";
            $data = ['login' => $login];

        } else {
            $sql = "select * from users where login=:login and password=:password";
            $data = [
                'login' => $login,
                'password' => md5($oldPassword),
            ];
        }

        $query = $this->dbConnection->prepare($sql);
        $query->execute($data);
        if ($query->rowCount() === 1) {
            $query = $this->dbConnection->prepare("update users set password=:password, updated_at=:updated_at where login=:login");
            $data = [
                'password' => md5($newPassword),
                'updated_at' => time(),
                'login' => $login
            ];
            return $query->execute($data);
        }

        return false;
    }

    private function validateBeforeRestore($login): bool
    {
        $this->errors = [];
        if (strlen($login) === 0) {
            $this->errors['login'] = 'Login field cannot be empty';
        }

        return count($this->errors) === 0;
    }
}