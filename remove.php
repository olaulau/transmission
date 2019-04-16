<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/php/config.inc.php';
require_once __DIR__ . '/php/functions.inc.php';
require_once __DIR__ . '/php/Torrent.class.php';


// init
// $f3 = \Base::instance ();
$db = new DB\SQL ('sqlite:./database.sqlite');


$hashString = $_GET['hashString'];
if (empty ($hashString)) {
	die ('no valid id parameter provided');
}

$torrents = TransmissionTorrent::getTorrentObjectsFromAssoc ($config['transmission']);
$torrent = $torrents[$hashString];

$torrent->delete ();
