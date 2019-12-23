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
	if ($_GET['mod'] == 'publikasi' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		$db->database_prepare("INSERT INTO as_publikasi_dosen (	dosen_id,
																jenis_penelitian,
																hasil_penelitian,
																kode_pengarang,
																media_publikasi,
																penelitian_dilaksanakan_secara,
																jenis_pembiayaan,
																periode_penelitian,
																judul_penelitian,
																kata_kunci,
																abstrak,
																waktu_pelaksanaan_penelitian,
																lokasi_penelitian,
																status_validasi,
																created_date,
																created_userid,
																modified_date,
																modified_userid)
																VALUES	(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)")
													->execute(	$_POST["id_dosen"],
																$_POST["jenis_penelitian"],
																$_POST["hasil_penelitian"],
																$_POST["pengarang"],
																$_POST["media_publikasi"],
																$_POST["penelitian_dilaksanakan"],
																$_POST["jenis_pembiayaan"],
																$_POST["periode_penelitian"],
																$_POST["judul"],
																$_POST["kata_kunci"],
																$_POST["abstrak"],
																$_POST["waktu_pelaksanaan"],
																$_POST["lokasi_penelitian"],
																$_POST["status_validasi"],
																$created_date,
																$_SESSION["userid"],
																"",
																"");
		header("Location: ../../index.php?mod=publikasi&act=form&nid=".$_POST['no_dosen']."&code=1");
	} 
	
	elseif ($_GET['mod'] == 'publikasi' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
				
		$db->database_prepare("UPDATE as_publikasi_dosen SET	jenis_penelitian = ?,
																hasil_penelitian = ?,
																kode_pengarang = ?,
																media_publikasi = ?,
																penelitian_dilaksanakan_secara = ?,
																jenis_pembiayaan = ?,
																periode_penelitian = ?,
																judul_penelitian = ?,
																kata_kunci = ?,
																abstrak = ?,
																waktu_pelaksanaan_penelitian = ?,
																lokasi_penelitian = ?,
																status_validasi = ?,
																modified_date = ?,
																modified_userid = ?
																WHERE publikasi_id = ?")
													->execute(	$_POST["jenis_penelitian"],
																$_POST["hasil_penelitian"],
																$_POST["pengarang"],
																$_POST["media_publikasi"],
																$_POST["penelitian_dilaksanakan"],
																$_POST["jenis_pembiayaan"],
																$_POST["periode_penelitian"],
																$_POST["judul"],
																$_POST["kata_kunci"],
																$_POST["abstrak"],
																$_POST["waktu_pelaksanaan"],
																$_POST["lokasi_penelitian"],
																$_POST["status_validasi"],
																"",
																"",
																$_POST["id"]);
		header("Location: ../../index.php?mod=publikasi&act=form&nid=".$_POST['no_dosen']."&code=2");
	}

	elseif ($_GET['mod'] == 'publikasi' && $_GET['act'] == 'delete'){
		$db->database_prepare("DELETE FROM as_publikasi_dosen WHERE publikasi_id = ?")->execute($_GET["id"]);
		header("Location: ../../index.php?mod=publikasi&act=form&nid=".$_GET['nid']."&code=3");
	}
}
?>