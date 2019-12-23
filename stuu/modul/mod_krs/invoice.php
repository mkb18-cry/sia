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
	$filename="invoice-krs.pdf";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = tgl_indo($now);
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_mahasiswa INNER JOIN mspst ON mspst.IDPSTMSPST=as_mahasiswa.kode_program_studi 
									INNER JOIN as_kelas_mahasiswa ON as_kelas_mahasiswa.id_mhs=as_mahasiswa.id_mhs
									INNER JOIN as_kelas ON as_kelas.kelas_id=as_kelas_mahasiswa.kelas_id
									WHERE as_mahasiswa.id_mhs = ? AND status_mahasiswa = 'A' ORDER BY kelas_mhs_id DESC LIMIT 1")->execute($_GET['id_mhs']));
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
				<table width='100%'>
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
						<td>Kelas/Semester</td>
						<td>:</td>
						<td><b>$data_mhs[nama_kelas] - $data_mhs[semester]</b></td>
					</tr>
				</table>	<br>
				<table cellpadding=0 cellspacing=0>
					<tr>
						<th width='10' style='border: 1px solid #000; padding: 5px;font-size: 11.5px; background-color:#9CCC68;'>No.</th>
						<th align='center' width='80' style='border: 1px solid #000; font-size: 11.5px;background-color:#9CCC68;'>Kode MTK</th>
						<th align='center' width='355' style='border: 1px solid #000; font-size: 11.5px;background-color:#9CCC68;'>Nama MTK</th>
						<th width='120' align='center' style='border: 1px solid #000; font-size: 11.5px;background-color:#9CCC68;'>Jumlah SKS</th>
					</tr>
			";
			$i = 1;
			$sql_krs = $db->database_prepare("SELECT * FROM as_krs A INNER JOIN as_jadwal_kuliah B ON A.jadwal_id=B.jadwal_id
										INNER JOIN as_makul C ON C.mata_kuliah_id=B.makul_id 
										INNER JOIN as_kelas D ON D.kelas_id=B.kelas_id
										INNER JOIN msdos E ON E.IDDOSMSDOS=B.dosen_id 
										WHERE B.kelas_id = ? AND A.id_mhs = ? AND B.semester = ?")->execute($_GET["kelas_id"],$_GET["id_mhs"],$_GET["semester"]);
			while ($data_krs = $db->database_fetch_array($sql_krs)){
			$content .= "<tr>
						<td style='border: 1px solid #000;padding: 5px; font-size: 11.5px;'>$i</td>
						<td style='border: 1px solid #000; font-size: 11.5px;'>$data_krs[kode_mata_kuliah]</td>
						<td style='border: 1px solid #000; font-size: 11.5px;'>$data_krs[nama_mata_kuliah_eng]</td>
						<td style='border: 1px solid #000; font-size: 11.5px;' align='center'>$data_krs[sks_mata_kuliah]</td>
					</tr>";
				$grand_sks += $data_krs['sks_mata_kuliah'];
				$i++;
			}				
			$nip = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_users WHERE user_id = ?")->execute($_SESSION["userid"]));
			$content .= "
					<tr>
						<td colspan='3' style='border: 1px solid #000; padding: 4px 7px; font-size: 11.5px;' align='right'><b>Total SKS</b></td>
						<td style='border: 1px solid #000; font-size: 11.5px;' align='center'><b>$grand_sks</b></td>
					</tr>
					</table>
					<p>&nbsp;</p>
					<table>
						<tr>
							<td width='400'></td>
							<td align='center'>Jakarta, $date_now<br>
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