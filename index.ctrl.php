<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/php/functions.inc.php';
require_once __DIR__ . '/php/config.inc.php';


$transmission = new Vohof\Transmission($config);

$stats = $transmission->getStats();
// var_dump($stats);
