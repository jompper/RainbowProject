<?php
function getDB(){
	static $dbh = null;
	
	if($yhteys === null){
		$dbh = new PDO('pgsql:');
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	return $dbh;
}
