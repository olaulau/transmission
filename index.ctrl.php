<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/php/config.inc.php';
require_once __DIR__ . '/php/functions.inc.php';
require_once __DIR__ . '/php/Torrent.class.php';


// init
// $f3 = \Base::instance ();
$db = new DB\SQL('sqlite:./database.sqlite');


// get torrents from RPC
$transmission = new Vohof\Transmission($config['transmission']);
$stats = $transmission->getStats();
// var_dump($stats);
$torrentsObject = TransmissionTorrent::getTorrentObjectsFromAssoc($config['transmission']);
// var_dump($torrentsObject[0]->getInfos()); die;


// sync with database (insert missing one, retrieve transfertDate field
$torrent = new DB\SQL\Mapper ($db, 'torrent');
foreach($torrentsObject as $torrentObject) {
	$transmissionTorrent = $torrentObject->getInfos();
	$torrent->reset();
	$torrent->load(['hashString=?', $transmissionTorrent['hashString']]);
	$torrent->copyfrom($transmissionTorrent);
	$torrent->addedDate = date('Y-m-d H:i:s P', $torrent->addedDate);
	$torrent->save();
	$torrentObject->setTransfertDate($torrent->transfertDate);
}

//TODO delete spare ones
