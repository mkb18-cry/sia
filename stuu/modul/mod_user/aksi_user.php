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
	if ($_GET['mod'] == 'user' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		$password = md5("123456");
		
		$db->database_prepare("INSERT INTO as_users (	nip,
														nama_lengkap,
														nama_panggil,
														alamat,
														level,
														level_jabatan,
														jenis_kelamin,
														telepon,
														hp,
														email,
														password,
														aktif,
														blokir,
														created_date,
														created_userid,
														modified_date,
														modified_userid,
														last_login,
														ip)
										VALUES	(	?,?,?,?,?,?,?,?,?,?,
													?,?,?,?,?,?,?,?,?)")
										->execute(	$_POST["nip"],
													$_POST["nama_lengkap"],
													$_POST["nama_panggil"],
													$_POST["alamat"],
													$_POST["level"],
													$_POST["level_jabatan"],
													$_POST["jenis_kelamin"],
													$_POST["telepon"],
													$_POST["hp"],
													$_POST["email"],
													$password,
													$_POST["aktif"],
													$_POST["blokir"],
													$created_date,
													$_SESSION["userid"],
													"",
													"",
													"",
													"");
		
		header("Location: ../../index.php?mod=user&code=1");
	} 

	elseif($_GET['mod'] == 'user' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("UPDATE as_users SET 	nip = ?,
													nama_lengkap = ?,
													nama_panggil = ?,
													alamat = ?,
													level = ?,
													level_jabatan = ?,
													jenis_kelamin = ?,
													telepon = ?,
													hp = ?,
													email = ?,
													aktif = ?,
													blokir = ?,
													modified_date = ?,
													modified_userid = ?
													WHERE user_id = ?")
										->execute(	$_POST["nip"],
													$_POST["nama_lengkap"],
													$_POST["nama_panggil"],
													$_POST["alamat"],
													$_POST["level"],
													$_POST["level_jabatan"],
													$_POST["jenis_kelamin"],
													$_POST["telepon"],
													$_POST["hp"],
													$_POST["email"],
													$_POST["aktif"],
													$_POST["blokir"],
													$modified_date,
													$_SESSION["userid"],
													$_POST["id"]);
		
		header("Location: ../../index.php?mod=user&code=2");
	}

	elseif ($_GET['mod'] == 'user' && $_GET['act'] == 'delete'){
		$db->database_prepare("DELETE FROM as_users WHERE user_id = ?")->execute($_GET["id"]);
		header("Location: ../../index.php?mod=user&code=3");
	}
}
?>