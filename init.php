<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/php/config.inc.php';
require_once __DIR__ . '/php/functions.inc.php';
require_once __DIR__ . '/php/Torrent.class.php';


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
