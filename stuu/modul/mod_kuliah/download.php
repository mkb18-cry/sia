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

	$direktori = "../../files/"; // folder tempat penyimpanan file yang boleh didownload
	
	$data = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_bahan_kuliah WHERE bahan_id = ?")->execute($_GET["id"]));
	$filename = $data['filename'];
	$file_extension = strtolower(substr(strrchr($filename,"."),1));
	
	switch($file_extension){
	  case "pdf": $ctype="application/pdf"; break;
	  case "exe": $ctype="application/octet-stream"; break;
	  case "zip": $ctype="application/zip"; break;
	  case "rar": $ctype="application/rar"; break;
	  case "doc": $ctype="application/msword"; break;
	  case "xls": $ctype="application/vnd.ms-excel"; break;
	  case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
	  case "gif": $ctype="image/gif"; break;
	  case "png": $ctype="image/png"; break;
	  case "jpeg":
	  case "jpg": $ctype="image/jpg"; break;
	  default: $ctype="application/proses";
	}
	
	if ($file_extension=='php'){
	  echo "<h1>Access forbidden!</h1>
	        <p>Maaf, file yang Anda download sudah tidak tersedia atau direktori file telah diproteksi. <br />
	        Silahkan hubungi <a href='mailto:info@asfasolution.com'>webmaster</a>.</p>";
	  exit;
	}
	else{
	  mysql_query("update as_bahan_kuliah set track_download=track_download+1 where bahan_id='$_GET[id]'");
	
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
}
?>