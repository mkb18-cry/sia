<?php
if ($_SESSION["level"] == 1){
?>
	<div class="grid_2">
		<div class="box sidemenu">
			<div class="block" id="section-menu">
				<ul class="section menu">
					<li><a class="menuitem">Manajemen Sistem</a>
						<ul class="submenu">
							<li><a href="?mod=datapt">Data Badan Hukum dan PT</a></li>
							<li><a href="?mod=user">Pengguna</a></li>
							<li><a href="?mod=backup_db">Backup Database</a></li>
						</ul>
					</li>
					<li><a class="menuitem">Master Data</a>
						<ul class="submenu">
							<li><a href="?mod=fakultas">Fakultas</a></li>
							<li><a href="?mod=prodi">Program Studi</a></li>
							<li><a href="?mod=kurikulum">Kurikulum</a></li>
							<li><a href="?mod=angkatan">Tahun Angkatan</a></li>
							<li><a href="?mod=kelas_prodi">Kelas per Jurusan</a></li>
							<li><a href="?mod=ruang">Ruang Kelas</a></li>
						</ul>
					</li>
					<li><a class="menuitem">Data Mahasiswa</a>
						<ul class="submenu">
							<li><a href="?mod=mhs">Mahasiswa</a></li>
							<li><a href="?mod=bagi_kelas">Pembagian Kelas Mahasiswa</a></li>
							<!--<li ><a href="404.html">Aktivitas Kuliah</a></li>-->
							<li><a href="?mod=nilai_semester">Nilai Semester</a></li>
							<li><a href="?mod=trx_mhs">Transaksi Mahasiswa</a></li>
							<li><a href="?mod=skripsi">Skripsi</a></li>
							<!--<li><a href="?mod=copy_data_semester">Copy Data Semester</a></li>-->
							<!--<li ><a href="503.html">Pindahan</a></li>
							<li ><a href="503.html">Riwayat Pendidikan untuk S3</a></li>-->
						</ul>
					</li>
					<li><a class="menuitem">Data Dosen</a>
						<ul class="submenu">
							<li><a href="?mod=dosen">Dosen</a></li>
							<li><a href="?mod=riwayat_pendidikan_dosen">Riwayat Pendidikan</a></li>
							<li><a href="?mod=publikasi">Pengelolaan Publikasi</a></li>
							<li><a href="?mod=jadwal_dosen">Jadwal Dosen</a></li>
							<li><a href="?mod=trx_dosen">Transaksi Dosen</a></li>
						</ul>
					</li>
					<li><a class="menuitem">Kurikulum</a>
						<ul class="submenu">
							<li><a href="?mod=makul">Data Master Matakuliah</a></li>
							<!--<li ><a href="404.html">Data DIKTI/Kurikulum</a></li>-->
							<li><a href="?mod=jadwal_mata_kuliah">Penjadwalan Mata Kuliah</a></li>
							<li><a href="?mod=krs">KRS Online dan Pengambilan Mata Kuliah</a></li>
							<li><a href="?mod=makul_prasyarat">Matakuliah Prasyarat</a></li>
							<li><a href="?mod=bahan_kuliah">Bahan Kuliah dan Tugas Kuliah</a></li>
						</ul>
					</li>
					<li><a class="menuitem">Data Nilai</a>
						<ul class="submenu">
							<li><a href="?mod=nilai">Data Nilai Mahasiswa</a></li>
							<li><a href="?mod=transkip_nilai">Transkip Nilai</a></li>
							<li><a href="?mod=khs">Kartu Hasil Studi</a></li>
							<!--<li><a href="?mod=rekap_ip">Rekap IPK dan IP Semester</a></li>-->
						</ul>
					</li>
					<li><a class="menuitem">Cetak Kartu</a>
						<ul class="submenu">
							<li><a href="?mod=kartu_krs">KRS</a></li>
							<li><a href="?mod=kartu_ujian">Kartu Ujian</a></li>
							<li><a href="?mod=kartu_absensi_ujian">Absensi Ujian</a></li>
							<li><a href="?mod=kartu_absensi_harian">Absensi Harian</a></li>
						</ul>
					</li>
					<li><a class="menuitem">Master Biaya</a>
						<ul class="submenu">
							<li><a href="?mod=biaya">Master Akun Biaya</a></li>
							<li><a href="?mod=biaya_mahasiswa">Pembiayaan Mahasiswa</a></li>
						</ul>
					</li>
					<li><a class="menuitem">Transaksi Lainnya</a>
						<ul class="submenu">
							<!--<li><a href="?mod=fasilitas_pt">Fasilitas Perguran Tinggi</a></li>-->
							<li><a href="?mod=pemimpin">Nama Pemimpin dan Tenaga Non Akademik</a></li>
							<li><a href="?mod=epsbed">Laporan Akademik</a></li>
							<!--<li><a href="?mod=kepemilikan_lab">Kepemilikan Laboratorium</a></li>-->
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
<?php
}

elseif ($_SESSION["level"] == 'dos'){
?>
	<div class="grid_2">
		<div class="box sidemenu">
			<div class="block" id="section-menu">
				<ul class="section menu">
					<li><a class="menuitem">Data Mahasiswa</a>
						<ul class="submenu">
							<li><a href="?mod=nilai_semester">Nilai Semester</a></li>
							<li><a href="?mod=skripsi">Skripsi</a></li>
						</ul>
					</li>
					<li><a class="menuitem">Kurikulum</a>
						<ul class="submenu">
							<li><a href="?mod=bahan_kuliah_dosen">Bahan Kuliah dan Tugas Kuliah</a></li>
						</ul>
					</li>
					<li><a class="menuitem">Cetak Kartu</a>
						<ul class="submenu">
							<li><a href="?mod=kartu_absensi_harian">Absensi Harian</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
<?php
}

elseif ($_SESSION["level"] == 5){
?>
	<div class="grid_2">
		<div class="box sidemenu">
			<div class="block" id="section-menu">
				<ul class="section menu">
					<li><a class="menuitem">Data Nilai</a>
						<ul class="submenu">
							<li><a href="?mod=transkip_nilai">Transkip Nilai</a></li>
							<li><a href="?mod=khs">Kartu Hasil Studi</a></li>
							<li><a href="?mod=rekap_ip">Rekap IPK dan IP Semester</a></li>
						</ul>
					</li>
					<li><a class="menuitem">Laporan</a>
						<ul class="submenu">
							<!--<li><a href="?mod=lap_bayar">Mahasiswa yang sudah membayar</a></li>
							<li><a href="?mod=lap_belum_bayar">Mahasiswa yang belum membayar</a></li>-->
							<li><a href="?mod=lap_rekap_umum">Rekapitulasi Pembayaran Umum</a></li>
							<li><a href="?mod=lap_rekap_day">Rekapitulasi Pembayaran Harian</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
<?php
}
?>