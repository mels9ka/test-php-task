<?php

namespace patterns\creational\abstract_factory\cars;

interface Car
{
    public function getName(): string;

    public function getDescription(): string;
}