<?php
/** @var AutoMotoBrandFactory $factory */

use patterns\creational\abstract_factory\factories\AutoMotoBrandFactory;

$car = $factory->makeCar();
$motoBike = $factory->makeMotoBike();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Abstract factory</title>
</head>
<body>
<h1>Abstract factor</h1>
<div>
    <p>Car name: <b><?= $car->getName() ?></b></p>
    <p>Car description: <b><?= $car->getDescription() ?></b></p>
</div>
<div>
    <p>Bike name: <b><?= $motoBike->getName() ?></b></p>
    <p>Bike motor: <b><?= $motoBike->getMotor() ?></b></p>
</div>
</body>
</html>

