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
	if ($_GET['mod'] == 'krs' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		
		foreach($_POST['ambil'] AS $ambil){
			$db->database_prepare("INSERT INTO as_krs (	id_mhs,
													jadwal_id,
													created_date,
													created_userid,
													modified_date,
													modified_userid)
												VALUES(?,?,?,?,?,?)")
											->execute(	$_POST["id_mhs"],
														$ambil,
														$created_date,
														$_SESSION["userid"],
														"",
														"");			
		}
																	
		header("Location: ../../index.php?mod=krs&act=krs_detail&id_mhs=".$_POST['id_mhs']."&kelas_id=".$_POST['kelas_id']."&semester=".$_POST['semester']."&code=1");
	} 

	elseif ($_GET['mod'] == 'krs' && $_GET['act'] == 'delete'){
		$db->database_prepare("DELETE FROM as_krs WHERE krs_id = ?")->execute($_GET["id"]);
		header("Location: ../../index.php?mod=krs&act=krs_detail&id_mhs=".$_GET['id_mhs']."&kelas_id=".$_GET['kelas_id']."&semester=".$_GET['semester']."&code=3");
	}
}
?>