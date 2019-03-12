<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/php/config.inc.php';
require_once __DIR__ . '/php/functions.inc.php';
require_once __DIR__ . '/php/Torrent.class.php';


$transmission = new Vohof\Transmission($config['transmission']);

$stats = $transmission->getStats();
// var_dump($stats);

$torrentsObject = Torrent::getTorrentObjectsFromAssoc($config['transmission']);
// var_dump($torrentsObject); die;
