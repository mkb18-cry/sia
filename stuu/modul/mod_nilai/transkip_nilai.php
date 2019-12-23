<script type='text/javascript' src='../js/jquery.validate.js'></script>
<script type='text/javascript' src="../js/jquery.autocomplete.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.autocomplete.css" />
		
<script type='text/javascript'>
	$(document).ready(function() {
		$('#frm_transkip').validate({
			rules:{
				nim: true
			},
			messages:{
				nim:{
					required: "Masukan NIM terlebih dahulu."
				}
			}
		});
		
		$("#getnim").autocomplete("modul/mod_nilai/getnim.php", {
			width: 260,
			matchContains: true,
			selectFirst: false
		});
	});
</script>
<?php
switch($_GET['act']){
	default:
?>
	<h5>Transkip Nilai</h5>
	<div class="box round first fullpage">
		<div class="block ">
			<form action="" method="GET" id="frm_transkip">
			<input type="hidden" name="mod" value="transkip_nilai">
			<input type="hidden" name="act" value="data">
			<table class="form">
				<tr valign="top">
					<td width="100"><label>NIM</label></td>
					<td><input type="text" name="nim" class="required" id="getnim" size="40"></td>
				</tr>
				<tr valign="top">
					<td></td>
					<td><button type='submit' class='btn btn-primary'>Lanjutkan</button></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
<?php

	break;
	
	case "data":
	$n = explode("-", $_GET['nim']);
	$nim = $n[0];
	$sql_mhs = $db->database_prepare("SELECT * FROM as_mahasiswa A INNER JOIN mspst B ON A.kode_program_studi=B.IDPSTMSPST
										INNER JOIN as_kelas_mahasiswa C ON C.id_mhs=A.id_mhs
										INNER JOIN as_kelas D ON D.kelas_id=C.kelas_id
										WHERE A.NIM = ?")->execute($nim);
	$nums_mhs = $db->database_num_rows($sql_mhs);
	$data_mhs = $db->database_fetch_array($sql_mhs);
	if ($nums_mhs == 0){
		echo "<div class='message error'>
				<h5>Failed!</h5>
				<p>NIM tidak ditemukan. <br><a href='index.php?mod=transkip_nilai' style='color: #BE4741;'>Back</a></p>
			</div>";
	}
	else{
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
		echo "<a href='index.php?mod=transkip_nilai'><img src='../images/back.png'></a>
			<h5>Transkip Nilai</h5>
			<div class='box round first fullpage'>
				<div class='block '>
				<table class='form'>
					<tr>
						<td width='100'>Program Studi</td>
						<td width='5'>:</td>
						<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST]</b></td>
					</tr>
					<tr valign='top'>
						<td>Kelas/Semester</td>
						<td>:</td>
						<td><b>$data_mhs[nama_kelas] - $data_mhs[semester] <input type='hidden' name='kelas_id' value='$data_mhs[kelas_id]'></b></td>
					</tr>
					<tr valign='top'>
						<td>NIM</td>
						<td>:</td>
						<td><b>$data_mhs[NIM]</b></td>
					</tr>
					<tr valign='top'>
						<td>Nama</td>
						<td>:</td>
						<td><b>$data_mhs[nama_mahasiswa]</b></td>
				</table>
				</div></div>
				<table class='data display datatable' id='example'>
					<thead>
						<tr>
							<th width='30'>No</th>
							<th width='85'>Kode MK</th>
							<th width='250'>Mata Kuliah</th>
							<th width='50'>Sms</th>
							<th width='90'>Jml. SKS</th>
							<th width='50'>UTS</th>
							<th width='50'>UAS</th>
							<th width='60'>Total</th>
							<th width='100'>Mutu</th>
							<th width='100'>Bobot</th>
							<th width='100'>Total Bobot</th>
						</tr>
					</thead><tbody>";
					$i = 1;
				$sql_data = $db->database_prepare("SELECT B.sks_mata_kuliah, B.kode_mata_kuliah, B.nama_mata_kuliah_eng, C.semester, A.tugas, A.uts, A.uas, A.total, C.jadwal_id 
													FROM as_nilai_semester_mhs A INNER JOIN as_makul B ON B.mata_kuliah_id=A.makul_id
													INNER JOIN as_jadwal_kuliah C ON C.makul_id=B.mata_kuliah_id WHERE A.id_mhs = ?
													GROUP BY A.makul_id")->execute($data_mhs['id_mhs']);
				while ($data_data = $db->database_fetch_array($sql_data)){
					$abs_hadir = $db->database_num_rows($db->database_prepare("SELECT * FROM as_absensi_mhs WHERE jadwal_id = ? AND id_mhs = ? AND paraf = 'H'")->execute($data_data['jadwal_id'],$data_mhs['id_mhs']));
					$abs_total = $db->database_num_rows($db->database_prepare("SELECT * FROM as_absensi_mhs WHERE jadwal_id = ? AND id_mhs = ?")->execute($data_data['jadwal_id'],$data_mhs['id_mhs']));
					$nilai_abs = ($abs_hadir / $abs_total) * 10;
					$nilai_tugas= ($data_data['tugas'] / 100) * 40;
					$nilai_uts	= ($data_data['uts'] / 100) * 20;
					$nilai_uas	= ($data_data['uas'] / 100) * 30;
					
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
					
					$total_bobot = $data_data['sks_mata_kuliah'] * $bobot;
					
					echo "<tr>
							<td>$i</td>
							<td>$data_data[kode_mata_kuliah]</td>
							<td>$data_data[nama_mata_kuliah_eng]</td>
							<td>$data_data[semester]</td>
							<td>$data_data[sks_mata_kuliah]</td>
							<td>$data_data[uts]</td>
							<td>$data_data[uas]</td>
							<td>$data_data[total]</td>
							<td>$mutu</td>
							<td>$bobot</td>
							<td>$total_bobot</td>
						</tr>";
					$total_sks += $data_data['sks_mata_kuliah'];
					$bobot += $bobot;
					$bobot_total += $total_bobot;
					$i++;
				}
			echo "</tbody></table>";
			
			$ipk = number_format($bobot_total / $total_sks,2);
			echo "
				<table class='form'>
					<tr valign=top>
						<td width='130'>Total SKS</td>
						<td>: <b>$total_sks</b> SKS</td>
					</tr>
					<tr valign=top>
						<td>Total Bobot Kumulatif </td>
						<td>: <b>$bobot_total</b></td>
					</tr>
					<tr valign=top>
						<td>IP Kumulatif</td>
						<td>: <b>$ipk</b></td>
					</tr>
				</table>
	";
	}
	echo "<a target='_blank' href='modul/mod_nilai/export_transkip.php?id=$data_mhs[id_mhs]'><button type='button' class='btn btn-green'>Export Transkip</button></a>";
	break;
	
	case "preview":
	$kelas = explode("%", $_GET['kelas']);
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_kelas B ON A.kelas_id=B.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id 
														INNER JOIN mspst D ON D.IDPSTMSPST=B.prodi_id
														INNER JOIN msdos E ON E.IDDOSMSDOS=A.dosen_id
														INNER JOIN as_ruang F ON F.ruang_id=A.ruang_id
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																B.angkatan_id = ? LIMIT 1")->execute($_GET['makul'],$kelas[0],$kelas[2]));
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
	echo "<p>&nbsp;</p><a href='index.php?mod=nilai_semester'><img src='../images/back.png'></a>
		<h4>Hasil Entri Data Nilai Semester</h4>
		<div class='well'>
			<table>
				<tr>
					<td width='100'>Program Studi</td>
					<td width='5'>:</td>
					<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST] <input type='hidden' name='kelas' value='$_GET[kelas]'><input type='hidden' name='prodi' value='$_GET[prodi]'><input type='hidden' name='makul' value='$_GET[makul]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Kelas/Semester</td>
					<td>:</td>
					<td><b>$data_mhs[nama_kelas] - $data_mhs[semester] <input type='hidden' name='kelas_id' value='$data_mhs[kelas_id]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Dosen</td>
					<td>:</td>
					<td><b>$data_mhs[NMDOSMSDOS] $data_mhs[GELARMSDOS]</b></td>
				</tr>
				<tr valign='top'>
					<td>Ruang</td>
					<td>:</td>
					<td><b>$data_mhs[nama_ruang]</b></td>
				</tr>
			</table>
			<br>
			<table>
				<tr bgcolor='#B7D577'>
					<th width='25'>No.</th>
					<th align='center' width='140'>NIM</th>
					<th align='center' width='300'>Nama Mahasiswa</th>
					<th align='center' width='60'>UTS</th>
					<th align='center' width='60'>UAS</th>
					<th align='center' width='60'>Total</th>
					<th width='120' align='center'>Huruf Mutu</th>
				</tr>";
				$i = 1;
			$sql_data = $db->database_prepare("SELECT * FROM as_nilai_semester_mhs A 
														INNER JOIN as_kelas B ON B.kelas_id=A.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id
														INNER JOIN as_mahasiswa D ON D.id_mhs=A.id_mhs
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																C.angkatan_id = ?")->execute($_GET['makul'],$kelas[0],$kelas[2]);
			while ($data_data = $db->database_fetch_array($sql_data)){
				if ($i % 2 == 1){
					$bg = "#CCCCCC";
				}
				else{
					$bg = "#FFFFFF";
				}
				
				if ($data_data['mutu'] == ''){
					$mutu = "-";
				}
				else{
					$mutu = $data_data['mutu'];
				}
				
				echo "<tr>
						<td bgcolor=$bg>$i</td>
						<td bgcolor=$bg>$data_data[NIM]</td>
						<td bgcolor=$bg>$data_data[nama_mahasiswa]</td>
						<td align='center' bgcolor=$bg>$data_data[uts]</td>
						<td align='center' bgcolor=$bg>$data_data[uas]</td>
						<td align='center' bgcolor=$bg>$data_data[total]</td>
						<td align='center' bgcolor=$bg>$mutu</td>
					</tr>";
				$i++;
			}
		echo "</thead></table></div>
		<div>
			<a href='index.php?mod=nilai_semester'><button type='button' class='btn btn-primary'>Keluar / Selesai</button></a>
		</div>
	";
	break;
	
	case "update_nilai":
	$kelas = explode("%", $_GET['kelas']);
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_kelas B ON A.kelas_id=B.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id 
														INNER JOIN mspst D ON D.IDPSTMSPST=B.prodi_id
														INNER JOIN msdos E ON E.IDDOSMSDOS=A.dosen_id
														INNER JOIN as_ruang F ON F.ruang_id=A.ruang_id
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																B.angkatan_id = ? LIMIT 1")->execute($_GET['makul'],$kelas[0],$kelas[2]));
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
	echo "<p>&nbsp;</p><a href='index.php?mod=nilai_semester'><img src='../images/back.png'></a>
		<h4>Data Nilai Semester</h4>
		<form method='POST' action='modul/mod_nilai/aksi_nilai.php?mod=nilai_semester&act=update'>
		<div class='well'>
			<table>
				<tr>
					<td width='100'>Program Studi</td>
					<td width='5'>:</td>
					<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST] <input type='hidden' name='kelas' value='$_GET[kelas]'><input type='hidden' name='prodi' value='$_GET[prodi]'><input type='hidden' name='makul' value='$_GET[makul]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Kelas/Semester</td>
					<td>:</td>
					<td><b>$data_mhs[nama_kelas] - $data_mhs[semester] <input type='hidden' name='kelas_id' value='$data_mhs[kelas_id]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Dosen</td>
					<td>:</td>
					<td><b>$data_mhs[NMDOSMSDOS] $data_mhs[GELARMSDOS]</b></td>
				</tr>
				<tr valign='top'>
					<td>Ruang</td>
					<td>:</td>
					<td><b>$data_mhs[nama_ruang]</b></td>
				</tr>
			</table>
			<br>
			<table>
				<tr bgcolor='#B7D577'>
					<th width='25'>No.</th>
					<th align='center' width='140'>NIM</th>
					<th align='center' width='300'>Nama Mahasiswa</th>
					<th align='center' width='60'>UTS</th>
					<th align='center' width='60'>UAS</th>
					<th align='center' width='60'>Total</th>
					<th width='120' align='center'>Huruf Mutu</th>
				</tr>";
				$i = 1;
			$sql_data = $db->database_prepare("SELECT * FROM as_nilai_semester_mhs A 
														INNER JOIN as_kelas B ON B.kelas_id=A.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id
														INNER JOIN as_mahasiswa D ON D.id_mhs=A.id_mhs
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																C.angkatan_id = ?")->execute($_GET['makul'],$kelas[0],$kelas[2]);
			while ($data_data = $db->database_fetch_array($sql_data)){
				if ($i % 2 == 1){
					$bg = "#CCCCCC";
				}
				else{
					$bg = "#FFFFFF";
				}
				
				if ($data_data['mutu'] == 'A'){
					$mutuA = "SELECTED";
				}
				else{
					$mutuA = "";
				}
				
				if ($data_data['mutu'] == 'B'){
					$mutuB = "SELECTED";
				}
				else{
					$mutuB = "";
				}
				
				if ($data_data['mutu'] == 'C'){
					$mutuC = "SELECTED";
				}
				else{
					$mutuC = "";
				}
				
				if ($data_data['mutu'] == 'D'){
					$mutuD = "SELECTED";
				}
				else{
					$mutuD = "";
				}
				
				if ($data_data['mutu'] == 'E'){
					$mutuE = "SELECTED";
				}
				else{
					$mutuE = "";
				}
				
				echo "<tr>
						<td bgcolor=$bg>$i <input type='hidden' name='nilai_id[]' value='$data_data[nilai_id]'></td>
						<td bgcolor=$bg>$data_data[NIM]</td>
						<td bgcolor=$bg>$data_data[nama_mahasiswa]</td>
						<td class='kecil' align='center' bgcolor=$bg><input type='text' name='uts[]' value='$data_data[uts]'></td>
						<td class='kecil' align='center' bgcolor=$bg><input type='text' name='uas[]' value='$data_data[uas]'></td>
						<td class='kecil' align='center' bgcolor=$bg><input type='text' name='total[]' value='$data_data[total]'></td>
						<td align='center' bgcolor=$bg>
							<select name='mutu[]'>
								<option value=''>- none -</option>
								<option value='A' $mutuA>A</option>
								<option value='B' $mutuB>B</option>
								<option value='C' $mutuC>C</option>
								<option value='D' $mutuD>D</option>
								<option value='E' $mutuE>E</option>
							</select>
						</td>
					</tr>";
				$i++;
			}
		echo "</thead></table></div>
		<div>
			<button type='submit' class='btn btn-primary'><i class='icon-save'></i> Simpan Perubahan</button>
		</div>
		</form>
	";
	break;
}
?>