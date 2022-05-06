<?php

namespace patterns\creational\abstract_factory\factories;

use patterns\creational\abstract_factory\cars\AudiCar;
use patterns\creational\abstract_factory\motobikes\AudiMotoBike;
use patterns\creational\abstract_factory\motobikes\MotoBike;

class AudiFactory implements AutoMotoBrandFactory
{

    public function makeCar(): AudiCar
    {
        return new AudiCar();
    }

    public function makeMotoBike(): MotoBike
    {
        return new AudiMotoBike();
    }
}