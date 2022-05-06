<?php

namespace patterns\creational\abstract_factory\motobikes;

class NivaMotoBike implements MotoBike
{
    public function getName(): string
    {
        return 'Мотоцикл НИВЫЫЫА!!!';
    }

    public function getMotor(): string
    {
        return 'Мотор в виде белки в колесе';
    }
}