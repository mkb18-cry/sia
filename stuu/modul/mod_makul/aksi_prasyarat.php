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
	if ($_GET['mod'] == 'makul_prasyarat' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("INSERT INTO as_makul_prasyarat (	makul_id,
																makul_id_prasyarat,
																bobot_minimal,
																status,
																created_date,
																created_userid,
																modified_date,
																modified_userid)
														VALUES	(?,?,?,?,?,?,?,?)")
													->execute(	$_POST["makul_id"],
																$_POST["makul_id_prasyarat"],
																$_POST["bobot_nilai"],
																$_POST["status"],
																$created_date,
																$_SESSION["userid"],
																"",
																"");
		header("Location: ../../index.php?mod=makul_prasyarat&code=1");
	} 
	
	elseif ($_GET['mod'] == 'makul_prasyarat' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("UPDATE as_makul_prasyarat SET	makul_id = ?,
																makul_id_prasyarat = ?,
																bobot_minimal = ?,
																status = ?,
																modified_date = ?,
																modified_userid = ?
																WHERE prasyarat_id = ?")
													->execute(	$_POST["makul_id"],
																$_POST["makul_id_prasyarat"],
																$_POST["bobot_nilai"],
																$_POST["status"],
																$modified_date,
																$_SESSION["userid"],
																$_POST["id"]);	
														
		header("Location: ../../index.php?mod=makul_prasyarat&code=2");	
	}
	
	elseif ($_GET['mod'] == 'makul_prasyarat' && $_GET['act'] == 'delete'){
		$db->database_prepare("DELETE FROM as_makul_prasyarat WHERE prasyarat_id = ?")->execute($_GET["id"]);
		header("Location: ../../index.php?mod=makul_prasyarat&code=3");
	}
}
?>