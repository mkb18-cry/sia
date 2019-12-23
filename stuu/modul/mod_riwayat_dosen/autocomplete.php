<?php
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";
include "../../../config/debug.php";
$q=$_GET['q'];
$my_data=mysql_real_escape_string($q);
$like = "%".$my_data."%";
$sql = $db->database_prepare("SELECT * FROM as_kode_perguruan_tinggi WHERE nama_perguruan_tinggi LIKE ? ORDER BY nama_perguruan_tinggi ASC")->execute($like);
while ($row = $db->database_fetch_array($sql)){
	$npt = $row['nama_perguruan_tinggi']." ".$row['kota']." : ".$row['kode_perguruan_tinggi'];
	echo $npt."\n";
}
?>