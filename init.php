<?php
require_once __DIR__ . '/php/All.inc.php';
use TransmissionTorrentImplVohof as TransmissionTorrent;


// init
// $f3 = \Base::instance ();
$db = new DB\SQL('sqlite:./database.sqlite');

// torrent table
$dbTorrent = new DB\SQL\Mapper ($db, 'torrent');
if (empty ($dbTorrent->schema())) {
	$sql = '
		CREATE TABLE "torrent" (
		  "hashString" text NOT NULL,
		  "addedDate" numeric NOT NULL,
		  "id" integer NOT NULL,
		  "name" text NOT NULL,
		  "transfertDate" numeric NULL,
		  PRIMARY KEY ("hashString")
		);
	';
	$db->exec($sql);
}
