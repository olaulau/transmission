<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/php/config.inc.php';
require_once __DIR__ . '/php/functions.inc.php';
require_once __DIR__ . '/php/Torrent.class.php';


// init
// $f3 = \Base::instance ();
$db = new DB\SQL('sqlite:./database.sqlite');


$hashString = $_GET['hashString'];
if (empty ($hashString)) {
	die('no valid id parameter provided');
}

$torrents = TransmissionTorrent::getTorrentObjectsFromAssoc($config['transmission']);
$torrent = $torrents['da26081ca69eb5a3d0f9bedd2c77613515b3500c'];

$torrent->transfert($config['transfertDestination']);


// mark torrent as transfered
$dbTorrent = new DB\SQL\Mapper ($db, 'torrent');
$dbTorrent->load(['hashString=?', $torrent->getInfos()['hashString']]);
$dbTorrent->transfertDate = date('Y-m-d H:i:s P');
$dbTorrent->save();
