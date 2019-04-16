<?php

class TransmissionTorrent {
	
	/**
	 * @var array $array : an array of info about the torrent, got from the lib
	 */
	private $infos;
	
	private static $transmission;
	
	
	/**
	 * constructor
	 * @param array $array an array of info about the torrent, got from the lib
	 */
	function __construct($infos) {
		$this->infos = $infos;
	}
	
	public function getInfos () { //TODO remove
		return $this->infos;
	}
	
	
	public static function getTorrentObjectsFromAssoc ($transmissionConfig) {
		self::$transmission = new Vohof\Transmission($transmissionConfig);

		$torrents = self::$transmission->get('all');
		$torrentsAssoc = $torrents['torrents'];
// 		var_dump($torrentsAssoc);
		
		$torrentsObject = [];
		foreach ($torrentsAssoc as $torrent) {
			$torrent = new TransmissionTorrent($torrent);
			$torrentsObject[$torrent->getHashString()] = $torrent;
		}
// 		var_dump($torrentsObject); die;
		return $torrentsObject;
	}
	
	
	public function isDownloaded () {
		return ($this->infos['percentDone'] == 1);
	}
	
	
	public function getId() {
		return ($this->infos['id']);
	}
	
	public function getName() {
		return ($this->infos['name']);
	}
	
	
	public function getStatus () {
		switch ($this->infos['status']) {
			case 0:
				if ($this->isDownloaded ()) {
					return 'seeding';
				}
				else {
					return 'downloading';
				}
			break;
			
			case 4:
				return 'downloading';
			break;
			
			case 6:
				if ($this->infos['uploadRatio'] < $this->infos['seedRatioLimit']) {
					return 'seeding';
				}
				else {
					return 'finished';
				}
				
			break;
			
			default:
				return 'other';
			break;
		}
	}
	
	
	public function getTransfertDate () {
		return $this->infos['transfertDate'];
	}
	
	public function setTransfertDate ($TransfertDate) {
		$this->infos['transfertDate'] = $TransfertDate;
	}
	
	
	public function getHashString () {
		return $this->infos['hashString'];
	}
	
	
	public function transfert ($transfertDestination) {
		$src = rtrim($this->infos['downloadDir'] . '/' . $this->getName(), '/');
		$dest = "$transfertDestination/";
		$cmd = 'rsync -rh --stats --itemize-changes --partial --inplace "'.$src.'" "'.$dest.'"';
		$redirect = '>> transfert.log 2>&1';
		passthru("echo ' ' $redirect");
		passthru("date $redirect");
		passthru("pwd $redirect");
		passthru("$cmd $redirect &");
	}
	
	
	public function delete () {
		self::$transmission->remove([$this->getId()], true);
	}
}
