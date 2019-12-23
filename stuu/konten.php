<?php
error_reporting(0);
session_start();
date_default_timezone_set('Asia/Jakarta');
include "../config/class_database.php";
include "../config/serverconfig.php";
include "../config/debug.php";
include "../fungsi/timezone.php";
include "../fungsi/fungsi_combobox.php";
include "../fungsi/fungsi_date.php";
include "../fungsi/fungsi_rupiah.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
	echo "<meta http-equiv='refresh' content='0; url=../index.php?code=1'>";
}

else{
	if ($_GET['mod'] == 'datapt'){
		include "modul/mod_pt/pt.php";
	}
	
	elseif($_GET['mod'] == 'ruang'){
		include "modul/mod_ruang/ruang.php";
	}
	
	elseif ($_GET['mod'] == 'prodi'){
		include "modul/mod_prodi/prodi.php";
	}
	
	elseif ($_GET['mod'] == 'krs'){
		include "modul/mod_krs/krs.php";
	}
	
	elseif($_GET['mod'] == 'kelas_prodi'){
		include "modul/mod_kelas/kelas.php";
	}
	
	elseif ($_GET['mod'] == 'bagi_kelas'){
		include "modul/mod_kelas/bagi_kelas.php";
	}
	
	elseif ($_GET['mod'] == 'fakultas'){
		include "modul/mod_fakultas/fakultas.php";
	}
	
	elseif($_GET['mod'] == 'jadwal_mata_kuliah'){
		include "modul/mod_jadwal/jadwal.php";
	}
	
	elseif ($_GET['mod'] == 'dosen'){
		include "modul/mod_dosen/dosen.php";
	}
	
	elseif ($_GET['mod'] == 'mhs'){
		include "modul/mod_mhs/mahasiswa.php";
	}
	
	elseif ($_GET['mod'] == 'kurikulum'){
		include "modul/mod_kurikulum/kurikulum.php";
	}
	
	elseif ($_GET['mod'] == 'angkatan'){
		include "modul/mod_angkatan/angkatan.php";
	}
	
	elseif ($_GET['mod'] == 'makul'){
		include "modul/mod_makul/makul.php";
	}
	
	elseif($_GET['mod'] == 'user'){
		include "modul/mod_user/user.php";
	}
	
	elseif ($_GET['mod'] == 'biaya'){
		include "modul/mod_biaya/biaya.php";
	}
	
	elseif ($_GET['mod'] == 'biaya_mahasiswa'){
		include "modul/mod_biaya/biaya_mahasiswa.php";
	}
	
	elseif ($_GET['mod'] == 'kartu_absensi_harian'){
		include "modul/mod_kartu/absensi_harian.php";
	}
	
	elseif ($_GET['mod'] == 'riwayat_pendidikan_dosen'){
		include "modul/mod_riwayat_dosen/riwayat_dosen.php";
	}
	
	elseif ($_GET['mod'] == 'publikasi'){
		include "modul/mod_publikasi/publikasi.php";
	}
	
	elseif ($_GET['mod'] == 'jadwal_dosen'){
		include "modul/mod_jadwal_dosen/jadwal_dosen.php";
	}
	
	elseif ($_GET['mod'] == 'nilai_semester'){
		include "modul/mod_nilai/nilai.php";
	}
	
	elseif ($_GET['mod'] == 'ubah_password'){
		include "modul/mod_user/password.php";
	}
	
	elseif ($_GET['mod'] == 'akun'){
		include "modul/mod_user/akun.php";
	}
	
	elseif ($_GET['mod'] == 'trx_dosen'){
		include "modul/mod_dosen/transaksi_dosen.php";
	}
	
	elseif ($_GET['mod'] == 'trx_mhs'){
		include "modul/mod_mhs/transaksi_mahasiswa.php";
	}
	
	elseif ($_GET['mod'] == 'makul_prasyarat'){
		include "modul/mod_makul/prasyarat.php";
	}
	
	elseif ($_GET['mod'] == 'skripsi'){
		include "modul/mod_skripsi/skripsi.php";
	}
	
	elseif ($_GET['mod'] == 'nilai'){
		include "modul/mod_nilai/data_nilai.php";
	}
	
	elseif ($_GET['mod'] == 'kartu_ujian'){
		include "modul/mod_kartu/kartu_ujian.php";
	}
	
	elseif ($_GET['mod'] == 'kartu_krs'){
		include "modul/mod_krs/kartu_krs.php";
	} 
	
	elseif ($_GET['mod'] == 'kartu_absensi_ujian'){
		include "modul/mod_kartu/absensi_ujian.php";
	}
	
	elseif ($_GET['mod'] == 'bahan_kuliah'){
		include "modul/mod_kuliah/bahan_kuliah.php";
	}
	
	elseif ($_GET['mod'] == 'bahan_kuliah_dosen'){
		include "modul/mod_kuliah/bahan_kuliah_dosen.php";
	}
	
	elseif ($_GET['mod'] == 'transkip_nilai'){
		include "modul/mod_nilai/transkip_nilai.php";
	}
	
	elseif ($_GET['mod'] == 'khs'){
		include "modul/mod_nilai/khs.php";
	}
	
	elseif ($_GET['mod'] == 'rekap_ip'){
		include "modul/mod_nilai/rekap_ip.php";
	} 
	
	elseif ($_GET['mod'] == 'pemimpin'){
		include "modul/mod_pimpinan/pimpinan.php";
	}
	
	elseif ($_GET['mod'] == 'backup_db'){
		include "modul/mod_backup/backup.php";
	}
	
	elseif ($_GET['mod'] == 'lap_rekap_day'){
		include "modul/mod_laporan/rekap_day.php";
	}
	
	elseif ($_GET['mod'] == 'lap_rekap_umum'){
		include "modul/mod_laporan/rekap_umum.php";
	}
	
	elseif ($_GET['mod'] == 'copy_data_semester'){
		include "modul/mod_mahasiswa/copy_semester.php";
	}
	
	elseif ($_GET['mod'] == 'epsbed'){
		include "modul/mod_epsbed/epsbed.php";
	}
	
	else{
		if ($_GET['code'] == 1){
			echo "
				<div class='message success'>
					<h5>Success!</h5>
					<p>Anda berhasil Login.</p>
				</div>";
		}
		echo "<p><b>$_SESSION[nama_lengkap]</b>, Selamat datang di Sistem Informasi Manajemen, Anda dapat mengolah konten melalui menu di sisi kiri.<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
		Informasi Login:
		Tanggal : $_SESSION[last_login] <br>
		IP : $_SESSION[ip] 
		</p>";
	}
}
?>