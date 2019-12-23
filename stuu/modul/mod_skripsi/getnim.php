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
	
	$sql = $db->database_prepare("SELECT * FROM as_mahasiswa WHERE NIM LIKE ? or nama_mahasiswa LIKE ?")->execute($nim,$nim);
	while($rs = $db->database_fetch_array($sql)) {
		echo "$rs[NIM] - $rs[nama_mahasiswa]\n";
	}
}
?>