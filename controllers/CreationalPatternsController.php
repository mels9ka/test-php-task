<?php

namespace controllers;

use patterns\creational\abstract_factory\factories\AudiFactory;
use patterns\creational\abstract_factory\factories\AutoMotoBrandFactory;
use patterns\creational\abstract_factory\factories\NivaFactory;
use services\ServiceManager;

class CreationalPatternsController extends BaseController
{
    /** @var ServiceManager */
    private $serviceManager;

    public function __construct()
    {
        $this->serviceManager = ServiceManager::getInstance();
    }

    public function actionAbstractFactory()
    {
        $this->serviceManager->add(AutoMotoBrandFactory::class, function () {
            return new AudiFactory();
            //  --- OR ---
            //return new NivaFactory();
        });

        $this->render('abstract_factory', [
            'factory' => $this->serviceManager->get(AutoMotoBrandFactory::class)
        ]);
    }
}