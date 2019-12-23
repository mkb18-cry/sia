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
	if ($_GET['mod'] == 'trx_mhs' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		
		$sql_mhs = $db->database_prepare("SELECT * FROM as_mahasiswa WHERE NIM = ?")->execute($_POST["nim"]);
		$nums = $db->database_num_rows($sql_mhs);
		$data_mhs = $db->database_fetch_array($sql_mhs);
		
		$nums_trx = $db->database_num_rows($db->database_prepare("SELECT * FROM as_transaksi_mhs WHERE id_mhs = ?")->execute($data_mhs["id_mhs"]));
		if ($nums == 0){
			header("Location: ../../index.php?mod=trx_mhs&act=add&code=4");
		}
		/*elseif ($nums_trx > 0){
			header("Location: ../../index.php?mod=trx_mhs&code=5");
		}*/
		else{
			if ($nums_trx > 0){
				$db->database_prepare("DELETE FROM as_transaksi_mhs WHERE id_mhs = ?")->execute($data_mhs["id_mhs"]);
			}
			
			$db->database_prepare("INSERT INTO as_transaksi_mhs (	id_mhs,
																	status_transaksi,
																	periode_awal,
																	periode_akhir,
																	keterangan,
																	created_date,
																	created_userid,
																	modified_date,
																	modified_userid)
															VALUES(?,?,?,?,?,?,?,?,?)")
														->execute(	$data_mhs["id_mhs"],
																	$_POST["transaksi"],
																	$_POST["periode_awal"],
																	$_POST["periode_akhir"],
																	$_POST["keterangan"],
																	$created_date,
																	$_SESSION["userid"],
																	"",
																	"");
			$db->database_prepare("UPDATE as_mahasiswa SET 	status_mahasiswa = ?,
															nilun = ?,
															semester_lulus = ?,
															tahun_lulus = ?,
															tanggal_lulus = ?,
															nomor_sk_yudisium = ?,
															tanggal_sk_yudisium = ?,
															judul_skripsi = ?,
															jalur_skripsi = ?,
															penyusunan_skripsi = ?,
															awal_bimbingan = ?,
															akhir_bimbingan = ?,
															nomor_seri_ijazah = ?,
															NIDN_kopromotor1 = ?,
															NIDN_kopromotor2 = ?,
															NIDN_kopromotor3 = ?,
															NIDN_kopromotor4 = ? 
															WHERE id_mhs = ?")
												->execute(	$_POST["transaksi"],
															$_POST["nilun"],
															$_POST["semester_lulus"],
															$_POST["tahun_lulus"],
															$_POST["tgl_lulus"],
															$_POST["no_sk_yudisium"],
															$_POST["tgl_yudisium"],
															$_POST["judul_skripsi"],
															$_POST["jalur_skripsi"],
															$_POST["penyusunan_skripsi"],
															$_POST["awal_bimbingan"],
															$_POST["akhir_bimbingan"],
															$_POST["no_seri_ijazah"],
															$_POST["nidn_promotor1"],
															$_POST["nidn_promotor2"],
															$_POST["nidn_promotor3"],
															$_POST["nidn_promotor4"],
															$data_mhs["id_mhs"]);
			header("Location: ../../index.php?mod=trx_mhs&code=1");
		}
	}
	
	elseif ($_GET['mod'] == 'trx_mhs' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		
		$db->database_prepare("UPDATE as_transaksi_mhs SET 	status_transaksi = ?, 
															periode_awal = ?,
															periode_akhir = ?,
															keterangan = ?,
															modified_date = ?,
															modified_userid = ?
															WHERE trx_id = ?")
												->execute(	$_POST["transaksi"],
															$_POST["periode_awal"],
															$_POST["periode_akhir"],
															$_POST["keterangan"],
															$modified_date,
															$_SESSION["userid"],
															$_POST["id"]);
			$db->database_prepare("UPDATE as_mahasiswa SET 	status_mahasiswa = ?,
															nilun = ?,
															semester_lulus = ?,
															tahun_lulus = ?,
															tanggal_lulus = ?,
															nomor_sk_yudisium = ?,
															tanggal_sk_yudisium = ?,
															judul_skripsi = ?,
															jalur_skripsi = ?,
															penyusunan_skripsi = ?,
															awal_bimbingan = ?,
															akhir_bimbingan = ?,
															nomor_seri_ijazah = ?,
															NIDN_kopromotor1 = ?,
															NIDN_kopromotor2 = ?,
															NIDN_kopromotor3 = ?,
															NIDN_kopromotor4 = ? 
															WHERE id_mhs = ?")
												->execute(	$_POST["transaksi"],
															$_POST["nilun"],
															$_POST["semester_lulus"],
															$_POST["tahun_lulus"],
															$_POST["tgl_lulus"],
															$_POST["no_sk_yudisium"],
															$_POST["tgl_yudisium"],
															$_POST["judul_skripsi"],
															$_POST["jalur_skripsi"],
															$_POST["penyusunan_skripsi"],
															$_POST["awal_bimbingan"],
															$_POST["akhir_bimbingan"],
															$_POST["no_seri_ijazah"],
															$_POST["nidn_promotor1"],
															$_POST["nidn_promotor2"],
															$_POST["nidn_promotor3"],
															$_POST["nidn_promotor4"],
															$_POST["id_mhs"]);
		header("Location: ../../index.php?mod=trx_mhs&code=2");
	}
	
	elseif ($_GET['mod'] == 'trx_mhs' && $_GET['act'] == 'delete'){
		$data_trx = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_transaksi_mhs WHERE trx_id = ?")->execute($_GET["id"]));
		$db->database_prepare("UPDATE as_mahasiswa SET 	status_mahasiswa = 'A',
														nilun = '',
														semester_lulus = '',
														tahun_lulus = '',
														tanggal_lulus = '',
														nomor_sk_yudisium = '',
														tanggal_sk_yudisium = '',
														judul_skripsi = '',
														jalur_skripsi = '',
														penyusunan_skripsi = '',
														awal_bimbingan = '',
														akhir_bimbingan = '',
														nomor_seri_ijazah = '',
														NIDN_kopromotor1 = '',
														NIDN_kopromotor2 = '',
														NIDN_kopromotor3 = '',
														NIDN_kopromotor4 = '' WHERE id_mhs = ?")->execute($data_trx['id_mhs']);
		$db->database_prepare("DELEtE FROM as_transaksi_mhs WHERE trx_id = ?")->execute($_GET["id"]);
		header("Location: ../../index.php?mod=trx_mhs&code=3");
	}
}
?>