<?php

require_once __DIR__ . '/autoload.php';

use services\ServiceManager;

$serviceManager = new ServiceManager();
echo $serviceManager->has('zzz') ? 'yes' : 'no';

