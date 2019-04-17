<?php
require_once __DIR__ . '/All.inc.php';
use TransmissionTorrentImplVohof as TransmissionTorrent;


$hashString = $_GET['hashString'];
if (empty ($hashString)) {
	die ('no valid id parameter provided');
}

$torrents = TransmissionTorrent::getTorrentObjectsFromAssoc ($config['transmission']);
$torrent = $torrents[$hashString];

$torrent->delete ();
