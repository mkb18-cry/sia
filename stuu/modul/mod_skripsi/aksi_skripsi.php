<?php
error_reporting(0);
session_start();
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";
include "../../../config/debug.php";
include "../../../fungsi/PHPExcel.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
	header("Location: ../../../index.php?code=2");
}

else{
	if ($_GET['mod'] == 'skripsi' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		
		$nim = explode("-", $_POST['nim']);
		
		$sql_mhs = $db->database_prepare("SELECT * FROM as_mahasiswa WHERE NIM = ? AND status_mahasiswa = 'A'")->execute($nim[0]);
		$nums = $db->database_num_rows($sql_mhs);
		$data_mhs = $db->database_fetch_array($sql_mhs);
		
		$nums_skripsi = $db->database_num_rows($db->database_prepare("SELECT * FROM as_skripsi WHERE id_mhs = ?")->execute($data_mhs['id_mhs']));
		
		if ($nums == 0){
			header("Location: ../../index.php?mod=skripsi&code=4");
		}
		
		elseif ($nums_skripsi > 0){
			header("Location: ../../index.php?mod=skripsi&code=5");
		}
		
		else{
		
			$db->database_prepare("INSERT INTO as_skripsi ( id_mhs,
															judul_skripsi,
															pembimbing1,
															pembimbing2,
															status,
															tanggal_daftar,
															created_date,
															created_userid,
															modified_date,
															modified_userid)
														VALUES (?,?,?,?,?,?,?,?,?,?)")
													->execute( 	$data_mhs["id_mhs"],
																$_POST["judul_skripsi"],
																$_POST["pembimbing1"],
																$_POST["pembimbing2"],
																$_POST["status"],
																$_POST["tanggal_daftar"],
																$created_date,
																$_SESSION["userid"],
																"",
																"");
																
			header("Location: ../../index.php?mod=skripsi&code=1");
		}
	} 
	
	elseif($_GET['mod'] == 'skripsi' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("UPDATE as_skripsi SET	judul_skripsi = ?,
														pembimbing1 = ?,
														pembimbing2 = ?,
														status = ?,
														tanggal_daftar = ?,
														modified_date = ?,
														modified_userid = ?
														WHERE id_skripsi = ?")
											->execute	($_POST["judul_skripsi"],
														$_POST["pembimbing1"],
														$_POST["pembimbing2"],
														$_POST["status"],
														$_POST["tanggal_daftar"],
														$modified_date,
														$_SESSION["userid"],
														$_POST["id"]);
		header("Location: ../../index.php?mod=skripsi&act=biodata&program_studi=".$_POST["program_studi"]."&angkatan_id=".$_POST['angkatan_id']."&code=2");
	}

	elseif ($_GET['mod'] == 'skripsi' && $_GET['act'] == 'delete'){
		$db->database_prepare("DELETE FROM as_skripsi WHERE id_skripsi = ?")->execute($_GET["ids"]);
		header("Location: ../../index.php?mod=skripsi&act=biodata&program_studi=".$_GET["program_studi"]."&angkatan_id=".$_GET['angkatan_id']."&code=3");
	}
}
?>