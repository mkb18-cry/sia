<?php
session_start();
//error_reporting(0);

include "config/class_database.php";
include "config/serverconfig.php";
include "config/debug.php";

$username = $_POST['username'];
$password = md5($_POST['password']);

if ($_POST["dosen"] == 1){
	//$sql = $db->database_prepare("SELECT * FROM msdos WHERE email = ? AND password = ? AND STDOSMSDOS = 'A'")->execute($username,$password);
    $sql = $db->database_prepare("SELECT * FROM msdos WHERE email ='$username' AND password ='$password' AND STDOSMSDOS = 'A'")->execute($username,$password);
}
else{
	$sql = $db->database_prepare("SELECT * FROM as_users WHERE email = ? AND password = ? AND aktif = 'Y' AND blokir = 'N'")->execute($username,$password);
}
$nums = $db->database_num_rows($sql);

$data = $db->database_fetch_array($sql);

if ($nums > 0){
	$last_login = date('Y-m-d H:i:s');
	
	if ($_POST['dosen'] == 1){
		$_SESSION['nama_lengkap'] = $data['NMDOSMSDOS']." ".$data['GELARMSDOS'];
		$_SESSION['username'] = $data['email'];
		$_SESSION['password'] = $data['password'];
		$_SESSION['userid'] = $data['NODOSMSDOS'];
		$_SESSION['useri'] = $data['IDDOSMSDOS'];
		$_SESSION['level'] = "dos";
		$_SESSION['last_login'] = date('Y-m-d H:i:s');
		$_SESSION['ip'] = $_SERVER["REMOTE_ADDR"];
		$_SESSION['aktif'] = $data['STDOSMSDOS'];
		$db->database_prepare("UPDATE msdos SET last_login = ?, ip = ? WHERE IDDOSMSDOS = ?")->execute($last_login,$_SERVER["REMOTE_ADDR"],$data["IDDOSMSDOS"]);
	}
	elseif ($data['level'] == '2'){
		header("Location: index.php?code=1");
	}
	else{
		$_SESSION['username'] = $data['email'];
		$_SESSION['password'] = $data['password'];
		$_SESSION['userid'] = $data['user_id'];
		$_SESSION['level'] = $data['level'];
		$_SESSION['nama_lengkap'] = $data['nama_lengkap'];
		$_SESSION['nama_panggil'] = $data['nama_panggil'];
		$_SESSION['aktif'] = $data['aktif'];
		$_SESSION['blokir'] = $data['blokir'];
		$_SESSION['last_login'] = date('Y-m-d H:i:s');
		$_SESSION['ip'] = $_SERVER["REMOTE_ADDR"];
		$db->database_prepare("UPDATE as_users SET last_login = ?, ip = ? WHERE user_id = ?")->execute($last_login,$_SERVER["REMOTE_ADDR"],$data["user_id"]);
	}
	
	header("Location: stuu/index.php?code=1");
}
else{
	header("Location: index.php?code=1");
}
?>