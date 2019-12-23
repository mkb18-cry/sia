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
	$filename="transkip.pdf";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = tgl_indo($now);
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_mahasiswa A INNER JOIN mspst B ON A.kode_program_studi=B.IDPSTMSPST
										INNER JOIN as_kelas_mahasiswa C ON C.id_mhs=A.id_mhs
										INNER JOIN as_kelas D ON D.kelas_id=C.kelas_id
										LEFT JOIN msdos E ON B.NOKPSMSPST = E.IDDOSMSDOS
										WHERE A.id_mhs = ?")->execute($_GET['id']));
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
	
	$tanggal_lahir = tgl_indo($data_mhs['tanggal_lahir']);
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
						<td colspan='3' align='center'><br><p><b><u>TRANSKIP NILAI AKADEMIK</u></b></p></td>
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
						<td>Tempat/Tanggal Lahir</td>
						<td>:</td>
						<td><b>$data_mhs[tempat_lahir], $tanggal_lahir</b></td>
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
				<table cellpadding=0 border='0' cellspacing=0>
					<tr>
						<th width='15' rowspan='2' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'>No</th>
						<th rowspan='2' align='center' width='120' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'>Kode Matakuliah</th>
						<th rowspan='2' align='center' width='230' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'>Mata Kuliah</th>
						<th rowspan='2' align='center' width='50' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'>SKS</th>
						<th colspan='2' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;' align='center'>NILAI</th>
						<th width='100' align='center' rowspan='2' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'>Jumlah</th>
					</tr>
					<tr>
						<th align='center' width='50' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'>Huruf</th>
						<th align='center' width='50' style='border:1px solid #000; background-color: #9CCC68; padding: 2px;'>Bobot</th>
					</tr>
			";
			$i = 1;
			$sql_sql = $db->database_prepare("SELECT B.sks_mata_kuliah, B.kode_mata_kuliah, B.nama_mata_kuliah_eng, C.semester, A.tugas, A.uts, A.uas, A.total, C.jadwal_id 
													FROM as_nilai_semester_mhs A INNER JOIN as_makul B ON B.mata_kuliah_id=A.makul_id
													INNER JOIN as_jadwal_kuliah C ON C.makul_id=B.mata_kuliah_id WHERE A.id_mhs = ?
													GROUP BY A.makul_id")->execute($_GET["id"]);
			while ($data_nilai = $db->database_fetch_array($sql_sql)){
				$abs_hadir = $db->database_num_rows($db->database_prepare("SELECT * FROM as_absensi_mhs WHERE jadwal_id = ? AND id_mhs = ? AND paraf = 'H'")->execute($data_nilai['jadwal_id'],$data_mhs['id_mhs']));
				$abs_total = $db->database_num_rows($db->database_prepare("SELECT * FROM as_absensi_mhs WHERE jadwal_id = ? AND id_mhs = ?")->execute($data_nilai['jadwal_id'],$data_mhs['id_mhs']));
				$nilai_abs = ($abs_hadir / $abs_total) * 10;
				$nilai_tugas= ($data_nilai['tugas'] / 100) * 40;
				$nilai_uts	= ($data_nilai['uts'] / 100) * 20;
				$nilai_uas	= ($data_nilai['uas'] / 100) * 30;
				
				$nilai = $nilai_abs + $nilai_tugas + $nilai_uas + $nilai_uts;
				
				if ($nilai >= 85 AND $nilai <= 100){
					$mutu = "A";
					$bobot = "4";
				}
				elseif ($nilai >= 80 AND $nilai <= 84.9){
					$mutu = "A-";
					$bobot = "3.75";
				}
				elseif ($nilai >= 75 AND $nilai <= 79.9){
					$mutu = "B+";
					$bobot = "3.25";
				}
				elseif ($nilai >= 70 AND $nilai <= 74.9){
					$mutu = "B";
					$bobot = "3";
				}
				elseif ($nilai >= 65 AND $nilai <= 69.9){
					$mutu = "B-";
					$bobot = "2.75";
				}
				elseif ($nilai >= 60 AND $nilai <= 64.9){
					$mutu = "C+";
					$bobot = "2.25";
				}
				elseif ($nilai >= 55 AND $nilai <= 59.9){
					$mutu = "C";
					$bobot = "2";
				}
				elseif ($nilai >= 50 AND $nilai <= 54.9){
					$mutu = "C-";
					$bobot = "1.75";
				}
				elseif ($nilai >= 45 AND $nilai <= 49.9){
					$mutu = "D";
					$bobot = "1";
				}
				elseif ($nilai < 45){
					$mutu = "E";
					$bobot = "0";
				}	
				
				$total_bobot = $data_nilai['sks_mata_kuliah'] * $bobot;
					
				$content .= "<tr>
							<td style='border:1px solid #000; padding: 2px;'>$i</td>
							<td style='border:1px solid #000; padding: 2px;' align='center'>$data_nilai[kode_mata_kuliah]</td>
							<td style='border:1px solid #000; padding: 2px;'>$data_nilai[nama_mata_kuliah_eng]</td>
							<td style='border:1px solid #000; padding: 2px;' align='center'>$data_nilai[sks_mata_kuliah]</td>
							<td style='border:1px solid #000; padding: 2px;' align='center'>$mutu</td>
							<td style='border:1px solid #000; padding: 2px;' align='center'>$bobot</td>
							<td style='border:1px solid #000; padding: 2px;' align='center'>$total_bobot</td>
						</tr>";
				$grand_sks += $data_nilai['sks_mata_kuliah'];
				$grand_bobot += $total_bobot;
				$i++;
			}				
			$ipk = number_format($grand_bobot / $grand_sks, 2);
			$nip = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_users WHERE user_id = ?")->execute($_SESSION["userid"]));
			$content .= "
					</table>
					<br>
					<table>
						<tr>
							<td width='160'>Jumlah SKS</td>
							<td>: <b>$grand_sks SKS</b></td>
						</tr>
						<tr>
							<td>Jumlah (SKS x Nilai)</td>
							<td>: <b>$grand_bobot</b></td>
						</tr>
						<tr>
							<td>Indeks prestasi kumulatif</td>
							<td>: <b>$ipk</b></td>
						</tr>
					</table>
					<table>
						<tr>
							<td width='400'></td>
							<td align='center'>Cirebon, $date_now<br><br>
							Universitas ASFA Solution<br>
							Kepala Program Studi<br>
								<p>&nbsp;</p><p>&nbsp;</p>
								$data_mhs[NMDOSMSDOS] $data_mhs[GELARMSDOS]<br>
								<b>NIP. $data_mhs[NODOSMSDOS]</b> 
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