<?php
require_once __DIR__ . '/All.inc.php';
use TransmissionTorrentImplVohof as TransmissionTorrent;


// init
$f3 = \Base::instance ();
$f3->set('DEBUG',3);
$db = new DB\SQL('sqlite:'.__DIR__.'/../database.sqlite');

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
