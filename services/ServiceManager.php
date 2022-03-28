<?php

namespace services;

class ServiceManager implements Container
{
    protected $services;

    function __construct()
    {
        $this->services = [];
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->services);
    }

    public function get(string $key)
    {
        return $this->services[$key] ?? null;
    }

    public function add(string $key, callable $service)
    {
        $this->services[$key] = $service;
    }
}