<?php

namespace patterns\creational\abstract_factory\factories;

use patterns\creational\abstract_factory\cars\Car;
use patterns\creational\abstract_factory\motobikes\MotoBike;

interface AutoMotoBrandFactory
{
    public function makeCar(): Car;

    public function makeMotoBike(): MotoBike;
}