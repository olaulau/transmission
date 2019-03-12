<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/php/config.inc.php';
require_once __DIR__ . '/php/functions.inc.php';
require_once __DIR__ . '/php/Torrent.class.php';


$transmission = new Vohof\Transmission($config['transmission']);

$stats = $transmission->getStats();
// var_dump($stats);

$torrents = $transmission->get('all');
$torrentsAssoc = $torrents['torrents'];
// var_dump($torrents);

$torrentsObject = [];
foreach ($torrentsAssoc as $torrent) {
	$torrent = new Torrent($torrent);
	$torrentsObject[] = $torrent;
}
// var_dump($torrentsObject); die;
