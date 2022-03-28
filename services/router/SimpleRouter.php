<?php

namespace services\router;

class SimpleRouter implements Router
{
    protected array $rules;

    function __construct()
    {
        $this->rules = [];
    }

    public function addRule($route, $handler)
    {
        $this->rules[$route] = $handler;
    }

    public function route()
    {
        $route = $_GET['route'] ?? 'index';
        $controllerAction = $this->getControllerActionByRoute($route);
        if ($controllerAction) {
            $controller = array_key_first($controllerAction);
            $action = current($controllerAction);
            try {
                (new $controller)->$action();

            } catch (\Exception $ex) {
                echo $ex->getMessage();
                die();
            }

        } else {
            throw new \Exception('Page not found');
        }
    }

    public function getControllerActionByRoute($route)
    {
        return $this->rules[$route] ?? $this->rules['error'] ?? null;
    }
}