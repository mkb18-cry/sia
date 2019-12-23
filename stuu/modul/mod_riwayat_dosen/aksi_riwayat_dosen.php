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
	if ($_GET['mod'] == 'riwayat_dosen' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		$kode_pt = explode(" : ", $_POST['kode_pt']);
		$kode_prodi = explode(" : ", $_POST['kode_prodi']);
		
		if ($kode_prodi[0] == 'S3'){
			$kd_jenjang_studi = "A";
		}
		elseif ($kode_prodi[0] == 'S2'){
			$kd_jenjang_studi = "B";
		}
		elseif ($kode_prodi[0] == 'S1'){
			$kd_jenjang_studi = "C";
		}
		elseif ($kode_prodi[0] == 'D4'){
			$kd_jenjang_studi = "D";
		}
		elseif ($kode_prodi[0] == 'D3'){
			$kd_jenjang_studi = "E";
		}
		elseif ($kode_prodi[0] == 'D2'){
			$kd_jenjang_studi = "F";
		}
		elseif ($kode_prodi[0] == 'D1'){
			$kd_jenjang_studi = "G";
		}
		elseif ($kode_prodi[0] == 'Sp-1'){
			$kd_jenjang_studi = "H";
		}
		elseif ($kode_prodi[0] == 'Sp-2'){
			$kd_jenjang_studi = "I";
		}
		else{
			$kd_jenjang_studi = "J";
		}
		
		$db->database_prepare("INSERT INTO as_riwayat_pendidikan_dosen (dosen_id,
																		kode_perguruan_tinggi,
																		kode_program_studi,
																		kode_jenjang_studi,
																		gelar_akademik,
																		tanggal_ijazah,
																		sks_lulus,
																		ipk_akhir,
																		created_date,
																		created_userid,
																		modified_date,
																		modified_userid)
																VALUES	(?,?,?,?,?,?,?,?,?,?,?,?)")
															->execute(	$_POST["id_dosen"],
																		$kode_pt[1],
																		$kode_prodi[2],
																		$kd_jenjang_studi,
																		$_POST["gelar_akademik"],
																		$_POST["tanggal_lulus"],
																		$_POST["sks_lulus"],
																		$_POST["ipk"],
																		$created_date,
																		$_SESSION["userid"],
																		"",
																		""
																		);
		header("Location: ../../index.php?mod=riwayat_pendidikan_dosen&act=form&nid=".$_POST['no_dosen']."&code=1");
	} 
	
	elseif ($_GET['mod'] == 'riwayat_dosen' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		$kode_pt = explode(" : ", $_POST['kode_pt']);
		$kode_prodi = explode(" : ", $_POST['kode_prodi']);
		
		if ($kode_prodi[0] == 'S3'){
			$kd_jenjang_studi = "A";
		}
		elseif ($kode_prodi[0] == 'S2'){
			$kd_jenjang_studi = "B";
		}
		elseif ($kode_prodi[0] == 'S1'){
			$kd_jenjang_studi = "C";
		}
		elseif ($kode_prodi[0] == 'D4'){
			$kd_jenjang_studi = "D";
		}
		elseif ($kode_prodi[0] == 'D3'){
			$kd_jenjang_studi = "E";
		}
		elseif ($kode_prodi[0] == 'D2'){
			$kd_jenjang_studi = "F";
		}
		elseif ($kode_prodi[0] == 'D1'){
			$kd_jenjang_studi = "G";
		}
		elseif ($kode_prodi[0] == 'Sp-1'){
			$kd_jenjang_studi = "H";
		}
		elseif ($kode_prodi[0] == 'Sp-2'){
			$kd_jenjang_studi = "I";
		}
		else{
			$kd_jenjang_studi = "J";
		}
		
		$db->database_prepare("UPDATE as_riwayat_pendidikan_dosen SET 	kode_perguruan_tinggi = ?,
																		kode_program_studi = ?,
																		kode_jenjang_studi = ?,
																		gelar_akademik = ?,
																		tanggal_ijazah = ?,
																		sks_lulus = ?,
																		ipk_akhir = ?,
																		modified_date = ?,
																		modified_userid = ?
																		WHERE riwayat_id = ?")
															->execute(	$kode_pt[1],
																		$kode_prodi[2],
																		$kd_jenjang_studi,
																		$_POST["gelar_akademik"],
																		$_POST["tanggal_lulus"],
																		$_POST["sks_lulus"],
																		$_POST["ipk"],
																		$modified_date,
																		$_SESSION["userid"],
																		$_POST["id"]);
		header("Location: ../../index.php?mod=riwayat_pendidikan_dosen&act=form&nid=".$_POST['no_dosen']."&code=2");
	}

	elseif ($_GET['mod'] == 'riwayat_pendidikan_dosen' && $_GET['act'] == 'delete'){
		$db->database_prepare("DELETE FROM as_riwayat_pendidikan_dosen WHERE riwayat_id = ?")->execute($_GET["id"]);
		header("Location: ../../index.php?mod=riwayat_pendidikan_dosen&act=form&nid=".$_GET['nid']."&code=3");
	}
	
	
}
?>