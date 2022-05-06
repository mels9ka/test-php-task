<?php

namespace patterns\creational\abstract_factory\cars;

class AudiCar implements Car
{

    public function getName(): string
    {
        return 'AUDI';
    }

    public function getDescription(): string
    {
        return 'Идеальный и прекрасный автомобиль. Дороговат.';
    }
}