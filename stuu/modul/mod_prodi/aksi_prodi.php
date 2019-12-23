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
	if ($_GET['mod'] == 'prodi' && $_GET['act'] == 'input'){
		$tanggal_sk_dikti = $_POST['tgl_sk_dikti'];
		$tanggal_sk_laku = $_POST['tgl_sk_laku'];
		$tanggal_awal = $_POST['tgl_awal'];
		$tanggal_akreditasi = $_POST['tgl_akreditasi'];
		$tanggal_laku = $_POST['tgl_laku'];
		$created_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("INSERT INTO mspst (	KDPSTMSPST,
													KDJENMSPST,
													NMPSTMSPST,
													SMAWLMSPST,
													NOMSKMSPST,
													TGLSKMSPST,
													TGLAKMSPST,
													SKSTTMSPST,
													STATUMSPST,
													MLSEMMSPST,
													EMAILMSPST,
													TGAWLMSPST,
													NOMBAMSPST,
													TGLBAMSPST,
													TGLABMSPST,
													KDSTAMSPST,
													KDFREMSPST,
													KDPELMSPST,
													NOKPSMSPST,
													TELPSMSPST,
													TELPOMSPST,
													FAKSIMSPST,
													NMOPRMSPST,
													TELPRMSPST,
													fakultas_id,
													nama_jurusan,
													created_date,
													created_userid,
													modified_date,
													modified_userid)
											VALUE	(?,?,?,?,?,?,?,?,?,?,
													 ?,?,?,?,?,?,?,?,?,?,
													 ?,?,?,?,?,?,?,?,?,?)")
										->execute(	$_POST["kdpstmspst"],
													$_POST["kdjenmspst"],
													$_POST["nmpstmspst"],
													$_POST["smawlmspst"],
													$_POST["nomskmspst"],
													$tanggal_sk_dikti,
													$tanggal_sk_laku,
													$_POST["sksttmspst"],
													$_POST["statumspst"],
													$_POST["mlsemmspst"],
													$_POST["emailmspst"],
													$tanggal_awal,
													$_POST["nombamspst"],
													$tanggal_akreditasi,
													$tanggal_laku,
													$_POST["kdstamspst"],
													$_POST["kdfremspst"],
													$_POST["kdpelmspst"],
													$_POST["nokpsmspst"],
													$_POST["telpsmspst"],
													$_POST["telpomspst"],
													$_POST["faksimspst"],
													$_POST["nmoprmspst"],
													$_POST["telprmspst"],
													$_POST["fakultas_id"],
													$_POST["nama_jurusan"],
													$created_date,
													$_SESSION["userid"],
													"",
													"");
		header("Location: ../../index.php?mod=prodi&code=1");
	} 

	elseif($_GET['mod'] == 'prodi' && $_GET['act'] == 'update'){
		$tanggal_sk_dikti = $_POST['tgl_sk_dikti'];
		$tanggal_sk_laku = $_POST['tgl_sk_laku'];
		$tanggal_awal = $_POST['tgl_awal'];
		$tanggal_akreditasi = $_POST['tgl_akreditasi'];
		$tanggal_laku = $_POST['tgl_laku'];
		$modified_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("UPDATE mspst SET	KDPSTMSPST = ?,
												KDJENMSPST = ?,
												NMPSTMSPST = ?,
												SMAWLMSPST = ?,
												NOMSKMSPST = ?,
												TGLSKMSPST = ?,
												TGLAKMSPST = ?,
												SKSTTMSPST = ?,
												STATUMSPST = ?,
												MLSEMMSPST = ?,
												EMAILMSPST = ?,
												TGAWLMSPST = ?,
												NOMBAMSPST = ?,
												TGLBAMSPST = ?,
												TGLABMSPST = ?,
												KDSTAMSPST = ?,
												KDFREMSPST = ?,
												KDPELMSPST = ?,
												NOKPSMSPST = ?,
												TELPSMSPST = ?,
												TELPOMSPST = ?,
												FAKSIMSPST = ?,
												NMOPRMSPST = ?,
												TELPRMSPST = ?,
												fakultas_id = ?,
												nama_jurusan = ?,
												modified_date = ?,
												modified_userid = ?
												WHERE IDPSTMSPST = ?")
									->execute(	$_POST["kdpstmspst"],
												$_POST["kdjenmspst"],
												$_POST["nmpstmspst"],
												$_POST["smawlmspst"],
												$_POST["nomskmspst"],
												$tanggal_sk_dikti,
												$tanggal_sk_laku,
												$_POST["sksttmspst"],
												$_POST["statumspst"],
												$_POST["mlsemmspst"],
												$_POST["emailmspst"],
												$tanggal_awal,
												$_POST["nombamspst"],
												$tanggal_akreditasi,
												$tanggal_laku,
												$_POST["kdstamspst"],
												$_POST["kdfremspst"],
												$_POST["kdpelmspst"],
												$_POST["nokpsmspst"],
												$_POST["telpsmspst"],
												$_POST["telpomspst"],
												$_POST["faksimspst"],
												$_POST["nmoprmspst"],
												$_POST["telprmspst"],
												$_POST["fakultas_id"],
												$_POST["nama_jurusan"],
												$modified_date,
												$_SESSION["userid"],
												$_POST["id"]);
		header("Location: ../../index.php?mod=prodi&code=2");
	}

	elseif ($_GET['mod'] == 'prodi' && $_GET['act'] == 'delete'){
		$db->database_prepare("DELETE FROM mspst WHERE IDPSTMSPST = ?")->execute($_GET["id"]);
		header("Location: ../../index.php?mod=prodi&code=3");
	}
}
?>