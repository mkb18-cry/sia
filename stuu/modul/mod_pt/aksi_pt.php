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
	if ($_GET['tab'] == 1){
		$modified_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("UPDATE msyys SET	KDYYSMSYYS = ?,
												NMYYSMSYYS = ?,
												ALMT1MSYYS = ?,
												ALMT2MSYYS = ?,
												KOTAAMSYYS = ?,
												KDPOSMSYYS = ?,
												TELPOMSYYS = ?,
												FAKSIMSYYS = ?,
												TGYYSMSYYS = ?,
												NOMSKMSYYS = ?,
												TGLBNMSYYS = ?,
												NOMBNMSYYS = ?,
												EMAILMSYYS = ?,
												HPAGEMSYYS = ?,
												TGLAWLMSYYS = ?,
												modified_date = ?,
												modified_userid = ?
												WHERE IDYYSMSYYS = 1")
									->execute(	$_POST["kdyysmsyys"],
												$_POST["nmyysmsyys"],
												$_POST["almt1msyys"],
												$_POST["almt2msyys"],
												$_POST["kotaamsyys"],
												$_POST["kdposmsyys"],
												$_POST["telpomsyys"],
												$_POST["faksimsyys"],
												$_POST["tanggal_akta"],
												$_POST["nomskmsyys"],
												$_POST["tanggal_sah"],
												$_POST["nombnmsyys"],
												$_POST["emailmsyys"],
												$_POST["hpagemsyys"],
												$_POST["tanggal_pendirian"],
												$modified_date,
												$_SESSION['userid']);
		header("Location: ../../index.php?mod=datapt&code=1");
	}
	
	else{
		$modified_date = date('Y-m-d H:i:s');
		$tanggal_akta = $_POST['tanggal_akta'];
		$tanggal_pendirian = $_POST['tanggal_pendirian'];
		
		$db->database_prepare("UPDATE mspti SET KDYYSMSPTI = ?,
												KDPTIMSPTI = ?,
												NMPTIMSPTI = ?,
												ALMT1MSPTI = ?,
												ALMT2MSPTI = ?,
												KOTAAMSPTI = ?,
												KDPOSMSPTI = ?,
												TELPOMSPTI = ?,
												FAKSIMSPTI = ?,
												TGPTIMSPTI = ?,
												NOMSKMSPTI = ?,
												EMAILMSPTI = ?,
												HPAGEMSPTI = ?,
												TGAWLMSPTI = ?,
												modified_date = ?,
												modified_userid = ?
												WHERE IDYYSMSPTI = 1")
									->execute(	$_POST["kdyysmspti"],
												$_POST["kdptimspti"],
												$_POST["nmptimspti"],
												$_POST["almt1mspti"],
												$_POST["almt2mspti"],
												$_POST["kotaamspti"],
												$_POST["kdposmspti"],
												$_POST["telpomspti"],
												$_POST["faksimspti"],
												$tanggal_akta,
												$_POST["nomskmspti"],
												$_POST["emailmspti"],
												$_POST["hpagemspti"],
												$tanggal_pendirian,
												$modified_date,
												$_SESSION['userid']);
		header("Location: ../../index.php?mod=datapt&code=1");
	}
}
?>