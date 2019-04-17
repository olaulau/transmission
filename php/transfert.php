<?php
require_once __DIR__ . '/All.inc.php';
use TransmissionTorrentImplVohof as TransmissionTorrent;


$hashString = $_GET['hashString'];
if (empty ($hashString)) {
	die('no valid id parameter provided');
}

$torrents = TransmissionTorrent::getTorrentObjectsFromAssoc($config['transmission']);
$torrent = $torrents[$hashString];

$torrent->transfert($config['transfertDestination']);


// mark torrent as transfered
$dbTorrent = new DB\SQL\Mapper ($db, 'torrent');
$dbTorrent->load(['hashString=?', $torrent->getHashString()]);
$dbTorrent->transfertDate = date('Y-m-d H:i:s P');
$dbTorrent->save();
