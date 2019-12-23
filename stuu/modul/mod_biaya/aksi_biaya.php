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
	if ($_GET['mod'] == 'biaya' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("INSERT INTO as_mst_biaya (	prodi_id,
														angkatan_id,
														keterangan,
														created_date,
														created_userid,
														modified_date,
														modified_userid)
												VALUES( ?,?,?,?,?,?,?)")
											->execute(	$_POST["prodi"],
														$_POST["tahun"],
														$_POST["keterangan"],
														$created_date,
														$_SESSION["userid"],
														"",
														"");
				
		header("Location: ../../index.php?mod=biaya&act=view&proid=".$_POST['prodi']."&code=1");
	} 
	
	elseif ($_GET['mod'] == 'biaya' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("UPDATE as_mst_biaya SET angkatan_id = ?, keterangan = ?, modified_date = ?, modified_userid = ? WHERE mst_biaya_id = ?")
								->execute($_POST["tahun"],$_POST["keterangan"],$modified_date,$_SESSION["userid"],$_POST["id"]);
		
		header("Location: ../../index.php?mod=biaya&act=view&proid=".$_POST['prodi']."&code=2");
	}
	
	elseif ($_GET['mod'] == 'biaya' && $_GET['act'] == 'delete'){
		$db->database_prepare("DELETE FROM as_mst_biaya WHERE mst_biaya_id = ?")->execute($_GET["id"]);
		$db->database_prepare("DELETE FROM as_akun_biaya WHERE mst_biaya_id = ?")->execute($_GET["id"]);
		header("Location: ../../index.php?mod=biaya&act=view&proid=".$_GET['proid']."&code=3");
	}
	
	elseif($_GET['mod'] == 'akun_biaya' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		
		if ($_POST["status"] == 'A'){
			$db->database_prepare("UPDATE as_akun_biaya SET aktif = 'N' WHERE mst_biaya_id = ?")->execute($_POST["mst_biaya_id"]);
			$db->database_prepare("INSERT INTO as_akun_biaya (	mst_biaya_id,
																uang_gedung,
																uang_sks,
																uang_spp,
																program,
																semester,
																aktif,
																created_date,
																created_userid,
																modified_date,
																modified_userid)
														VALUES (?,?,?,?,?,?,?,?,?,?,?)")
													->execute(	$_POST["mst_biaya_id"],
																$_POST["uang_gedung"],
																$_POST["uang_sks"],
																$_POST["uang_spp"],
																$_POST["program"],
																$_POST["semester"],
																$_POST["status"],
																$created_date,
																$_SESSION["userid"],
																"",
																"");
		}
		else{
			$db->database_prepare("INSERT INTO as_akun_biaya (	mst_biaya_id,
																uang_gedung,
																uang_sks,
																uang_spp,
																program,
																semester,
																aktif,
																created_date,
																created_userid,
																modified_date,
																modified_userid)
														VALUES (?,?,?,?,?,?,?,?,?,?,?)")
													->execute(	$_POST["mst_biaya_id"],
																$_POST["uang_gedung"],
																$_POST["uang_sks"],
																$_POST["uang_spp"],
																$_POST["program"],
																$_POST["semester"],
																$_POST["status"],
																$created_date,
																$_SESSION["userid"],
																"",
																"");
		}
		header("Location: ../../index.php?mod=biaya&act=view&proid=".$_POST['proid']."&mstbiayaid=".$_POST['mst_biaya_id']."&code_a=1");													
	}
	
	elseif($_GET['mod'] == 'akun_biaya' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		
		if($_POST["status"] == 'A'){
			$db->database_prepare("UPDATE as_akun_biaya SET aktif = 'N' WHERE mst_biaya_id = ?")->execute($_POST["mst_biaya_id"]);
			$db->database_prepare("UPDATE as_akun_biaya SET uang_gedung = ?,
														uang_sks = ?,
														uang_spp = ?,
														program = ?,
														semester = ?,
														aktif = ?,
														modified_date = ?,
														modified_userid = ?
														WHERE akun_id = ?")
											->execute( 	$_POST["uang_gedung"],
														$_POST["uang_sks"],
														$_POST["uang_spp"],
														$_POST["program"],
														$_POST["semester"],
														$_POST["status"],
														$modified_date,
														$_SESSION["userid"],
														$_POST["id"]);
		}
		else{
			$db->database_prepare("UPDATE as_akun_biaya SET uang_gedung = ?,
														uang_sks = ?,
														uang_spp = ?,
														program = ?,
														semester = ?,
														aktif = ?,
														modified_date = ?,
														modified_userid = ?
														WHERE akun_id = ?")
											->execute( 	$_POST["uang_gedung"],
														$_POST["uang_sks"],
														$_POST["uang_spp"],
														$_POST["program"],
														$_POST["semester"],
														$_POST["status"],
														$modified_date,
														$_SESSION["userid"],
														$_POST["id"]);
		}
		
		header("Location: ../../index.php?mod=biaya&act=view&proid=".$_POST['proid']."&mstbiayaid=".$_POST['mst_biaya_id']."&code_a=2");	
	}
	
	elseif ($_GET['mod'] == 'akun_biaya' && $_GET['act'] == 'delete'){
		$db->database_prepare("DELETE FROM as_akun_biaya WHERE akun_id = ?")->execute($_GET["id"]);
		header("Location: ../../index.php?mod=biaya&act=view&proid=".$_GET['proid']."&mstbiayaid=".$_GET['mstbiayaid']."&code_a=3");
	}
}
?>