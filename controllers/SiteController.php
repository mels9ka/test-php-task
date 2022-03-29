<?php

namespace controllers;

class SiteController extends BaseController
{
    public function actionIndex()
    {
        $this->render('index', [
            'isGuest' => $this->userIsGuest()
        ]);
    }

    public function actionError()
    {
        $code = 404;
        $this->render('error', [
            'code' => $code
        ]);
    }
}