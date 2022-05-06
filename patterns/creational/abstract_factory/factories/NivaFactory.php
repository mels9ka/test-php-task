<?php

namespace patterns\creational\abstract_factory\factories;

use patterns\creational\abstract_factory\cars\Car;
use patterns\creational\abstract_factory\cars\NivaCar;
use patterns\creational\abstract_factory\motobikes\MotoBike;
use patterns\creational\abstract_factory\motobikes\NivaMotoBike;

class NivaFactory implements AutoMotoBrandFactory
{

    public function makeCar(): Car
    {
        return new NivaCar();
    }

    public function makeMotoBike(): MotoBike
    {
        return new NivaMotoBike();
    }
}