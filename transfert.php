<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/php/config.inc.php';
require_once __DIR__ . '/php/functions.inc.php';
require_once __DIR__ . '/php/Torrent.class.php';


// init
// $f3 = \Base::instance ();
$db = new DB\SQL('sqlite:./database.sqlite');


$id = intval($_GET['id']);
if (empty ($id)) {
	die('no valid id parameter provided');
}

$torrentsObject = TransmissionTorrent::getTorrentObjectsFromAssoc($config['transmission']);
// var_dump($torrentsObject); die;

foreach ($torrentsObject as $transmissionTorrent) {
	if ($transmissionTorrent->getId() === $id) {
		break;
	}
}
// var_dump($transmissionTorrent); die;

//DEBUG
// $transmissionTorrent->transfert($config['transfertDestination']);


// mark torrent as transfered
$torrent = new DB\SQL\Mapper ($db, 'torrent');
$torrent->load(['hashString=?', $transmissionTorrent->getInfos()['hashString']]);
$torrent->transfertDate = date('Y-m-d H:i:s P');
$torrent->save();
