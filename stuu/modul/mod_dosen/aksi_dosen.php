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
	if ($_GET['mod'] == 'dosen' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		$tgl_lahir = $_POST['tgl_lahir'];
		$mulai_masuk_dosen = $_POST['tgl_masuk'];
		$tanggal_keluar_sertifikasi_dosen = $_POST['tgl_sertifikasi'];
		$password = md5(123456);
		
		$db->database_prepare("INSERT INTO msdos (	KDPSTMSDOS,
													KDJENMSDOS,
													NOKTPMSDOS,
													NODOSMSDOS,
													NMDOSMSDOS,
													GELARMSDOS,
													TPLHRMSDOS,
													TGLHRMSDOS,
													KDJEKMSDOS,
													KDJANMSDOS,
													KDPDAMSDOS,
													KDSTAMSDOS,
													STDOSMSDOS,
													MLSEMMSDOS,
													NIPNSMSDOS,
													mulai_masuk_dosen,
													akta_dan_ijin_mengajar,
													Alamat,
													kota,
													propinsi,
													kode_pos,
													negara,
													no_sertifikasi_dosen,
													tanggal_keluar_sertifikasi_dosen,
													NIRA,
													Telepon,
													Hp,
													email,
													foto,
													password,
													last_login,
													ip,
													created_date,
													created_userid,
													modified_date,
													modified_userid)
										VALUES	(	?,?,?,?,?,?,?,?,?,?,
													?,?,?,?,?,?,?,?,?,?,
													?,?,?,?,?,?,?,?,?,?,
													?,?,?,?,?,?)")
										->execute(	$_POST["kdpstmsdos"],
													$_POST["kdjenmsdos"],
													$_POST["noktpmsdos"],
													$_POST["nodosmsdos"],
													$_POST["nmdosmsdos"],
													$_POST["gelarmsdos"],
													$_POST["tplhrmsdos"],
													$tgl_lahir,
													$_POST["kdjekmsdos"],
													$_POST["kdjanmsdos"],
													$_POST["kdpdamsdos"],
													$_POST["kdstamsdos"],
													$_POST["stdosmsdos"],
													$_POST["mlsemmsdos"],
													$_POST["nipnsmsdos"],
													$mulai_masuk_dosen,
													$_POST["akta_ijin"],
													$_POST["alamat"],
													$_POST["kota"],
													$_POST["propinsi"],
													$_POST["kode_pos"],
													$_POST["negara"],
													$_POST["nomor_sertifikasi"],
													$tanggal_keluar_sertifikasi_dosen,
													$_POST["nira"],
													$_POST["telepon"],
													$_POST["hp"],
													$_POST["email"],
													$_POST["filename"],
													$password,
													"",
													"",
													$created_date,
													$_SESSION["userid"],
													"",
													"");
		
		header("Location: ../../index.php?mod=dosen&code=1");
	} 

	elseif($_GET['mod'] == 'dosen' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		$tgl_lahir = $_POST['tgl_lahir'];
		$mulai_masuk_dosen = $_POST['tgl_masuk'];
		$tanggal_keluar_sertifikasi_dosen = $_POST['tgl_sertifikasi'];
		//KDPTIMSDOS = ?,
		//KDPSTMSDOS = ?,
		//KDJENMSDOS = ?,
		$db->database_prepare("UPDATE msdos SET NOKTPMSDOS = ?,
												NMDOSMSDOS = ?,
												GELARMSDOS = ?,
												TPLHRMSDOS = ?,
												TGLHRMSDOS = ?,
												KDJEKMSDOS = ?,
												KDJANMSDOS = ?,
												KDPDAMSDOS = ?,
												KDSTAMSDOS = ?,
												STDOSMSDOS = ?,
												MLSEMMSDOS = ?,
												NIPNSMSDOS = ?,
												mulai_masuk_dosen = ?,
												akta_dan_ijin_mengajar = ?,
												Alamat = ?,
												kota = ?,
												propinsi = ?,
												kode_pos = ?,
												negara = ?,
												no_sertifikasi_dosen = ?,
												tanggal_keluar_sertifikasi_dosen = ?,
												NIRA = ?,
												Telepon = ?,
												Hp = ?,
												email = ?,
												foto = ?,
												modified_date = ?,
												modified_userid = ?
												WHERE IDDOSMSDOS = ?")
									->execute(	$_POST["noktpmsdos"],
												$_POST["nmdosmsdos"],
												$_POST["gelarmsdos"],
												$_POST["tplhrmsdos"],
												$tgl_lahir,
												$_POST["kdjekmsdos"],
												$_POST["kdjanmsdos"],
												$_POST["kdpdamsdos"],
												$_POST["kdstamsdos"],
												$_POST["stdosmsdos"],
												$_POST["mlsemmsdos"],
												$_POST["nipnsmsdos"],
												$mulai_masuk_dosen,
												$_POST["akta_ijin"],
												$_POST["alamat"],
												$_POST["kota"],
												$_POST["propinsi"],
												$_POST["kode_pos"],
												$_POST["negara"],
												$_POST["nomor_sertifikasi"],
												$tanggal_keluar_sertifikasi_dosen,
												$_POST["nira"],
												$_POST["telepon"],
												$_POST["hp"],
												$_POST["email"],
												$_POST["filename"],
												$modified_date,
												$_SESSION["userid"],
												$_POST["id"]);
		header("Location: ../../index.php?mod=dosen&code=2");
	}

	elseif ($_GET['mod'] == 'dosen' && $_GET['act'] == 'delete'){
		$dataimage = $db->database_fetch_array($db->database_prepare("SELECT foto FROM msdos WHERE IDDOSMSDOS = ?")->execute($_GET["id"]));
		if ($dataimage['foto'] != ''){
			$del_image = unlink("../../foto/dosen/".$dataimage['foto']);
		}
		
		$db->database_prepare("DELETE FROM msdos WHERE IDDOSMSDOS = ?")->execute($_GET["id"]);
		header("Location: ../../index.php?mod=dosen&code=3");
	}
}
?>