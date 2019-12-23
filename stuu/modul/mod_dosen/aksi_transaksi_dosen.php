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
	if ($_GET['mod'] == 'trx_dosen' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("INSERT INTO as_transaksi_dosen (	dosen_id,
																status_transaksi,
																periode_awal,
																periode_akhir,
																keterangan,
																created_date,
																created_userid,
																modified_date,
																modified_userid)
														VALUES(?,?,?,?,?,?,?,?,?)")
													->execute(	$_POST["nid"],
																$_POST["transaksi"],
																$_POST["periode_awal"],
																$_POST["periode_akhir"],
																$_POST["keterangan"],
																$created_date,
																$_SESSION["userid"],
																"",
																"");
		$db->database_prepare("UPDATE msdos SET STDOSMSDOS = ? WHERE IDDOSMSDOS = ?")->execute($_POST["transaksi"],$_POST["nid"]);
		header("Location: ../../index.php?mod=trx_dosen&code=1");
	}
	
	elseif ($_GET['mod'] == 'trx_dosen' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("UPDATE as_transaksi_dosen SET 	status_transaksi = ?, 
																periode_awal = ?,
																periode_akhir = ?,
																keterangan = ?,
																modified_date = ?,
																modified_userid = ?
																WHERE trx_id = ?")
													->execute(	$_POST["transaksi"],
																$_POST["periode_awal"],
																$_POST["periode_akhir"],
																$_POST["keterangan"],
																$modified_date,
																$_SESSION["userid"],
																$_POST["id"]);
		$db->database_prepare("UPDATE msdos SET STDOSMSDOS = ? WHERE IDDOSMSDOS = ?")->execute($_POST["transaksi"],$_POST["dosen_id"]);
		header("Location: ../../index.php?mod=trx_dosen&code=2");
	}
	
	elseif ($_GET['mod'] == 'trx_dosen' && $_GET['act'] == 'delete'){
		$data_trx = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_transaksi_dosen WHERE trx_id = ?")->execute($_GET["id"]));
		$db->database_prepare("UPDATE msdos SET STDOSMSDOS = 'A' WHERE IDDOSMSDOS = ?")->execute($data_trx['dosen_id']);
		$db->database_prepare("DELEtE FROM as_transaksi_dosen WHERE trx_id = ?")->execute($_GET["id"]);
		header("Location: ../../index.php?mod=trx_dosen&code=3");
	}
}
?>