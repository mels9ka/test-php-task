<?php

namespace services;

class ServiceManager implements Container
{
    protected $services;
    private static $instance = null;

    function __construct()
    {
        $this->services = [];
    }

    public static function getInstance(): ServiceManager
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->services);
    }

    public function get(string $key)
    {
        return call_user_func($this->services[$key] ?? '');
    }

    public function add(string $key, callable $service)
    {
        $this->services[$key] = $service;
    }
}