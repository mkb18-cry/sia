<?php
error_reporting(0);
session_start();
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";
include "../../../config/debug.php";
include "../../../fungsi/fungsi_date.php";
include "../../../fungsi/timezone.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
	header("Location: ../../../index.php?code=2");
}

else{
	require ("../../../fungsi/html2pdf/html2pdf.class.php");
	$filename="kartu-absensi.pdf";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = tgl_indo($now);
	$kelas = explode("*", $_GET['kelas']);
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_kelas B ON A.kelas_id=B.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id 
														INNER JOIN mspst D ON D.IDPSTMSPST=B.prodi_id
														INNER JOIN msdos E ON E.IDDOSMSDOS=A.dosen_id
														INNER JOIN as_ruang F ON F.ruang_id=A.ruang_id
														INNER JOIN as_makul G ON A.makul_id=G.mata_kuliah_id
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																B.angkatan_id = ? LIMIT 1")->execute($_GET['makul4'],$kelas[0],$kelas[2]));
	if ($data_mhs['KDJENMSPST'] == 'A'){
		$kd_jenjang_studi = "S3";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'B'){
		$kd_jenjang_studi = "S2";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'C'){
		$kd_jenjang_studi = "S1";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'D'){
		$kd_jenjang_studi = "D4";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'E'){
		$kd_jenjang_studi = "D3";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'F'){
		$kd_jenjang_studi = "D2";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'G'){
		$kd_jenjang_studi = "D1";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'H'){
		$kd_jenjang_studi = "Sp-1";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'I'){
		$kd_jenjang_studi = "Sp-2";
	}
	elseif ($data_mhs['KDJENMSPST'] == 'J'){
		$kd_jenjang_studi = "Profesi";
	}
	
	if ($_GET['status'] == 'A'){
		$status = "Ujian Tengah Semester (UTS)";
	}
	else{
		$status = "Ujian Akhir Semester (UAS)";
	}
	$content = "
				<table>
					<tr valign='top'>
						<td><img src='../../../logo.jpg' height='50'></td>
						<td width='10'></td>
						<td>
							<b>Universitas ASFA Solution</b><br>
							CV. ASFA Solution<br>
							Jl. Pegadaian No. 38 Arjawinangun, Cirebon - Indonesia 45162<br>
							Telp. (0231) 358630, 085 621 21141
						</td>
					</tr>
					<tr>
						<td colspan='3'><hr></td>
					</tr>
					<tr>
						<td colspan='3'><p>&nbsp;</p></td>
					</tr>
				</table>
				<table>
					<tr>
						<td width='100'>Program Studi</td>
						<td width='5'>:</td>
						<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST]</b></td>
					</tr>
					<tr valign='top'>
						<td>Kelas/Semester</td>
						<td>:</td>
						<td><b>$data_mhs[nama_kelas] - $data_mhs[semester]</b></td>
					</tr>
					<tr valign='top'>
						<td>Dosen</td>
						<td>:</td>
						<td><b>$data_mhs[NMDOSMSDOS] $data_mhs[GELARMSDOS]</b></td>
					</tr>
					<tr valign='top'>
						<td>Mata Kuliah</td>
						<td>:</td>
						<td><b>$data_mhs[kode_mata_kuliah] - $data_mhs[nama_mata_kuliah_eng]</b></td>
					</tr>
					<tr valign='top'>
						<td>Jenis Ujian</td>
						<td>:</td>
						<td><b>$status</b></td>
					</tr>
					<tr valign='top'>
						<td>Tgl. Cetak</td>
						<td>:</td>
						<td><b>$date_now</b></td>
					</tr>
				</table>	<br>
				<h4>Laporan Data Absensi Ujian</h4>
				<table border=1 cellpadding=0 cellspacing=0>
					<tr>
						<th width='25' style='border-bottom: 1px solid;' bgcolor='#B7D577'>No.</th>
						<th align='center' width='80' style='border-bottom: 1px solid;' bgcolor='#B7D577'>NIM</th>
						<th align='center' width='215' style='border-bottom: 1px solid;' bgcolor='#B7D577'>Nama Mahasiswa</th>
						<th align='center' width='50' style='border-bottom: 1px solid;' bgcolor='#B7D577'>Hadir</th>
						<th align='center' width='50' style='border-bottom: 1px solid;' bgcolor='#B7D577'>Alpha</th>
						<th align='center' width='50' style='border-bottom: 1px solid;' bgcolor='#B7D577'>Izin</th>
						<th align='center' width='50' style='border-bottom: 1px solid;' bgcolor='#B7D577'>Sakit</th>
						<th align='center' width='50' style='border-bottom: 1px solid;' bgcolor='#B7D577'>Total</th>
					</tr>
			";
			$i = 1;
			$sql_data = $db->database_prepare("SELECT * FROM as_abs_ujian_mhs A INNER JOIN as_jadwal_kuliah B ON A.jadwal_id=B.jadwal_id
												INNER JOIN as_kelas C ON C.kelas_id=B.kelas_id
												INNER JOIN as_angkatan D ON D.angkatan_id=C.angkatan_id
												INNER JOIN as_mahasiswa E ON E.id_mhs=A.id_mhs
												WHERE
												B.makul_id = ? AND
												B.kelas_id = ? AND
												D.angkatan_id = ? AND
												A.jenis_ujian = ? GROUP BY A.id_mhs, A.jadwal_id")->execute($_GET['makul4'],$kelas[0],$kelas[2],$_GET["status"]);
			
			while ($data_data = $db->database_fetch_array($sql_data)){
				$numsH = $db->database_num_rows($db->database_prepare("SELECT * FROM as_abs_ujian_mhs WHERE id_mhs = ? AND jadwal_id = ? AND paraf = ? AND jenis_ujian = ?")->execute($data_data['id_mhs'],$data_data['jadwal_id'],H,$_GET["status"]));
				$numsA = $db->database_num_rows($db->database_prepare("SELECT * FROM as_abs_ujian_mhs WHERE id_mhs = ? AND jadwal_id = ? AND paraf = ? AND jenis_ujian = ?")->execute($data_data['id_mhs'],$data_data['jadwal_id'],A,$_GET["status"]));
				$numsI = $db->database_num_rows($db->database_prepare("SELECT * FROM as_abs_ujian_mhs WHERE id_mhs = ? AND jadwal_id = ? AND paraf = ? AND jenis_ujian = ?")->execute($data_data['id_mhs'],$data_data['jadwal_id'],I,$_GET["status"]));
				$numsS = $db->database_num_rows($db->database_prepare("SELECT * FROM as_abs_ujian_mhs WHERE id_mhs = ? AND jadwal_id = ? AND paraf = ? AND jenis_ujian = ?")->execute($data_data['id_mhs'],$data_data['jadwal_id'],S,$_GET["status"]));
				$nums = $db->database_num_rows($db->database_prepare("SELECT * FROM as_abs_ujian_mhs A INNER JOIN as_jadwal_kuliah B ON A.jadwal_id=B.jadwal_id
												INNER JOIN as_kelas C ON C.kelas_id=B.kelas_id
												INNER JOIN as_angkatan D ON D.angkatan_id=C.angkatan_id
												INNER JOIN as_mahasiswa E ON E.id_mhs=A.id_mhs
												WHERE
												B.makul_id = ? AND
												B.kelas_id = ? AND
												D.angkatan_id = ? AND
												A.id_mhs = ? AND
												A.jenis_ujian = ?")->execute($_GET['makul4'],$kelas[0],$kelas[2],$data_data['id_mhs'],$_GET["status"]));
				$content .= "<tr>
							<td style='padding: 2px;'>$i</td>
							<td style='padding: 2px;'>$data_data[NIM]</td>
							<td style='padding: 2px;'>$data_data[nama_mahasiswa]</td>
							<td style='padding: 2px;' align='center'>$numsH</td>
							<td style='padding: 2px;' align='center'>$numsA</td>
							<td style='padding: 2px;' align='center'>$numsI</td>
							<td style='padding: 2px;' align='center'>$numsS</td>
							<td style='padding: 2px;' align='center'>$nums</td>
						</tr>";
				$i++;
			}				
						
			$content .= "</table><p>&nbsp;</p>
						";
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