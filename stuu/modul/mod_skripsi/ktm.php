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
	$direktori = "../../foto/ktm/"; // folder tempat penyimpanan file yang boleh didownload
	$filename = $_GET['file'];
	
	$file_extension = strtolower(substr(strrchr($filename,"."),1));
	
	switch($file_extension){
	  case "gif": $ctype="image/gif"; break;
	  case "png": $ctype="image/png"; break;
	  case "jpeg":
	  case "jpg": $ctype="image/jpg"; break;
	  default: $ctype="application/proses";
	}
	
	header("Content-Type: octet/stream");
	header("Pragma: private"); 
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false); 
	header("Content-Type: $ctype");
	header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".filesize($direktori.$filename));
	readfile("$direktori$filename");
	exit();
}
?>