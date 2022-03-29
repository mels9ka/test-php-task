<?php

namespace controllers;

class ProfileController extends BaseController
{
    public function actionProfile()
    {
        if ($this->userIsGuest()) {
            $this->redirect('/?route=index');
        }

        $this->render('index');
    }
}