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
	if ($_GET['mod'] == 'bahan_kuliah' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		$filename = $_FILES['name_file']['tmp_name'];
		$unik = date('Ymdhis');
		$file_name = $unik.'_'.$_FILES['name_file']['name'];
		
		$upload = move_uploaded_file($filename, "../../files/".$file_name);
		
		if ($upload){
			$data_dos = $db->database_fetch_array($db->database_prepare("SELECT nidn FROM as_makul WHERE mata_kuliah_id = ?")->execute($_POST["makul"]));
			$db->database_prepare("INSERT INTO as_bahan_kuliah (	judul,
																	prodi_id,
																	makul_id,
																	kelas_id,
																	jenis,
																	track_download,
																	status,
																	keterangan,
																	filename,
																	dos,
																	created_date,
																	created_userid,
																	modified_date,
																	modified_userid)
															VALUES	(?,?,?,?,?,?,?,?,?,?,?,?,?,?)")
														->execute(	$_POST["judul"],
																	$_POST["prodi"],
																	$_POST["makul"],
																	$_POST["kelas"],
																	$_POST["jenis"],
																	0,
																	$_POST["status"],
																	$_POST["keterangan"],
																	$file_name,
																	$data_dos["nidn"],
																	$created_date,
																	$_SESSION["userid"],
																	"",
																	"");
			header("Location: ../../index.php?mod=bahan_kuliah&code=1");
		}
		else{
			header("Location: ../../index.php?mod=bahan_kuliah&code=4");
		}
	} 
	
	elseif ($_GET['mod'] == 'bahan_kuliah' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		$filename = $_FILES['name_file']['tmp_name'];
		$unik = date('Ymdhis');
		$file_name = $unik.'_'.$_FILES['name_file']['name'];
		
		if ($_FILES['name_file']['name'] != ''){
			$upload = move_uploaded_file($filename, "../../files/".$file_name);
			
			if ($upload){
				$db->database_prepare("UPDATE as_bahan_kuliah SET	judul = ?,
																	jenis = ?,
																	status = ?,
																	keterangan = ?,
																	filename = ?,
																	modified_date = ?,
																	modified_userid = ?
																	WHERE bahan_id = ?")
														->execute(	$_POST["judul"],
																	$_POST["jenis"],
																	$_POST["status"],
																	$_POST["keterangan"],
																	$file_name,
																	$modified_date,
																	$_SESSION["userid"],
																	$_POST["id"]);
				header("Location: ../../index.php?mod=bahan_kuliah&code=2");
			}
			else{
				header("Location: ../../index.php?mod=bahan_kuliah&code=4");
			}
		}
		else{
			$db->database_prepare("UPDATE as_bahan_kuliah SET	judul = ?,
																jenis = ?,
																status = ?,
																keterangan = ?,
																modified_date = ?,
																modified_userid = ?
																WHERE bahan_id = ?")
													->execute(	$_POST["judul"],
																$_POST["jenis"],
																$_POST["status"],
																$_POST["keterangan"],
																$modified_date,
																$_SESSION["userid"],
																$_POST["id"]);
			header("Location: ../../index.php?mod=bahan_kuliah&code=2");
		}	
	}
	
	elseif ($_GET['mod'] == 'bahan_kuliah' && $_GET['act'] == 'delete'){
		$data = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_bahan_kuliah WHERE bahan_id = ?")->execute($_GET["id"]));
		$unlink = unlink("../../files/".$data['filename']);
		if ($unlink){
			$db->database_prepare("DELETE FROM as_bahan_kuliah WHERE bahan_id = ?")->execute($_GET["id"]);
			header("Location: ../../index.php?mod=bahan_kuliah&code=3");
		}
	}
}
?>