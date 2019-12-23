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
	if ($_GET['mod'] == 'makul' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("INSERT INTO as_makul (	kode_mata_kuliah,
														tahun_pelaporan,
														semester_pelaporan,
														prodi_id,
														nama_mata_kuliah_ind,
														nama_mata_kuliah_eng,
														jenis_mata_kuliah,
														jenis_kurikulum,
														kelompok_mata_kuliah,
														sks_mata_kuliah,
														sks_tatap_muka,
														sks_praktikum,
														sks_praktek_lapangan,
														status_mata_kuliah,
														sap,
														silabus,
														acara_praktek,
														nidn,
														created_date,
														created_userid,
														modified_date,
														modified_userid)
											VALUE	(?,?,?,?,?,?,?,?,?,?,
													?,?,?,?,?,?,?,?,?,?,?,?)")
										->execute(	$_POST["kode_mata_kuliah"],
													"",
													"",
													$_POST["prodi_id"],
													$_POST["nama_mata_kuliah_ind"],
													$_POST["nama_mata_kuliah_eng"],
													$_POST["jenis_mata_kuliah"],
													$_POST["jenis_kurikulum"],
													$_POST["kelompok_mata_kuliah"],
													$_POST["sks_kurikulum"],
													$_POST["sks_tatap_muka"],
													$_POST["sks_praktikum"],
													$_POST["sks_praktek_lapangan"],
													$_POST["status_mata_kuliah"],
													$_POST["sap"],
													$_POST["silabus"],
													"",
													$_POST["dosen_pengampu"],
													$created_date,
													$_SESSION["userid"],
													"",
													"");
		header("Location: ../../index.php?mod=makul&code=1");
	} 
	
	elseif ($_GET['mod'] == 'makul' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("UPDATE as_makul SET	tahun_pelaporan = ?,
													semester_pelaporan = ?,
													prodi_id = ?,
													nama_mata_kuliah_ind = ?,
													nama_mata_kuliah_eng = ?,
													jenis_mata_kuliah = ?,
													jenis_kurikulum = ?,
													kelompok_mata_kuliah = ?,
													sks_mata_kuliah = ?,
													sks_tatap_muka = ?,
													sks_praktikum = ?,
													sks_praktek_lapangan = ?,
													status_mata_kuliah = ?,
													sap = ?,
													silabus = ?,
													acara_praktek = ?,
													nidn = ?,
													modified_date = ?,
													modified_userid = ?
												WHERE mata_kuliah_id = ?")
									->execute(	"",
												"",
												$_POST["prodi_id"],
												$_POST["nama_mata_kuliah_ind"],
												$_POST["nama_mata_kuliah_eng"],
												$_POST["jenis_mata_kuliah"],
												$_POST["jenis_kurikulum"],
												$_POST["kelompok_mata_kuliah"],
												$_POST["sks_kurikulum"],
												$_POST["sks_tatap_muka"],
												$_POST["sks_praktikum"],
												$_POST["sks_praktek_lapangan"],
												$_POST["status_mata_kuliah"],
												$_POST["sap"],
												$_POST["silabus"],
												"",
												$_POST["dosen_pengampu"],
												$modified_date,
												$_SESSION["userid"],
												$_POST["id"]);	
														
														
		header("Location: ../../index.php?mod=makul&code=2");	
	}
	
	elseif ($_GET['mod'] == 'makul' && $_GET['act'] == 'delete'){
		$db->database_prepare("DELETE FROM as_makul WHERE mata_kuliah_id = ?")->execute($_GET["id"]);
		header("Location: ../../index.php?mod=makul&code=3");
	}
}
?>