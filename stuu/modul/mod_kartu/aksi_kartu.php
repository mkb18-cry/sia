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
	if ($_GET['mod'] == 'kartu_absensi_harian' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		
		$id_mhs = $_POST['id_mhs'];
		$jadwal_id = $_POST['jadwal_id'];
		$jadwal = $_POST['jadwal'];
		$date = $_POST['tgl_absen'];
		$paraf = $_POST['paraf'];
		$count = COUNT($id_mhs);
		$nums = $db->database_num_rows($db->database_prepare("SELECT * FROM as_absensi_mhs WHERE jadwal_id = ? AND tanggal_absen = ?")
										->execute($jadwal,$date));
		if ($nums == 0){
			for ($i = 0; $i < $count; $i++){
				$db->database_prepare("INSERT INTO as_absensi_mhs (	jadwal_id,
																		id_mhs,
																		tanggal_absen,
																		paraf,
																		created_date,
																		created_userid,
																		modified_date,
																		modified_userid) VALUES(?,?,?,?,?,?,?,?)")
															->execute( 	$jadwal_id[$i],
																		$id_mhs[$i],
																		$date,
																		$paraf[$i],
																		$created_date,
																		$_SESSION["userid"],
																		"",
																		"");
			}
			header("Location: ../../index.php?mod=kartu_absensi_harian&act=viewentri&prodi=".$_POST['prodi']."&kelas=".$_POST['kelas']."&makul2=".$_POST['makul2']."&date=".$date."&code=1");
		}
		else{
			header("Location: ../../index.php?mod=kartu_absensi_harian&act=entri&prodi=".$_POST['prodi']."&kelas=".$_POST['kelas']."&makul2=".$_POST['makul2']."&code=4");
		}
	}

	elseif ($_GET['mod'] == 'kartu_absensi_ujian' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		
		$id_mhs = $_POST['id_mhs'];
		$jadwal_id = $_POST['jadwal_id'];
		$jadwal = $_POST['jadwal'];
		$date = $_POST['tgl_absen'];
		$paraf = $_POST['paraf'];
		$status = $_POST['status'];
		$count = COUNT($id_mhs);
		$nums = $db->database_num_rows($db->database_prepare("SELECT * FROM as_abs_ujian_mhs WHERE jadwal_id = ? AND jenis_ujian = ?")
										->execute($jadwal,$status));
		if ($nums == 0){
			for ($i = 0; $i < $count; $i++){
				$db->database_prepare("INSERT INTO as_abs_ujian_mhs (	jadwal_id,
																		id_mhs,
																		tanggal_absen,
																		jenis_ujian,
																		paraf,
																		created_date,
																		created_userid,
																		modified_date,
																		modified_userid) VALUES(?,?,?,?,?,?,?,?,?)")
															->execute( 	$jadwal_id[$i],
																		$id_mhs[$i],
																		$date,
																		$status,
																		$paraf[$i],
																		$created_date,
																		$_SESSION["userid"],
																		"",
																		"");
			}
			header("Location: ../../index.php?mod=kartu_absensi_ujian&act=viewentri&prodi=".$_POST['prodi']."&kelas=".$_POST['kelas']."&makul2=".$_POST['makul2']."&date=".$date."&status=".$status."&code=1");
		}
		else{
			header("Location: ../../index.php?mod=kartu_absensi_ujian&act=entri&prodi=".$_POST['prodi']."&kelas=".$_POST['kelas']."&makul2=".$_POST['makul2']."&status=".$status."&code=4");
		}
	} 
	
	elseif ($_GET['mod'] == 'kartu_absensi_harian' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		$id_mhs = $_POST['id_mhs'];
		$jadwal_id = $_POST['jadwal_id'];
		$absensi_id = $_POST['id_absensi'];
		$paraf = $_POST['paraf'];
		$date = $_POST['tgl'];
		$kelas = explode("%", $_POST['kelas']);
		$count = COUNT($id_mhs);
		
		for ($i = 0; $i < $count; $i++){
			$db->database_prepare("UPDATE as_absensi_mhs SET paraf = ?, modified_date = ?, modified_userid = ? WHERE absensi_id = ?")
			->execute($paraf[$i],$modified_date,$_SESSION["userid"],$absensi_id[$i]);
		}
		header("Location: ../../index.php?mod=kartu_absensi_harian&act=viewentriupdate&prodi=".$_POST['prodi']."&kelas=".$kelas[0]."&angkatan_id=".$kelas[2]."&makul3=".$_POST['makul3']."&date=".$date."&code=2");
	}
	
	elseif ($_GET['mod'] == 'kartu_absensi_ujian' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		$id_mhs = $_POST['id_mhs'];
		$jadwal_id = $_POST['jadwal_id'];
		$absensi_id = $_POST['id_absensi'];
		$paraf = $_POST['paraf'];
		$date = $_POST['tgl'];
		$status = $_POST['status'];
		$kelas = explode("%", $_POST['kelas']);
		$count = COUNT($id_mhs);
		
		for ($i = 0; $i < $count; $i++){
			$db->database_prepare("UPDATE as_abs_ujian_mhs SET paraf = ?, modified_date = ?, modified_userid = ? WHERE abs_ujian_id = ?")
			->execute($paraf[$i],$modified_date,$_SESSION["userid"],$absensi_id[$i]);
		}
		header("Location: ../../index.php?mod=kartu_absensi_ujian&act=viewentriupdate&prodi=".$_POST['prodi']."&kelas=".$kelas[0]."&angkatan_id=".$kelas[2]."&makul3=".$_POST['makul3']."&date=".$date."&status=".$status."&code=2");
	}
	
	elseif ($_GET['mod'] == 'jadwal_mata_kuliah' && $_GET['act'] == 'delete'){
		$db->database_prepare("DELETE FROM as_jadwal_kuliah WHERE jadwal_id = ?")->execute($_GET["id"]);
		header("Location: ../../index.php?mod=jadwal_mata_kuliah&act=mgm_mata_kuliah&prodi=".$_GET['prodi']."&tahun_angkatan=".$_GET['angkatan_id']."&kelas_id=".$_GET['kelas_id']."&semester=".$_GET['semester']."&code=3");
	}
}
?>