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
	$filename="kartu-absensi-ujian.pdf";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = tgl_indo($now);
	$tgl = tgl_indo($_GET['tgl']);
	$kelas = explode("*", $_GET['kelas']);
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_kelas B ON A.kelas_id=B.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id 
														INNER JOIN mspst D ON D.IDPSTMSPST=B.prodi_id
														INNER JOIN msdos E ON E.IDDOSMSDOS=A.dosen_id
														INNER JOIN as_makul G ON G.mata_kuliah_id=A.makul_id
														INNER JOIN as_ruang F ON F.ruang_id=A.ruang_id
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																B.angkatan_id = ? LIMIT 1")->execute($_GET['makul'],$kelas[0],$kelas[2]));
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
						<td>Mata Kuliah</td>
						<td>:</td>
						<td><b>$data_mhs[kode_mata_kuliah] - $data_mhs[nama_mata_kuliah_eng]</b></td>
					</tr>
					<tr valign='top'>
						<td>Dosen Pengajar</td>
						<td>:</td>
						<td><b>$data_mhs[NMDOSMSDOS] $data_mhs[GELARMSDOS]</b></td>
					</tr>
					<tr valign='top'>
						<td>Tipe Ujian</td>
						<td>:</td>
						<td><b>$status</b></td>
					</tr>
					<tr valign='top'>
						<td>Tgl.</td>
						<td>:</td>
						<td><b>$tgl</b></td>
					</tr>
				</table>	<br>
				<table border=1 cellpadding=0 cellspacing=0>
					<tr>
						<th width='25' style='border-bottom: 1px solid;' bgcolor='#B7D577'>No.</th>
						<th align='center' width='100' style='border-bottom: 1px solid;' bgcolor='#B7D577'>NIM</th>
						<th align='center' width='350' style='border-bottom: 1px solid;' bgcolor='#B7D577'>Nama Mahasiswa</th>
						<th width='120' align='center' style='border-bottom: 1px solid;' bgcolor='#B7D577'>Paraf</th>
					</tr>
			";
			$i = 1;
			$sql_data = $db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_krs B ON B.jadwal_id=A.jadwal_id
														INNER JOIN as_kelas C ON C.kelas_id=A.kelas_id
														INNER JOIN as_angkatan D ON C.angkatan_id=C.angkatan_id
														INNER JOIN as_mahasiswa E ON E.id_mhs=B.id_mhs
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																C.angkatan_id = ?")->execute($_GET['makul'],$kelas[0],$kelas[2]);
			while ($data_data = $db->database_fetch_array($sql_data)){
			$content .= "<tr>
						<td style='padding: 2px;'>$i</td>
						<td style='padding: 2px;'>$data_data[NIM]</td>
						<td style='padding: 2px;'>$data_data[nama_mahasiswa]</td>
						<td></td>
					</tr>";
				$i++;
			}				
						
			$content .= "</table><p>&nbsp;</p>
						<table>
							<tr>
								<td width='400'></td>
								<td align='center'>Paraf Pengawas <p>&nbsp;</p><br>(.........................................)</td>
							</tr>
						</table>";
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