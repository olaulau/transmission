<?php

class Torrent {
	
	/**
	 * @var array $array : an array of info about the torrent, got from the lib
	 */
	private $infos;
	
	/**
	 * constructor
	 * @param array $array an array of info about the torrent, got from the lib
	 */
	function __construct($infos) {
		$this->infos = $infos;
	}
	
	
	public function isDownloaded () {
		return ($this->infos['percentDone'] == 1);
	}
	
	
	public function getName() {
		return ($this->infos['name']);
	}
	
	
	public function getStatus () {
		switch ($this->infos['status']) {
			case 0:
				if (isDownloaded ()) {
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
}
