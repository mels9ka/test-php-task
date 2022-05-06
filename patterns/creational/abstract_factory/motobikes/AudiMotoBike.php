<?php

namespace patterns\creational\abstract_factory\motobikes;

class AudiMotoBike implements MotoBike
{
    public function getName(): string
    {
        return 'Мотоцикл AUDI';
    }

    public function getMotor(): string
    {
        return 'Мощный крутой мотор';
    }
}