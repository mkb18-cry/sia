<?php
error_reporting(0);
session_start();
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";
include "../../../config/debug.php";
include "../../../fungsi/fungsi_date.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
	header("Location: ../../../login.php?code=2");
}

else{
	require ("../../../fungsi/html2pdf/html2pdf.class.php");
	$filename="kartu-krs.pdf";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = tgl_indo($now);
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT 	A.id_mhs,
												A.NIM,
												A.nama_mahasiswa,
												B.KDJENMSPST,
												B.NMPSTMSPST,
												D.nama_kelas,
												D.semester_kelas,
												F.semester as krs_semester
												
									FROM as_mahasiswa A INNER JOIN mspst B ON B.IDPSTMSPST=A.kode_program_studi
									INNER JOIN as_krs E ON E.id_mhs = A.id_mhs
									INNER JOIN as_jadwal_kuliah F ON F.jadwal_id = E.jadwal_id 
									INNER JOIN as_kelas_mahasiswa C ON C.id_mhs=A.id_mhs
									INNER JOIN as_kelas D ON D.kelas_id=C.kelas_id
									WHERE A.id_mhs = ? AND A.status_mahasiswa = 'A' ORDER BY C.kelas_mhs_id DESC LIMIT 1")->execute($_GET['id_mhs']));
	
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
						<td colspan='3' align='center'><br><p><b><u>KARTU RENCANA STUDI (KRS)</u></b></p></td>
					</tr>
					<tr>
						<td colspan='3'><p>&nbsp;</p></td>
					</tr>
				</table>
				<table>
					<tr>
						<td width='50'>NIM</td>
						<td width='5'>:</td>
						<td><b>$data_mhs[NIM]</b></td>
					</tr>
					<tr>
						<td>Nama Mahasiswa</td>
						<td>:</td>
						<td><b>$data_mhs[nama_mahasiswa]</b></td>
					</tr>
					<tr>
						<td>Program Studi</td>
						<td>:</td>
						<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST]</b></td>
					</tr>
					<tr>
						<td>Kelas - Semester</td>
						<td>:</td>
						<td><b>$data_mhs[nama_kelas] - $data_mhs[semester_kelas]</b></td>
					</tr>
					<tr>
						<td>KRS Semester</td>
						<td>:</td>
						<td><b>$data_mhs[krs_semester]</b></td>
					</tr>
				</table>	<br>
				<table cellpadding=0 cellspacing=0>
					<tr>
						<th width='25' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'>No</th>
						<th align='center' width='80' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'>Kode MTK</th>
						<th align='center' width='330' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'>Nama MTK</th>
						<th width='120' align='center' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'>Jumlah SKS</th>
					</tr>
			";
			$i = 1;
			$sql_krs = $db->database_prepare("SELECT * FROM as_krs A INNER JOIN as_jadwal_kuliah B ON A.jadwal_id = B.jadwal_id
										INNER JOIN as_makul C ON C.mata_kuliah_id = B.makul_id
										INNER JOIN msdos D ON D.IDDOSMSDOS = B.dosen_id
										WHERE A.id_mhs = ? AND B.semester = ?")->execute($data_mhs['id_mhs'],$_GET['semester']);
			while ($data_krs = $db->database_fetch_array($sql_krs)){
			$content .= "<tr>
						<td style='border:1px solid #000; padding: 2px;'>$i</td>
						<td style='border:1px solid #000; padding: 2px;'>$data_krs[kode_mata_kuliah]</td>
						<td style='border:1px solid #000; padding: 2px;'>$data_krs[nama_mata_kuliah_eng]</td>
						<td style='border:1px solid #000; padding: 2px;' align='center'>$data_krs[sks_mata_kuliah]</td>
					</tr>";
				$grand_sks += $data_krs['sks_mata_kuliah'];
				$i++;
			}				
			$nip = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_users WHERE user_id = ?")->execute($_SESSION["userid"]));
			$content .= "
					<tr>
						<td colspan='3' align='right' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'><b>Total SKS</b></td>
						<td style='border:1px solid #000; background-color: #9CCC68; padding: 2px;' align='center'><b>$grand_sks</b></td>
					</tr>
					</table>
					<p>&nbsp;</p>
					<table>
						<tr>
							<td width='400'></td>
							<td align='center'>Cirebon, $date_now<br>
							BAAK<br>
								<p></p>
								<u>$_SESSION[nama_lengkap]</u><br>
								<b>NIP. $nip[nip]</b> 
							</td>
						</tr>
					</table>
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