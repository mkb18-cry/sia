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
	if ($_GET['mod'] == 'pemimpin' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("INSERT INTO as_pimpinan (	tahun,
															kode_pt,
															ketua_yayasan,
															sekretaris_yayasan,
															bendahara_yayasan,
															rektor,
															pembantu1,
															pembantu2,
															pembantu3,
															created_date,
															created_userid,
															modified_date,
															modified_userid)
													VALUE(	?,?,?,?,?,?,?,?,?,?,?,?,?)")
												->execute(	$_POST["tahun"],
															$_POST["kode_pt"],
															$_POST["ketua_yayasan"],
															$_POST["sekretaris_yayasan"],
															$_POST["bendahara_yayasan"],
															$_POST["rektor"],
															$_POST["pembantu1"],
															$_POST["pembantu2"],
															$_POST["pembantu3"],
															$created_date,
															$_SESSION["userid"],
															"",
															"");
		header("Location: ../../index.php?mod=pemimpin&code=1");
	} 
	
	elseif ($_GET['mod'] == 'pemimpin' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("UPDATE as_pimpinan SET 	tahun = ?,
														kode_pt = ?,
														ketua_yayasan = ?,
														sekretaris_yayasan = ?,
														bendahara_yayasan = ?,
														rektor = ?,
														pembantu1 = ?,
														pembantu2 = ?,
														pembantu3 = ?,
														modified_date = ?,
														modified_userid = ?
														WHERE pimpinan_id = ?")
											->execute(	$_POST["tahun"],
														$_POST["kode_pt"],
														$_POST["ketua_yayasan"],
														$_POST["sekretaris_yayasan"],
														$_POST["bendahara_yayasan"],
														$_POST["rektor"],
														$_POST["pembantu1"],
														$_POST["pembantu2"],
														$_POST["pembantu3"],
														$modified_date,
														$_SESSION["userid"],
														$_POST["id"]);
		header("Location: ../../index.php?mod=pemimpin&code=2");	
	}
	
	elseif ($_GET['mod'] == 'pemimpin' && $_GET['act'] == 'delete'){
		$db->database_prepare("DELETE FROM as_pimpinan WHERE pimpinan_id = ?")->execute($_GET["id"]);
		header("Location: ../../index.php?mod=pemimpin&code=3");
	}
}
?>