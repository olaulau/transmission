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
$torrentsObject = TransmissionTorrent::getTorrentObjectsFromAssoc($config['transmission']);

// sort array by hashstring
$torrentsSorted = [];
foreach ($torrentsObject as $torrentObject) {
	$hashString = $torrentObject->getInfos()['hashString'];
	$torrentsSorted[$hashString] = $torrentObject;
}
$hashStrings = array_keys($torrentsSorted);


// sync with database : insert missing one, retrieve transfertDate field
$dbTorrent = new DB\SQL\Mapper ($db, 'torrent');
$dbTorrents = $dbTorrent->find();
foreach ($dbTorrents as $id => $dbTorrent) {
	$hashString = $dbTorrent['hashString'];
	$dbTorrents[$hashString] = $dbTorrent;
	unset ($dbTorrents[$id]);
}
// vdd($dbTorrents);
foreach ($torrentsSorted as $hashString => $torrent) {
	if (isset ($dbTorrents[$hashString])) {
		$dbTorrent = $dbTorrents[$hashString];
		$torrent->setTransfertDate($dbTorrent->transfertDate);
	}
	else {
		$dbTorrent->reset();
		$dbTorrent->copyfrom($transmissionTorrent);
		$dbTorrent->addedDate = date('Y-m-d H:i:s P', $torrent->addedDate);
		$dbTorrent->save();
	}
}


// delete spare ones
$db->exec('
	DELETE FROM torrent
	WHERE hashString NOT IN (' . implode(',', array_fill(0, count($hashStrings), '?')) . ')',
	$hashStrings
);

// vdd ( $db->log() );
