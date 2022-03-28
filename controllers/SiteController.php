<?php

namespace controllers;

class SiteController extends BaseController
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionError()
    {
        $code = 404;
        $this->render('error', [
            'code' => $code
        ]);
    }
}