<?php

namespace controllers;

abstract class BaseController
{
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

}