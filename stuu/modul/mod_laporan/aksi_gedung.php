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
	if ($_GET['mod'] == 'keu_gdg' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("INSERT INTO as_transaksi_bayar (	id_mhs,
																akun_id,
																uang_gedung,
																uang_sks,
																uang_spp,
																keterangan,
																created_date,
																created_userid,
																modified_date,
																modified_userid)
													VALUE	(?,?,?,?,?,?,?,?,?,?)")
													->execute(	$_POST["id_mhs"],
																$_POST["akun_id"],
																$_POST["total_bayar"],
																"",
																"",
																$_POST["keterangan"],
																$created_date,
																$_SESSION["userid"],
																"",
																"");
		$trx_id = mysql_insert_id();
		header("Location: ../../index.php?mod=keu_gdg&act=finish&sem=".$_POST['semester']."&ak_id=".$_POST['akun_id']."&id_mhs=".$_POST['id_mhs']."&nim=".$_POST['nim']."&trx_id=".$trx_id."&code=1");
	} 
	
	elseif ($_GET['mod'] == 'angkatan' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("UPDATE as_angkatan SET	semester = ?,
														tahun_angkatan = ?,
														aktif = ?,
														modified_date = ?,
														modified_userid = ?
														WHERE angkatan_id = ?")
									->execute( 	$_POST["semester"],
												$_POST["tahun_angkatan"],
												$_POST["aktif"],
												$modified_date,
												$_SESSION["userid"],
												$_POST["id"]);
		header("Location: ../../index.php?mod=angkatan&code=2");	
	}
	
	elseif ($_GET['mod'] == 'angkatan' && $_GET['act'] == 'delete'){
		$db->database_prepare("DELETE FROM as_angkatan WHERE angkatan_id = ?")->execute($_GET["id"]);
		header("Location: ../../index.php?mod=angkatan&code=3");
	}
}
?>