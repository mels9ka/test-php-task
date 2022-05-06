<?php

namespace patterns\creational\abstract_factory\cars;

class NivaCar implements Car
{
    public function getName(): string
    {
        return 'НИВЫЫЫА!!!';
    }

    public function getDescription(): string
    {
        return 'Издавна это говно называли говном';
    }
}