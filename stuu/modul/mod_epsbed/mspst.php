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
	$filename="msyys.pdf";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = tgl_indo($now);
	
	$data_pti = $db->database_fetch_array($db->database_prepare("SELECT * FROM mspti")->execute());
	$tgl_akta = tgl_indo($data_pti['TGPTIMSPTI']);
	$awal_berdiri = tgl_indo($data_pti['TGAWLMSPTI']);
	
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
						<td align='center' width='1000'><h4>Master Program Studi</h4></td>
					</tr>
				</table>
				<br>
				<table cellpadding=0 cellspacing=0 border=1>
					<tr>
						<th width=30 style='padding: 5px;'>No</th>
						<th width='100' align='center' style='padding: 5px;'>Kode</th>
						<th align='center' style='padding: 5px;'>Jenjang Studi</th>
						<th align='center' style='padding: 5px;' width='200'>Nama Program Studi</th>
						<th align='center' style='padding: 5px;' width='120'>No. SK DIKTI</th>
						<th align='center' style='padding: 5px;' width='120'>Tgl. SK DIKTI</th>
						<th align='center' style='padding: 5px;' width='100'>Status</th>
					</tr>";
					$no = 1;
					$sql = $db->database_prepare("SELECT * FROM mspst")->execute();
					while ($data = $db->database_fetch_array($sql)){
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
						
						$tgl = tgl_indo($data['TGLSKMSPST']);
						
						if ($data['STATUMSPST'] == 'A'){
							$status = "Aktif";
						}
						elseif ($data['STATUMSPST'] == 'H'){
							$status = "Hapus";
						}
						else{
							$status = "Non-Aktif";
						}
									
						$content .= "
							<tr>
								<td style='padding: 5px;'>$no</td>
								<td style='padding: 5px;'>$data[KDPSTMSPST]</td>
								<td align='center' style='padding: 5px;'>$kd_jenjang_studi</td>
								<td style='padding: 5px;'>$data[NMPSTMSPST]</td>
								<td style='padding: 5px;'>$data[NOMSKMSPST]</td>
								<td style='padding: 5px;'>$tgl</td>
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