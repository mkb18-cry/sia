<?php
error_reporting(0);
session_start();
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";

$kelas = explode("*", $_GET['kelas3']);

if ($_SESSION['level'] == 'dos'){
	$sql_makul = $db->database_prepare("SELECT as_jadwal_kuliah.makul_id, as_makul.nama_mata_kuliah_eng, as_makul.kode_mata_kuliah FROM as_jadwal_kuliah INNER JOIN as_makul ON as_makul.mata_kuliah_id=as_jadwal_kuliah.makul_id WHERE as_jadwal_kuliah.kelas_id = ? AND as_jadwal_kuliah.semester = ? AND as_jadwal_kuliah.dosen_id = ?")->execute($kelas[0],$kelas[1],$_SESSION["useri"]);
}
else{
	$sql_makul = $db->database_prepare("SELECT as_jadwal_kuliah.makul_id, as_makul.nama_mata_kuliah_eng, as_makul.kode_mata_kuliah FROM as_jadwal_kuliah INNER JOIN as_makul ON as_makul.mata_kuliah_id=as_jadwal_kuliah.makul_id WHERE as_jadwal_kuliah.kelas_id = ? AND as_jadwal_kuliah.semester = ?")->execute($kelas[0],$kelas[1]);
}

while($k = $db->database_fetch_array($sql_makul)){
    echo "<option value=$k[makul_id]>$k[kode_mata_kuliah] - $k[nama_mata_kuliah_eng]</option>";
}
?>