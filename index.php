<?php

use Korkz\KorkzRouter\App;

require_once __DIR__."/vendor/autoload.php";

$app= new App();

echo $app->route();