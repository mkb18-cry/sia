<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	var htmlobjek;
	$(document).ready(function() {
		$('#frm_rekap').validate({
			rules:{
				prodi: true,
				kelas: true,
				makul: true,
				semester: true
			},
			messages:{
				prodi:{
					required: "Masukan NIM terlebih dahulu."
				},
				kelas:{
					required: "Masukkan kelas terlebih dahulu."
				},
				makul:{
					required: "Masukkan mata kuliah terlebih dahulu."
				},
				semester:{
					required: "Semester wajib diisi."
				}
			}
		});
		
		$("#prodi").change(function(){
			var prodi = $("#prodi").val();
			$.ajax({
				url: "modul/mod_kartu/ambilkelas.php",
				data: "prodi="+prodi,
				cache: false,
				success: function(msg){
					$("#kelas").html(msg);
				}
			});
		});
		
		$("#kelas").change(function(){
			var kelas = $("#kelas").val();
			$.ajax({
				url: "modul/mod_kartu/ambilmakul.php",
				data: "kelas="+kelas,
				cache: false,
				success: function(msg){
					$("#makul").html(msg);
				}
			});
		});
	});
</script>
<?php
switch($_GET['act']){
	default:
?>
	<h5>Rekap IPK dan IP Semester</h5>
	<div class="box round first fullpage">
		<div class="block ">
		<form action="" method="GET" id="frm_rekap">
		<input type="hidden" name="mod" value="rekap_ip">
		<input type="hidden" name="act" value="data">
		<table class='form'>
			<tr valign="top">
				<td width="200"><label>Program Studi</label></td>
				<td><select name='prodi' id='prodi' class='required'>
					<option value=''>- none -</option>
					<?php
						$sql_prodi = $db->database_prepare("SELECT KDJENMSPST,IDPSTMSPST,NMPSTMSPST FROM mspst WHERE STATUMSPST = 'A'")->execute();
						while ($data_prodi = $db->database_fetch_array($sql_prodi)){
							if ($data_prodi['KDJENMSPST'] == 'A'){
								$kd_jenjang_studi = "S3";
							}
							elseif ($data_prodi['KDJENMSPST'] == 'B'){
								$kd_jenjang_studi = "S2";
							}
							elseif ($data_prodi['KDJENMSPST'] == 'C'){
								$kd_jenjang_studi = "S1";
							}
							elseif ($data_prodi['KDJENMSPST'] == 'D'){
								$kd_jenjang_studi = "D4";
							}
							elseif ($data_prodi['KDJENMSPST'] == 'E'){
								$kd_jenjang_studi = "D3";
							}
							elseif ($data_prodi['KDJENMSPST'] == 'F'){
								$kd_jenjang_studi = "D2";
							}
							elseif ($data_prodi['KDJENMSPST'] == 'G'){
								$kd_jenjang_studi = "D1";
							}
							elseif ($data_prodi['KDJENMSPST'] == 'H'){
								$kd_jenjang_studi = "Sp-1";
							}
							elseif ($data_prodi['KDJENMSPST'] == 'I'){
								$kd_jenjang_studi = "Sp-2";
							}
							else{
								$kd_jenjang_studi = "Profesi";
							}
							echo "<option value=$data_prodi[IDPSTMSPST]>$kd_jenjang_studi - $data_prodi[NMPSTMSPST]</option>";
						}
						?>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<td><label>Kelas</label></td>
				<td><select name='kelas' id='kelas' class='required'>
						<option value=''>- none -</option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<td><label>Semester</label></td>
				<td><input type="text" name="semester" maxlength="1" class="required"></td>
			</tr>
			<tr valign="top">
				<td></td>
				<td><button type="submit" class="btn btn-primary">Lanjutkan</button></td>
			</tr>
		</table>
		</form>
		</div>
	</div>
<?php

	break;
	
	case "data":
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
	elseif ($data_mhs['KDJENMSPST'] == 'J'){
		$kd_jenjang_studi = "Profesi";
	}
	echo "<a href='index.php?mod=nilai'><img src='../images/back.png'></a>
		<h5>Rekap IPK dan IP Semester</h5>
		<div class='box round first fullpage'>
		<div class='block '>
			<table class='form'>
				<tr valign='top'>
					<td width='200'>Program Studi</td>
					<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST]</b></td>
				</tr>
				<tr valign='top'>
					<td>Kelas/Semester</td>
					<td><b>$data_mhs[nama_kelas] - $data_mhs[semester] / $_GET[semester]<input type='hidden' name='kelas_id' value='$data_mhs[kelas_id]'></b></td>
				</tr>
			</table>
		</div></div>
			<table class='data display datatable' id='example'>
				<thead>
					<tr>
						<th width='30'>No</th>
						<th width='100'>NIM</th>
						<th width='270'>Nama Mahasiswa</th>
						<th width='70'>IP</th>
						<th align='left'>IPK</th>
					</tr>
				</thead><tbody>
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
				
	
				echo "<tr>
						<td>$i</td>
						<td>$data_rekap[NIM]</td>
						<td>$data_rekap[nama_mahasiswa]</td>
						<td>$ip</td>
						<td>$ipk</td>
					</tr>";
				
				$i++;
			}
			echo "</tbody></table><p>&nbsp;</p><p>&nbsp;</p>";
	echo "<a target='_blank' href='modul/mod_nilai/export_rekap.php?prodi=$_GET[prodi]&kelas=$_GET[kelas]&semester=$_GET[semester]'><button type='button' class='btn btn-green'>Export Rekap</button></a>";
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