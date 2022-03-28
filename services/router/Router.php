<?php

namespace services\router;

interface Router
{
    public function addRule($route, $handler);

    public function route();
}