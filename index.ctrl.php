<?php
require_once __DIR__ . '/php/All.inc.php';
use TransmissionTorrentImplVohof as TransmissionTorrent;


// get torrents from RPC
$transmission = new Vohof\Transmission($config['transmission']);
$stats = $transmission->getStats();
$torrents = TransmissionTorrent::getTorrentObjectsFromAssoc($config['transmission']);
$hashStrings = array_keys($torrents);


// sync with database : insert missing one, retrieve transfertDate field
$dbTorrent = new DB\SQL\Mapper ($db, 'torrent');
//TODO init database if empty

$dbTorrents = $dbTorrent->find();
foreach ($dbTorrents as $id => $dbTorrent) {
	$hashString = $dbTorrent['hashString'];
	$dbTorrents[$hashString] = $dbTorrent;
	unset ($dbTorrents[$id]);
}
// vdd($dbTorrents);
foreach ($torrents as $hashString => $torrent) {
	if (isset ($dbTorrents[$hashString])) {
		$dbTorrent = $dbTorrents[$hashString];
		$torrent->setTransfertDate($dbTorrent->transfertDate);
	}
	else {
		$dbTorrent->reset();
		$dbTorrent->hashString = $torrent->getHashString();
		$dbTorrent->addedDate = date('Y-m-d H:i:s P', $torrent->getAddedDate());
		$dbTorrent->id = $torrent->getId();
		$dbTorrent->name = $torrent->getName();
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
