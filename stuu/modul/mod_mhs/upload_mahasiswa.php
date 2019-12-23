<?php
$uploaddir = '../../foto/mahasiswa/'; 
$file = $uploaddir ."st_asfa_".basename($_FILES['uploadfile']['name']); 
$file_name= "st_asfa_".$_FILES['uploadfile']['name']; 
 
if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {
	echo "success"; 
} 
else {
	echo "error";
}
?>