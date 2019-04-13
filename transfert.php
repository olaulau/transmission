<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/php/config.inc.php';
require_once __DIR__ . '/php/functions.inc.php';
require_once __DIR__ . '/php/Torrent.class.php';


$id = intval($_GET['id']);
if (empty ($id)) {
	die('no valid id parameter provided');
}

$torrentsObject = TransmissionTorrent::getTorrentObjectsFromAssoc($config['transmission']);
// var_dump($torrentsObject); die;

foreach ($torrentsObject as $torrent) {
	if ($torrent->getId() === $id) {
		break;
	}
}
// var_dump($torrent); die;

$torrent->transfert($config['transfertDestination']);
