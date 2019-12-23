<?php
error_reporting(0);
session_start();
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";
include "../../../config/debug.php";
include "../../../fungsi/fungsi_date.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
	header("Location: ../../../index.php?code=2");
}

else{
	require ("../../../fungsi/html2pdf/html2pdf.class.php");
	$filename="kartu-uas.pdf";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = tgl_indo($now);
	$awal = tgl_indo($_GET['awal']);
	$akhir = tgl_indo($_GET['akhir']);
	$kelas = explode("*", $_GET['kelas']);
	
	$check = $_GET['check'];
	$data_user = $db->database_fetch_array($db->database_prepare("SELECT * FROM msdos WHERE IDDOSMSDOS = ?")->execute($_SESSION["userid"]));
	foreach($check as $cek){
		$data_mhs = $db->database_fetch_array($db->database_prepare("
					SELECT * FROM as_mahasiswa A INNER JOIN as_kelas_mahasiswa B ON B.id_mhs = A.id_mhs
					INNER JOIN mspst C ON C.IDPSTMSPST = A.kode_program_studi
					INNER JOIN as_kelas D ON D.kelas_id = B.kelas_id
					INNER JOIN as_angkatan E ON E.angkatan_id = D.angkatan_id
					INNER JOIN msdos F ON F.IDDOSMSDOS = C.NOKPSMSPST
					WHERE A.kode_program_studi = ? AND A.id_mhs = ?")->execute($_GET['prodi'],$cek));
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
		else{
			$kd_jenjang_studi = "Profesi";
		}
		if ($data_mhs['semester_angkatan'] == 'A'){
			$sem_ang = "Genap";
		}
		else{
			$sem_ang = "Ganjil";
		}
		$content .= "
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
							<td colspan='3' width='610'><hr></td>
						</tr>
					</table>
					<table>
						<tr>
							<td align='center' width='600'><h4>Kartu Ujian Akhir Semester (UAS)</h4></td>
						</tr>
					</table>
					<table>
						<tr valign='top'>
							<td>Program Studi</td>
							<td>: $kd_jenjang_studi - $data_mhs[NMPSTMSPST]</td>
						</tr>
						<tr valign='top'>
							<td>Kelas</td>
							<td>: $data_mhs[nama_kelas] - $data_mhs[semester] &nbsp; $sem_ang $data_mhs[tahun_angkatan]</td>
						</tr>
						<tr valign='top'>
							<td>NIM/Nama</td>
							<td>: $data_mhs[NIM] - $data_mhs[nama_mahasiswa]</td>
						</tr>
						<tr valign='top'>
							<td>Periode Ujian</td>
							<td>: $awal s/d $akhir</td>
						</tr>
					</table>
					<br>
					<table cellpadding=0 cellspacing=0>
						<tr>
							<th width='30' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'>No</th>
							<th width='80' align='center' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'>Kode MK</th>
							<th width='250' align='center' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'>Nama MK</th>
							<th width='70' align='center' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'>SKS</th>
							<th width='120' align='center' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'>Paraf</th>
						</tr>
				";
				$i = 1;
				$sql_data = $db->database_prepare("SELECT C.kode_mata_kuliah, C.nama_mata_kuliah_eng, C.sks_mata_kuliah FROM as_krs A INNER JOIN as_jadwal_kuliah B ON B.jadwal_id = A.jadwal_id
													INNER JOIN as_makul C ON C.mata_kuliah_id = B.makul_id
															WHERE 	A.id_mhs=? AND
																	B.semester = ?")->execute($data_mhs["id_mhs"],$kelas[1]);
				while ($data_data = $db->database_fetch_array($sql_data)){
				$content .= "<tr>
							<td style='border:1px solid #000; padding: 2px;'>$i</td>
							<td style='border:1px solid #000; padding: 2px;'>$data_data[kode_mata_kuliah]</td>
							<td style='border:1px solid #000; padding: 2px;'>$data_data[nama_mata_kuliah_eng]</td>
							<td style='border:1px solid #000; padding: 2px;' align=center>$data_data[sks_mata_kuliah]</td>
							<td style='border:1px solid #000; padding: 2px;'></td>
						</tr>";
					$i++;
				}				
							
				$content .= "</table>
							<table>
								<tr>
									<td width='400'></td>
									<td align='center'><p>&nbsp;</p>Universitas ASFA Solution,<br>Kepala Program Studi <br><br><br>$data_mhs[NMDOSMSDOS] $data_mhs[GELARMSDOS]<br>NIP. <b>$data_mhs[NODOSMSDOS]</b></td>
								</tr>
							</table>
							<p>&nbsp;</p>
							";
	}
	// conversion HTML => PDF
	try
	{
		$html2pdf = new HTML2PDF('P','A4','en', false, 'ISO-8859-15',array(15, 5, 5, 15)); //setting ukuran kertas dan margin pada dokumen anda
		// $html2pdf->setModeDebug();
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($filename);
	}
	catch(HTML2PDF_exception $e) { echo $e; }
}
?>