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
	$filename="rekap_ip.pdf";
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
														WHERE 	A.kelas_id=? AND
																B.angkatan_id = ? LIMIT 1")->execute($kelas[0],$kelas[2]));
	
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
						<td colspan='3' align='center'><br><p><b><u>Rekap IP Semester dan IPK</u></b></p></td>
					</tr>
					<tr>
						<td colspan='3'><p>&nbsp;</p></td>
					</tr>
				</table>
				<table>
					<tr>
						<td>Program Studi</td>
						<td>:</td>
						<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST]</b></td>
					</tr>
					<tr>
						<td>Kelas/Semester</td>
						<td>:</td>
						<td><b>$data_mhs[nama_kelas] - $data_mhs[semester] / $_GET[semester]</b></td>
					</tr>
				</table>	<br>
				<table cellpadding=0 border='0' cellspacing=0>
					<tr bgcolor='#B7D577'>
						<th width='30' style='border-left: 1px solid; border-top: 1px solid; border-bottom: 1px solid;'>No.</th>
						<th align='center' width='130' style='border-left: 1px solid; border-top: 1px solid; border-bottom: 1px solid;'>NIM</th>
						<th align='center' width='250' style='border-left: 1px solid; border-top: 1px solid; border-bottom: 1px solid;'>Nama Mahasiswa</th>
						<th align='center' width='50' style='border-left: 1px solid; border-top: 1px solid; border-bottom: 1px solid;'>IP</th>
						<th width='50' align='center'  style='border-left: 1px solid; border-top: 1px solid; border-bottom: 1px solid; border-right: 1px solid;'>IPK</th>
					</tr>
			";
			$i = 1;
			$sql_data = $db->database_prepare("SELECT * FROM as_mahasiswa A INNER JOIN as_kelas_mahasiswa B ON B.id_mhs=A.id_mhs
												INNER JOIN as_kelas C ON C.kelas_id=B.kelas_id
												INNER JOIN as_angkatan D ON D.angkatan_id=C.angkatan_id
												WHERE
												C.kelas_id = ? AND
												D.angkatan_id = ?")->execute($kelas[0],$kelas[2]);
			while ($data_rekap = $db->database_fetch_array($sql_data)){
				$sql_data2 = $db->database_prepare("SELECT SUM(B.sks_mata_kuliah) as sks_mata_kuliah, SUM(A.bobot * B.sks_mata_kuliah) as bobot, A.id_mhs FROM as_nilai_semester_mhs A
												INNER JOIN as_makul B ON B.mata_kuliah_id = A.makul_id
												WHERE
												A.semester_nilai = ? AND
												A.id_mhs = ?")->execute($_GET["semester"],$data_rekap["id_mhs"]);
				while ($data_rekap2 = $db->database_fetch_array($sql_data2)){
					$ip = number_format($data_rekap2['bobot'] / $data_rekap2['sks_mata_kuliah'], 2);
				}
				
				$sql_data3 = $db->database_prepare("SELECT SUM(B.sks_mata_kuliah) as sks_mata_kuliah, SUM(A.bobot * B.sks_mata_kuliah) as bobot, A.id_mhs FROM as_nilai_semester_mhs A
												INNER JOIN as_makul B ON B.mata_kuliah_id = A.makul_id
												WHERE
												A.id_mhs = ?")->execute($data_rekap["id_mhs"]);
				while ($data_rekap3 = $db->database_fetch_array($sql_data3)){
					$ipk = number_format($data_rekap3['bobot'] / $data_rekap3['sks_mata_kuliah'], 2);
				}
				$content .= "<tr>
							<td style='border-bottom: 1px solid; border-left: 1px solid;'>$i</td>
							<td style='border-bottom: 1px solid; border-left: 1px solid;' align='center'>$data_rekap[NIM]</td>
							<td style='border-bottom: 1px solid; border-left: 1px solid;'>$data_rekap[nama_mahasiswa]</td>
							<td style='border-bottom: 1px solid; border-left: 1px solid;' align='center'>$ip</td>
							<td style='border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;' align='center'>$ipk</td>
						</tr>";
				$i++;
			}				
			$content .= "
					</table><p>&nbsp;</p>
					<table>
						<tr>
							<td width='400'></td>
							<td align='center'>Cirebon, $date_now<br><br>
							Universitas ASFA Solution<br>
							Ketua<br>
								<p>&nbsp;</p><p>&nbsp;</p>
								Agus Saputra, S.Kom. <br>
								<b>NIP. 2013080002</b> 
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