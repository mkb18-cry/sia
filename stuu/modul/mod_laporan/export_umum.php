<?php
error_reporting(0);
session_start();
date_default_timezone_set('Asia/Jakarta');
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";
include "../../../config/debug.php";
include "../../../fungsi/fungsi_terbilang.php";
include "../../../fungsi/fungsi_rupiah.php";
include "../../../fungsi/fungsi_date.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
	header("Location: ../../../login.php?code=2");
}

else{
	require ("../../../fungsi/html2pdf/html2pdf.class.php");
	$filename="contoh-dokumen.pdf";
	$content = ob_get_clean();
	$kelas = explode("*", $_GET['kelas']);
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = tgl_indo($now);
	$data_prodi = $db->database_fetch_array($db->database_prepare("SELECT KDJENMSPST, NMPSTMSPST, fakultas FROM mspst INNER JOIN msfks ON msfks.fakultas_id = mspst.fakultas_id WHERE IDPSTMSPST = ?")->execute($_GET["prodi"]));
	$data_kelas = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_kelas WHERE kelas_id = ?")->execute($kelas[0]));
	if ($data_prodi['KDJENMSPST'] == 'A'){
		$kd_jenjang_studi = "S3";
	}
	elseif ($data_prodi['KDJENMSPST'] == 'B'){
		$kd_jenjang_studi = "S2";
	}
	elseif ($data_prodi['KDJENMSPST'] == 'C'){
		$kd_jenjang_studi = "S1";
	}
	elseif ($data_prodi['KDJENMSPST'] == 'D'){
		$kd_jenjang_studi = "D4";
	}
	elseif ($data_prodi['KDJENMSPST'] == 'E'){
		$kd_jenjang_studi = "D3";
	}
	elseif ($data_prodi['KDJENMSPST'] == 'F'){
		$kd_jenjang_studi = "D2";
	}
	elseif ($data_prodi['KDJENMSPST'] == 'G'){
		$kd_jenjang_studi = "D1";
	}
	elseif ($data_prodi['KDJENMSPST'] == 'H'){
		$kd_jenjang_studi = "Sp-1";
	}
	elseif ($data_prodi['KDJENMSPST'] == 'I'){
		$kd_jenjang_studi = "Sp-2";
	}
	elseif ($data_prodi['KDJENMSPST'] == 'J'){
		$kd_jenjang_studi = "Profesi";
	}
	$content = "
				<table>
					<tr valign='top'>
						<td><img src='../../../logo-umar-usman.jpg' height='50'></td>
						<td width='10'></td>
						<td width=500>
							<b>Sekolah Tinggi Umar Usman</b><br>
							Philanthropy Building<br>
							Jl. Buncit Raya Ujung No. 18 Jakarta Selatan - Indonesia 12540<br>
							Telp. (021) 7884 5924/25, 085 888 53 8899, Fax. (021) 7884 5926
						</td>
					</tr>
					<tr>
						<td colspan='3'><hr></td>
					</tr>
				</table>
				<table border=0>
					<tr>
						<td align=center width=698><h4>Rekapitulasi Pembayaran Umum</h4></td>
					</tr>
				</table>
				<table>
					<tr>
						<td width='120'>Program Studi </td>
						<td width='10'>:</td>
						<td><b>$kd_jenjang_studi $data_prodi[fakultas] - $data_prodi[NMPSTMSPST]</b></td>
					</tr>
					<tr>
						<td>Kelas</td>
						<td>:</td>
						<td><b>$data_kelas[nama_kelas] - $kelas[1]</b></td>
					</tr>
					<tr>
						<td>Tanggal Cetak</td>
						<td>:</td>
						<td><b>$date_now</b></td>
					</tr>
				</table>	
				<br><br>
				<table cellpaading=0 cellspacing=0 border=1>
				<tr>
					<td colspan='4' bgcolor='#B7D577'></td>
					<td colspan='3' align=center bgcolor='#999'><b>Total Sudah Bayar (Rp)</b></td>
					<td colspan='3' align=center bgcolor='#999ccc'><b>Status (Rp)</b></td>
				</tr>
				<tr>
					<th align='center' width=20 bgcolor='#B7D577'>No</th>
					<th align='center' width=80 bgcolor='#B7D577'>NPM/NIM</th>
					<th align='center' width=180 bgcolor='#B7D577'>Nama Mahasiswa</th>
					<th align='center' width=40 bgcolor='#B7D577'>Kelas</th>
					<th align='center' bgcolor='#B7D577'>Gedung</th>
					<th align='center' bgcolor='#B7D577'>SPP</th>
					<th align='center' bgcolor='#B7D577'>SKS</th>
					<th align='center' bgcolor='#B7D577'>Gedung</th>
					<th align='center' bgcolor='#B7D577'>SPP</th>
					<th align='center' bgcolor='#B7D577'>SKS</th>
				</tr>";
				$i = 1;
				$sql_data = $db->database_prepare("SELECT * FROM as_mahasiswa A
													INNER JOIN as_kelas_mahasiswa B ON B.id_mhs = A.id_mhs
													INNER JOIN as_kelas C ON C.kelas_id = B.kelas_id 
													WHERE A.kode_program_studi = ? AND B.kelas_id = ? AND A.status_mahasiswa = 'A'")->execute($_GET["prodi"],$kelas[0]);
				while ($data_data = $db->database_fetch_array($sql_data)){
					$data_bayar = $db->database_fetch_array($db->database_prepare("SELECT SUM(uang_gedung) as jumlah_gedung, SUM(uang_spp) as jumlah_spp, 
																					SUM(uang_sks) as jumlah_sks FROM as_transaksi_bayar WHERE id_mhs=?")->execute($data_data['id_mhs']));
					$data_utang = $db->database_fetch_array($db->database_prepare("SELECT uang_gedung, uang_sks, uang_spp FROM as_biaya_kuliah WHERE id_mhs = ?")->execute($data_data["id_mhs"]));
					$tot_krs = $db->database_fetch_array($db->database_prepare("SELECT SUM(C.sks_mata_kuliah) as jumlah FROM as_krs A INNER JOIN as_jadwal_kuliah B ON A.jadwal_id=B.jadwal_id
												INNER JOIN as_makul C ON C.mata_kuliah_id=B.makul_id 
												INNER JOIN as_kelas D ON D.kelas_id=B.kelas_id
												INNER JOIN msdos E ON E.IDDOSMSDOS=B.dosen_id 
												WHERE B.kelas_id = ? AND A.id_mhs = ?")->execute($data_data["kelas_id"],$data_data["id_mhs"]));
					
					if ($data_bayar['jumlah_gedung'] >= $data_utang['uang_gedung']){
						$status_gedung = "<font color='green'><b>Lunas</b></font>";
					}
					else{
						$sisa_gedung = rupiah($data_utang['uang_gedung'] - $data_bayar['jumlah_gedung']);
						$status_gedung = "<font color=red><b>- $sisa_gedung</b></font>";
					}
					
					if ($data_bayar['jumlah_spp'] >= $data_utang['uang_spp']){
						$status_spp = "<font color='green'><b>Lunas</b></font>";
					}
					else{
						$sisa_spp = rupiah($data_utang['uang_spp'] - $data_bayar['jumlah_spp']);
						$status_spp = "<font color=red><b>- $sisa_spp</b></font>";
					}
					
					$krs = $tot_krs['jumlah'] * $data_utang['uang_sks'];
					if ($data_bayar['jumlah_sks'] >= $krs){
						$status_sks = "<font color='green'><b>Lunas</b></font>";
					}
					else{
						$sisa_sks = rupiah($krs - $data_bayar['jumlah_spp']);
						$status_sks = "<font color=red><b>- $sisa_sks</b></font>";
					}
					
					
					$sudah_bayar_gedung = rupiah($data_bayar['jumlah_gedung']);
					$sudah_bayar_spp = rupiah($data_bayar['jumlah_spp']);
					$sudah_bayar_sks = rupiah($data_bayar['jumlah_sks']);
					$kurang = rupiah($data_sem_1['uang_gedung'] - $data_bayar['jumlah']);
					
					$content .= "<tr>
								<td style='padding: 2px;'>$i</td>
								<td align=center style='padding: 2px;'>$data_data[NIM]</td>
								<td style='padding: 2px;'>$data_data[nama_mahasiswa]</td>
								<td style='padding: 2px;'>$data_data[nama_kelas]</td>
								<td style='padding: 2px;' align=right>$sudah_bayar_gedung</td>
								<td style='padding: 2px;' align=right>$sudah_bayar_spp</td>
								<td style='padding: 2px;' align=right>$sudah_bayar_sks</td>
								<td style='padding: 2px;' align=right>$status_gedung</td>
								<td style='padding: 2px;' align=right>$status_spp</td>
								<td style='padding: 2px;' align=right>$status_sks</td>
							</tr>";
						$i++;
				}
				$content .= "</table>";
	// conversion HTML => PDF
	try
	{
		$html2pdf = new HTML2PDF('P','A4','fr', false, 'ISO-8859-15',array(10, 10, 10, 10)); //setting ukuran kertas dan margin pada dokumen anda
		// $html2pdf->setModeDebug();
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($filename);
	}
	catch(HTML2PDF_exception $e) { echo $e; }
}
?>