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
	if ($_GET['mod'] == 'angkatan' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("INSERT INTO as_angkatan (	tahun_angkatan,
															semester_angkatan,
															aktif,
															created_date,
															created_userid,
															modified_date,
															modified_userid)
											VALUE	(?,?,?,?,?,?,?)")
										->execute(	$_POST["tahun_angkatan"],
													$_POST["semester"],
													$_POST["aktif"],
													$created_date,
													$_SESSION["userid"],
													"",
													"");
		header("Location: ../../index.php?mod=angkatan&code=1");
	} 
	
	elseif ($_GET['mod'] == 'angkatan' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("UPDATE as_angkatan SET	tahun_angkatan = ?,
														semester_angkatan = ?,
														aktif = ?,
														modified_date = ?,
														modified_userid = ?
														WHERE angkatan_id = ?")
									->execute( 	$_POST["tahun_angkatan"],
												$_POST["semester"],
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