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
	if ($_GET['mod'] == 'ruang' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("INSERT INTO as_ruang (	kode_ruang,
														nama_ruang,
														jenis,
														aktif,
														created_date,
														created_userid,
														modified_date,
														modified_userid,
														head_id)
											VALUE	(?,?,?,?,?,?,?,?,?)")
										->execute(	$_POST["kode_ruang"],
													$_POST["nama_ruang"],
													$_POST["jenis"],
													$_POST["status"],
													$created_date,
													$_SESSION["userid"],
													"",
													"",
													$_POST["head_id"]);
		header("Location: ../../index.php?mod=ruang&code=1");
	} 
	
	elseif ($_GET['mod'] == 'ruang' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("UPDATE as_ruang SET	nama_ruang = ?,
													jenis = ?,
													aktif = ?,
													modified_date = ?,
													modified_userid = ?,
													head_id = ?
												WHERE ruang_id = ?")
									->execute(	$_POST["nama_ruang"],
												$_POST["jenis"],
												$_POST["status"],
												$modified_date,
												$_SESSION["userid"],
												$_POST["head_id"],
												$_POST["id"]);
		header("Location: ../../index.php?mod=ruang&code=2");	
	}
	
	elseif ($_GET['mod'] == 'ruang' && $_GET['act'] == 'delete'){
		$db->database_prepare("DELETE FROM as_ruang WHERE ruang_id = ?")->execute($_GET["id"]);
		header("Location: ../../index.php?mod=ruang&code=3");
	}
}
?>