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
						<td colspan='3' width='610'><hr></td>
					</tr>
				</table>
				<table>
					<tr>
						<td align='center' width='600'><h4>Master Perguruan Tinggi</h4></td>
					</tr>
				</table>
				<br>
				<table cellpadding=0 cellspacing=0>
					<tr>
						<td style='padding: 5px;'>Kode Yayasan</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_pti[KDYYSMSPTI]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>Kode Perguruan Tinggi</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_pti[KDPTIMSPTI]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>Nama Perguruan Tinggi</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_pti[NMPTIMSPTI]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>Alamat 1</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_pti[ALMT1MSPTI]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>Alamat 2</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_pti[ALMT2MSPTI]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>Kota</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_pti[KOTAAMSPTI]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>Kode Pos</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_pti[KDPOSMSPTI]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>Telepon</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_pti[TELPOMSPTI]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>Faksimil</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_pti[FAKSIMSPTI]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>TG AKTA/SK Pendirian Terakhir</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$tgl_akta</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>Nomor Akta/SK Pendirian Terakhir</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_pti[NOMSKMSPTI]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>Email</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_pti[EMAILMSPTI]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>Website</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_pti[HPAGEMSPTI]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>TG Awal Pendirian Perguruan Tinggi</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$awal_berdiri</td>
					</tr>
				</table>
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
		$html2pdf = new HTML2PDF('P','A4','en', false, 'ISO-8859-15',array(15, 15, 15, 15)); //setting ukuran kertas dan margin pada dokumen anda
		// $html2pdf->setModeDebug();
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($filename);
	}
	catch(HTML2PDF_exception $e) { echo $e; }
?>