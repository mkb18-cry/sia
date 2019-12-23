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
	if ($_GET['mod'] == 'nilai_semester' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		$id_mhs = $_POST["id_mhs"];
		$uts	= $_POST["uts"]; // 20%
		$uas	= $_POST["uas"]; // 30%
		$absensi= $_POST["absensi"]; // 10%
		$tugas	= $_POST["tugas"]; // 40%
		$count	= COUNT($id_mhs);
		
		for($i = 0; $i <= $count; $i++){
			
			$nilai_tugas= ($tugas[$i] / 100) * 40;
			$nilai_uts	= ($uts[$i] / 100) * 20;
			$nilai_uas	= ($uas[$i] / 100) * 30;
			
			$total = $absensi[$i] + $nilai_tugas + $nilai_uts + $nilai_uas;
			
			$db->database_prepare("INSERT INTO as_nilai_semester_mhs (	id_mhs,
																		makul_id,
																		kelas_id,
																		semester_nilai,
																		absensi,
																		tugas,
																		uts,
																		uas,
																		total,
																		created_date,
																		created_userid,
																		modified_date,
																		modified_userid)
															VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)")
															->execute( 	$id_mhs[$i],
																		$_POST["makul"],
																		$_POST["kelas_id"],
																		$_POST["sms"],
																		$absensi[$i],
																		$tugas[$i],
																		$uts[$i],
																		$uas[$i],
																		$total,
																		$created_date,
																		$_SESSION["userid"],
																		"",
																		"");
		}
		header("Location: ../../index.php?mod=nilai_semester&act=preview&prodi=".$_POST['prodi']."&kelas=".$_POST['kelas']."&makul=".$_POST['makul']."&code=1");
	} 
	
	elseif($_GET['mod'] == 'nilai_semester' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		$nilai_id = $_POST["nilai_id"];
		$uts	= $_POST["uts"]; // 20%
		$uas	= $_POST["uas"]; // 30%
		$absensi= $_POST["absensi"]; // 10%
		$tugas	= $_POST["tugas"]; // 40%
		$count	= COUNT($nilai_id);
		
		for($i = 0; $i <= $count; $i++){
			$nilai_tugas= ($tugas[$i] / 100) * 40;
			$nilai_uts	= ($uts[$i] / 100) * 20;
			$nilai_uas	= ($uas[$i] / 100) * 30;
			
			$total = $absensi[$i] + $nilai_tugas + $nilai_uts + $nilai_uas;
			
			$db->database_prepare("UPDATE as_nilai_semester_mhs SET	absensi = ?,
																	tugas = ?,
																	uts = ?,
																	uas = ?,
																	total = ?,
																	modified_date = ?,
																	modified_userid = ?
																	WHERE nilai_id = ?")
														->execute( 	$absensi[$i],
																	$tugas[$i],
																	$uts[$i],
																	$uas[$i],
																	$total,
																	$modified_date,
																	$_SESSION["userid"],
																	$nilai_id[$i]);
		}
		header("Location: ../../index.php?mod=nilai_semester&act=preview&prodi=".$_POST['prodi']."&kelas=".$_POST['kelas']."&makul=".$_POST['makul']."&code=1");
	}
}
?>