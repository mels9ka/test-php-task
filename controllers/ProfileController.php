<?php

namespace controllers;

class ProfileController extends BaseController
{
    public function actionProfile()
    {
        if ($this->userIsGuest()) {
            $this->redirect('/?route=index');
        }

        $login = $_SESSION[self::KEY_USER_SESSION];
        $this->render('index', [
            'login' => $login
        ]);
    }
}