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
							Jl. Pegadaian No. 38 RT. 01 RW. 01 Arjawinangun, Cirebon - Indonesia 45162<br>
							Telp. (0231) 358630, 0856 2121 141
						</td>
					</tr>
					<tr>
						<td colspan='3' width='1000'><hr></td>
					</tr>
				</table>
				<table>
					<tr>
						<td align='center' width='1000'><h4>Master Publikasi Dosen</h4></td>
					</tr>
				</table>
				<br>
				<table cellpadding=0 cellspacing=0 border=1>
					<tr>
						<th width=20 style='padding: 5px;'>No</th>
						<th width='70' align='center' style='padding: 5px;'>NIP</th>
						<th align='center' style='padding: 5px;' width='200'>Nama Dosen</th>
						<th align='center' style='padding: 5px;' width='80'>Gelar</th>
						<th align='center' style='padding: 5px;' width='80'>Jenis Penelitian</th>
						<th align='center' style='padding: 5px;' width='120'>Hasil Peneilitian</th>
						<th align='center' style='padding: 5px;' width='100'>Media Publikasi</th>
						<th align='center' style='padding: 5px;' width='100'>Status Validasi DIKTI</th>
					</tr>";
					$no = 1;
					$sql = $db->database_prepare("SELECT * FROM as_publikasi_dosen A INNER JOIN msdos B ON B.IDDOSMSDOS=A.dosen_id ORDER BY B.NODOSMSDOS ASC")->execute();
					while ($data = $db->database_fetch_array($sql)){
						if ($data['jenis_penelitian'] == 'A'){
							$jenis_penelitian = "Hasil Penelitian";
						}
						else{
							$jenis_penelitian = "Non Penelitian";
						}
						
						if ($data['hasil_penelitian'] == '1'){
							$hasil_penelitian = "Paper/Makalah";
						}
						elseif ($data['hasil_penelitian'] == '2'){
							$hasil_penelitian = "Buku";
						}
						elseif ($data['hasil_penelitian'] == '3'){
							$hasil_penelitian = "HKI";
						}
						else{
							$hasil_penelitian = "HKI Komersialisasi";
						}
						
						if ($data['media_publikasi'] == 'A'){
							$media_publikasi = "Majalah Populer/Koran";
						}
						elseif ($data['media_publikasi'] == 'B'){
							$media_publikasi = "Seminar Nasional";
						}
						elseif ($data['media_publikasi'] == 'C'){
							$media_publikasi = "Seminar Internasional";
						}
						elseif ($data['media_publikasi'] == 'D'){
							$media_publikasi = "Prosiding (ISBN)";
						}
						elseif ($data['media_publikasi'] == 'E'){
							$media_publikasi = "Jurnal Nasional Belum Akreditasi";
						}
						elseif ($data['media_publikasi'] == 'F'){
							$media_publikasi = "Jurnal Nasional Terakreditasi";
						}
						else{
							$media_publikasi = "Jurnal Internasional";
						}
						
						if ($data['status_validasi'] == '1'){
							$status_validasi = "Belum diverifikasi";
						}
						elseif ($data['status_validasi'] == '2'){
							$status_validasi = "Sudah diverifikasi namun masih terdapat data yang invalid";
						}
						else{
							$status_validasi = "Sudah diverifikasi dan data sudah valid";
						}
									
						$content .= "
							<tr>
								<td style='padding: 5px;'>$no</td>
								<td style='padding: 5px;'>$data[NODOSMSDOS]</td>
								<td style='padding: 5px;'>$data[NMDOSMSDOS]</td>
								<td style='padding: 5px;' align='center'>$data[GELARMSDOS]</td>
								<td style='padding: 5px;'>$jenis_penelitian</td>
								<td style='padding: 5px;'>$hasil_penelitian</td>
								<td align='center' style='padding: 5px;'>$media_publikasi</td>
								<td align='center' style='padding: 5px;'>$status_validasi</td>
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