<?php

namespace patterns\creational\abstract_factory\motobikes;

interface MotoBike
{
    public function getName(): string;

    public function getMotor(): string;
}