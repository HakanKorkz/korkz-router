<?php

use Dotenv\Dotenv;
use Korkz\KorkzRouter\router;

require_once __DIR__."/vendor/autoload.php";

$envPath=__DIR__."/";

$dotenv = Dotenv::createImmutable("$envPath");
$dotenv->load();
$path = $_SERVER["SCRIPT_URI"] ?? $_SERVER["REQUEST_URI"];

$Route=new router($_ENV);

print_r($Route->router($path));