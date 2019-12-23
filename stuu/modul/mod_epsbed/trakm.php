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
	$filename="msdos.pdf";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = tgl_indo($now);
	
	$content .= "
				<table>
					<tr valign='top'>
						<td align='right'><img src='../../../logo.jpg' height='50'></td>
						<td width='10'></td>
						<td>
							<b>Universitas ASFA Solution</b><br>
							Jl. Pegadaian No. 38 Arjawinangun, Cirebon - Indonesia 45162<br>
							Telp. (0231) 358630, 0856 2121 141<br>
							Website: http://www.asfasolution.com; Email: info@asfasolution.com
						</td>
					</tr>
					<tr>
						<td colspan='3' width='1000'><hr></td>
					</tr>
				</table>
				<table>
					<tr>
						<td align='center' width='1000'><h4>Master Transaksi Mahasiswa</h4></td>
					</tr>
				</table>
				<br>
				<table cellpadding=0 cellspacing=0 border=1>
					<tr>
						<th width=20 style='padding: 5px;'>No</th>
						<th width='80' align='center' style='padding: 5px;'>NIM</th>
						<th align='center' style='padding: 5px;' width='200'>Nama Mahasiswa</th>
						<th align='center' style='padding: 5px;' width='100'>Jenjang Studi</th>
						<th align='center' style='padding: 5px;' width='100'>Program Studi</th>
						<th align='center' style='padding: 5px;' width='120'>Tahun Angkatan</th>
						<th align='center' style='padding: 5px;' width='80'>Semester</th>
						<th align='center' style='padding: 5px;' width='80'>Status</th>
					</tr>";
					$no = 1;
					if ($_GET['th'] == 'all'){
						$sql = $db->database_prepare("SELECT D.status_transaksi, D.periode_awal, D.periode_akhir, A.NIM, A.nama_mahasiswa, C.NMPSTMSPST, C.KDJENMSPST, A.gelar_depan, A.gelar_belakang, B.tahun_angkatan,
												B.semester_angkatan, A.status_mahasiswa FROM as_mahasiswa A INNER JOIN as_angkatan B ON B.angkatan_id=A.angkatan_id
												INNER JOIN mspst C ON C.IDPSTMSPST=A.kode_program_studi
												INNER JOIN as_transaksi_mhs D ON D.id_mhs=A.id_mhs
												ORDER BY A.NIM ASC")->execute();
					}
					else{
						$sql = $db->database_prepare("SELECT D.status_transaksi, D.periode_awal, D.periode_akhir, A.NIM, A.nama_mahasiswa, A.gelar_depan, C.NMPSTMSPST, C.KDJENMSPST, A.gelar_belakang, B.tahun_angkatan,
												B.semester_angkatan, A.status_mahasiswa FROM as_mahasiswa A INNER JOIN as_angkatan B ON B.angkatan_id=A.angkatan_id
												INNER JOIN mspst C ON C.IDPSTMSPST=A.kode_program_studi
												INNER JOIN as_transaksi_mhs D ON D.id_mhs=A.id_mhs
												WHERE A.angkatan_id = ?
												ORDER BY A.NIM ASC")->execute($_GET["th"]);
					}
					
					while ($data = $db->database_fetch_array($sql)){
						$start = tgl_indo($data['periode_awal']);
						$end = tgl_indo($data['periode_akhir']);
						
						if ($data['status_transaksi'] == 'A'){
							$status = "Aktif";
						}
						elseif ($data['status_transaksi'] == 'C'){
							$status = "Cuti";
						}
						elseif ($data['status_transaksi'] == 'D'){
							$status = "Drop out";
						}
						elseif ($data['status_transaksi'] == 'L'){
							$status = "Lulus";
						}
						else{
							$status = "Non-aktif";
						}
						
						if ($data['KDJENMSPST'] == 'A'){
							$kd_jenjang_studi = "S3";
						}
						elseif ($data['KDJENMSPST'] == 'B'){
							$kd_jenjang_studi = "S2";
						}
						elseif ($data['KDJENMSPST'] == 'C'){
							$kd_jenjang_studi = "S1";
						}
						elseif ($data['KDJENMSPST'] == 'D'){
							$kd_jenjang_studi = "D4";
						}
						elseif ($data['KDJENMSPST'] == 'E'){
							$kd_jenjang_studi = "D3";
						}
						elseif ($data['KDJENMSPST'] == 'F'){
							$kd_jenjang_studi = "D2";
						}
						elseif ($data['KDJENMSPST'] == 'G'){
							$kd_jenjang_studi = "D1";
						}
						elseif ($data['KDJENMSPST'] == 'H'){
							$kd_jenjang_studi = "Sp-1";
						}
						elseif ($data['KDJENMSPST'] == 'I'){
							$kd_jenjang_studi = "Sp-2";
						}
						else{
							$kd_jenjang_studi = "Profesi";
						}
						
						if ($data['semester_angkatan'] == 'A'){
							$semester = "Genap";
						}
						else{
							$semester = "Ganjil";
						}
									
						$content .= "
							<tr>
								<td style='padding: 5px;'>$no</td>
								<td style='padding: 5px;'>$data[NIM]</td>
								<td style='padding: 5px;'>$data[nama_mahasiswa]</td>
								<td style='padding: 5px;' align='center'>$kd_jenjang_studi</td>
								<td style='padding: 5px;'>$data[NMPSTMSPST]</td>
								<td style='padding: 5px; text-align: center;'>$data[tahun_angkatan]</td>
								<td style='padding: 5px; text-align: center;'>$semester</td>
								<td align='center' style='padding: 5px;'>$status</td>
							</tr>
						";
						$no++;
					}
					
		$content .= "</table>
				<table>
					<tr>
						<td width='400'></td>
						<td align='center'><p>&nbsp;</p>Universitas ASFA Solution, <br>Ketua / <i>President</i><p>&nbsp;</p><br><br>Agus Saputra, S.Kom.<br>NIP. <b>2013080002</b></td>
					</tr>
				</table>
				";
	}
	// conversion HTML => PDF
	try
	{
		$html2pdf = new HTML2PDF('L','A4','en', false, 'ISO-8859-15',array(15, 15, 15, 15)); //setting ukuran kertas dan margin pada dokumen anda
		// $html2pdf->setModeDebug();
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($filename);
	}
	catch(HTML2PDF_exception $e) { echo $e; }
?>