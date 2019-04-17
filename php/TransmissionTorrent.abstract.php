<?php

abstract class TransmissionTorrent {
	
	
	public abstract static function getTorrentObjectsFromAssoc ($transmissionConfig) ;
	
	
	public abstract function getInfos () ;
	
	public abstract function isDownloaded () ;
	
	public abstract function getId() ;
	public abstract function getName() ;
	public abstract function getHashString () ;
	public abstract function getAddedDate () ;
	
	public abstract function getTransfertDate () ;
	public abstract function setTransfertDate ($TransfertDate) ;
	
	public abstract function getStatus () ;
	
	
	public final function transfert ($transfertDestination) {
		$src = rtrim($this->getInfos ()['downloadDir'] . '/' . $this->getName(), '/');
		$dest = "$transfertDestination/";
		$cmd = 'rsync -rh --stats --itemize-changes --partial --inplace "'.$src.'" "'.$dest.'"';
		$redirect = '>> transfert.log 2>&1';
		passthru("echo ' ' $redirect");
		passthru("date $redirect");
		passthru("pwd $redirect");
		passthru("$cmd $redirect &");
	}
	
	public abstract function delete () ;
}
