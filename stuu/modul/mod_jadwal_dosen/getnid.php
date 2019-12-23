<?php
error_reporting(0);
session_start();
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";
include "../../../config/debug.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
	header("Location: ../../../index.php?code=2");
}

else{
	$q = strtolower($_GET["q"]);
	$nim = "%".$q."%";
	
	$sql = $db->database_prepare("SELECT * FROM msdos WHERE NODOSMSDOS LIKE ? or NMDOSMSDOS LIKE ?")->execute($nim,$nim);
	while($rs = $db->database_fetch_array($sql)) {
		echo "$rs[NODOSMSDOS] - $rs[NMDOSMSDOS] $rs[GELARMSDOS]\n";
	}
}
?>