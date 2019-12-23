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
	
	$data_yys = $db->database_fetch_array($db->database_prepare("SELECT * FROM msyys")->execute());
	$awal_berdiri = tgl_indo($data_yys['TGLAWLMSYYS']);
	$tgl_sah = tgl_indo($data_yys['TGLBNMSYYS']);
	$tgl_akta = tgl_indo($data_yys['TGYYSMSYYS']);
	
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
						<td align='center' width='600'><h4>Master Yayasan</h4></td>
					</tr>
				</table>
				<br>
				<table cellpadding=0 cellspacing=0>
					<tr>
						<td style='padding: 5px;'>Kode Badan Hukum PT</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_yys[KDYYSMSYYS]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>Nama Badan Hukum PT</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_yys[NMYYSMSYYS]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>Alamat 1</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_yys[ALMT1MSYYS]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>Alamat 2</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_yys[ALMT2MSYYS]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>Kota</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_yys[KOTAAMSYYS]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>Kode Pos</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_yys[KDPOSMSYYS]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>Telepon</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_yys[TELPOMSYYS]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>Faksimil</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_yys[FAKSIMSYYS]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>TG AKTA/SK Terakhir</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$tgl_akta</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>Nomor Akta/SK Yayasan Terakhir</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_yys[NOBMNMSYYS]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>TG Pengesahan PN Terakhir</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$tgl_sah</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>Email</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_yys[EMAILMSYYS]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>Website</td>
						<td style='padding: 5px;'>:</td>
						<td style='padding: 5px;'>$data_yys[HPAGEMSYYS]</td>
					</tr>
					<tr>
						<td style='padding: 5px;'>TG Awal Pendirian Badan Hukum</td>
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