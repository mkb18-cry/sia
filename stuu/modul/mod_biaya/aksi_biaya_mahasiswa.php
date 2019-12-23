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
	if ($_GET['mod'] == 'biaya_mahasiswa' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		$db->database_prepare("INSERT INTO as_biaya_kuliah (id_mhs,
															akun_id,
															uang_gedung,
															uang_sks,
															uang_spp,
															keterangan,
															created_date,
															created_userid,
															modified_date,
															modified_userid)
													VALUES( ?,?,?,?,?,?,?,?,?,?)")
												->execute(  $_POST["id_mhs"],
															$_POST["akun_id"],
															$_POST["uang_gedung"],
															$_POST["uang_sks"],
															$_POST["uang_spp"],
															$_POST["keterangan"],
															$created_date,
															$_SESSION["userid"],
															"",
															"");
		
		header("Location: ../../index.php?mod=biaya_mahasiswa&act=biodata&program_studi=".$_POST['prodi']."&nim=".$_POST["nim"]."&code=1");
	} 
	
	elseif ($_GET['mod'] == 'biaya_mahasiswa' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("UPDATE as_biaya_kuliah SET	uang_gedung = ?,
															uang_sks = ?,
															uang_spp = ?,
															keterangan = ?,
															modified_date = ?,
															modified_userid = ?
															WHERE biaya_id = ?")
												->execute(  $_POST["uang_gedung"],
															$_POST["uang_sks"],
															$_POST["uang_spp"],
															$_POST["keterangan"],
															$modified_date,
															$_SESSION["userid"],
															$_POST["id"]);
		
		header("Location: ../../index.php?mod=biaya_mahasiswa&act=biodata&program_studi=".$_POST['prodi']."&nim=".$_POST["nim"]."&code=1");
	}
	
	elseif($_GET['mod'] == 'akun_biaya' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("INSERT INTO as_akun_biaya (	mst_biaya_id,
															nama_biaya,
															pembayaran,
															program,
															jumlah,
															created_date,
															created_userid,
															modified_date,
															modified_userid)
													VALUES (?,?,?,?,?,?,?,?,?)")
												->execute(	$_POST["mst_biaya_id"],
															$_POST["nama_biaya"],
															$_POST["pembayaran"],
															$_POST["program"],
															$_POST["jumlah"],
															$created_date,
															$_SESSION["userid"],
															"",
															"");
		header("Location: ../../index.php?mod=biaya&act=view&proid=".$_POST['proid']."&mstbiayaid=".$_POST['mst_biaya_id']."&code_a=1");													
	}
	
	elseif($_GET['mod'] == 'akun_biaya' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("UPDATE as_akun_biaya SET nama_biaya = ?,
														pembayaran = ?,
														program = ?,
														jumlah = ?,
														modified_date = ?,
														modified_userid = ?
														WHERE akun_id = ?")
											->execute( 	$_POST["nama_biaya"],
														$_POST["pembayaran"],
														$_POST["program"],
														$_POST["jumlah"],
														$modified_date,
														$_SESSION["userid"],
														$_POST["id"]);
		header("Location: ../../index.php?mod=biaya&act=view&proid=".$_POST['proid']."&mstbiayaid=".$_POST['mst_biaya_id']."&code_a=2");	
	}
	
	elseif ($_GET['mod'] == 'akun_biaya' && $_GET['act'] == 'delete'){
		$db->database_prepare("DELETE FROM as_akun_biaya WHERE akun_id = ?")->execute($_GET["id"]);
		header("Location: ../../index.php?mod=biaya&act=view&proid=".$_GET['proid']."&mstbiayaid=".$_GET['mstbiayaid']."&code_a=3");
	}
}
?>