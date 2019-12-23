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
	if ($_GET['mod'] == 'kurikulum' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		$tgl_mulai_efektif = $_POST['tgl_mulai_efektif'];
		$tgl_akhir_efektif = $_POST['tgl_akhir_efektif'];
		
		$db->database_prepare("INSERT INTO as_kurikulum (	kurikulum,
															aktif,
															tgl_mulai_efektif,
															tgl_akhir_efektif,
															created_date,
															created_userid,
															modified_date,
															modified_userid)
											VALUE	(?,?,?,?,?,?,?,?)")
										->execute(	$_POST["kurikulum"],
													$_POST["aktif"],
													$tgl_mulai_efektif,
													$tgl_akhir_efektif,
													$created_date,
													$_SESSION["userid"],
													"",
													"");
		header("Location: ../../index.php?mod=kurikulum&code=1");
	} 
	
	elseif ($_GET['mod'] == 'kurikulum' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		$tgl_mulai_efektif = $_POST['tgl_mulai_efektif'];
		$tgl_akhir_efektif = $_POST['tgl_akhir_efektif'];
		
		$db->database_prepare("UPDATE as_kurikulum SET	kurikulum = ?,
														aktif = ?,
														tgl_mulai_efektif = ?,
														tgl_akhir_efektif = ?,
														modified_date = ?,
														modified_userid = ?
														WHERE kurikulum_id = ?")
									->execute( 	$_POST["kurikulum"],
												$_POST["aktif"],
												$tgl_mulai_efektif,
												$tgl_akhir_efektif,
												$modified_date,
												$_SESSION["userid"],
												$_POST["id"]);
		header("Location: ../../index.php?mod=kurikulum&code=2");	
	}
	
	elseif ($_GET['mod'] == 'kurikulum' && $_GET['act'] == 'delete'){
		$db->database_prepare("DELETE FROM as_kurikulum WHERE kurikulum_id = ?")->execute($_GET["id"]);
		header("Location: ../../index.php?mod=kurikulum&code=3");
	}
}
?>