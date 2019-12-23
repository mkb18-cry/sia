<?php
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";
include "../../../config/debug.php";
$q=$_GET['q'];
$my_data=mysql_real_escape_string($q);
$like = "%".$my_data."%";
$sql = $db->database_prepare("SELECT * FROM as_kode_program_studi WHERE nama_program_studi LIKE ? ORDER BY nama_program_studi ASC")->execute($like);
while ($row = $db->database_fetch_array($sql)){
	$npt = $row['jenjang_studi']." : ".$row['nama_program_studi']." : ".$row['kode_program_studi'];
	echo $npt."\n";
}
?>