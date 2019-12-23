<?php
error_reporting(0);
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";

$sql_prodi = $db->database_prepare("SELECT * FROM as_kelas WHERE prodi_id = ? AND aktif = 'A'")->execute($_GET['prodi3']);
echo "<option value=''></option>";
while($k = $db->database_fetch_array($sql_prodi)){
    echo "<option value='$k[kelas_id]*$k[semester_kelas]*$k[angkatan_id]'>$k[nama_kelas] / $k[semester_kelas]</option>";
}
?>