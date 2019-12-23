<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Nilai berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Nilai berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Nilai berhasil dihapus.</p>
	</div>
<?php
}
?>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	var htmlobjek;
	$(document).ready(function() {
		$("#prodi").change(function(){
			var prodi = $("#prodi").val();
			$.ajax({
				url: "modul/mod_nilai/ambilkelas.php",
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
				url: "modul/mod_nilai/ambilmakul.php",
				data: "kelas="+kelas,
				cache: false,
				success: function(msg){
					$("#makul").html(msg);
				}
			});
		});
		
		$("#prodi2").change(function(){
			var prodi2 = $("#prodi2").val();
			$.ajax({
				url: "modul/mod_nilai/ambilkelas2.php",
				data: "prodi2="+prodi2,
				cache: false,
				success: function(msg){
					$("#kelas2").html(msg);
				}
			});
		});
		
		$("#kelas2").change(function(){
			var kelas2 = $("#kelas2").val();
			$.ajax({
				url: "modul/mod_nilai/ambilmakul2.php",
				data: "kelas2="+kelas2,
				cache: false,
				success: function(msg){
					$("#makul2").html(msg);
				}
			});
		});
		
		$('#frm_nilai').validate({
			rules:{
				prodi: true
			},
			messages:{
				prodi:{
					required: "Program studi wajib diisi."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h5>Nilai Semester</h5><br>
	<div class='well'>
		<ul id='menu2' class='menu2'>
			<li class='active'><a href='#home'>Entri Nilai</a></li>
			<li><a href='#buka-nilai'>Buka/Update Nilai</a></li>
		</ul>
		
		<div id='home' class='content2'>
			<p>
			<div class='box round first fullpage'>
				<div class='block '>
					<form action="" method="GET" id="frm_nilai">
					<input type="hidden" name="mod" value="nilai_semester">
					<input type="hidden" name="act" value="form">
					<table class='form'>
						<tr valign='top'>
							<td width="200"><label>Program Studi</label></td>
							<td><select name='prodi' id='prodi' class="required">
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
								echo "</select>
							</td>
						</tr>
						<tr>
							<td><label>Kelas</label></td>
							<td><select name='kelas' id='kelas'>
									<option value=''></option>
								</select>
							</td>
						</tr>
						<tr>
							<td><label>Mata Kuliah</label></td>
							<td><select id='makul' name='makul'>
									<option value=''></option>
								</select>
							</td>
						</tr>
						<tr valign='top'>
							<td></td>
							<td><button type='submit' class='btn btn-primary'>Lanjutkan</button></td>
						</tr>
					</table>
					</form>
				</div>
			</div>
			</p>
		</div>
		
		<div id='buka-nilai' class='content2'>
			<p>
			<div class='box round first fullpage'>
				<div class='block '>
					<form action='' method='GET' id='frm_nilai'>
					<input type='hidden' name='mod' value='nilai_semester'>
					<input type='hidden' name='act' value='update_nilai'>
					<table class='form'>
						<tr valign='top'>
							<td width='200'><label>Program Studi</label></td>
							<td><select name='prodi' id='prodi2' class='required'>
									<option value=''>- none -</option>";
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
								echo "</select>
							</td>
						</tr>
						<tr>
							<td><label>Kelas</label></td>
							<td><select name='kelas' id='kelas2'>
									<option value=''></option>
								</select>
							</td>
						</tr>
						<tr>
							<td><label>Mata Kuliah</label></td>
							<td><select id='makul2' name='makul'>
									<option value=''></option>
								</select>
							</td>
						</tr>
						<tr valign='top'>
							<td></td>
							<td><button type='submit' class='btn btn-primary'>Lanjutkan</button></td>
						</tr>
					</table>
					</form>
				</div>
			</div>
			</p>
		</div>
	</div>";
	break;
	
	case "form":
	$kelas = explode("*", $_GET['kelas']);
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_kelas B ON A.kelas_id=B.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id 
														INNER JOIN mspst D ON D.IDPSTMSPST=B.prodi_id
														INNER JOIN msdos E ON E.IDDOSMSDOS=A.dosen_id
														INNER JOIN as_ruang F ON F.ruang_id=A.ruang_id
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																B.angkatan_id = ? LIMIT 1")->execute($_GET['makul'],$kelas[0],$kelas[2]));
	$data_makul = $db->database_fetch_array($db->database_prepare("SELECT kode_mata_kuliah,nama_mata_kuliah_eng FROM as_makul WHERE mata_kuliah_id = ?")->execute($_GET['makul']));
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
	echo "<a href='index.php?mod=nilai_semester'><img src='../images/back.png'></a>
		<h5>Entri Data Nilai Semester</h5>
		<form method='POST' action='modul/mod_nilai/aksi_nilai.php?mod=nilai_semester&act=input'>
		<div class='well'>
			<div class='box round first fullpage'>
				<div class='block '>
					<table class='form'>
					<tr>
						<td width='100'>Program Studi</td>
						<td width='5'>:</td>
						<td><b><input type='hidden' name='sms' value='$data_mhs[semester]'> $kd_jenjang_studi - $data_mhs[NMPSTMSPST] <input type='hidden' name='kelas' value='$_GET[kelas]'><input type='hidden' name='prodi' value='$_GET[prodi]'><input type='hidden' name='makul' value='$_GET[makul]'></b></td>
					</tr>
					<tr valign='top'>
						<td>Kelas/Semester</td>
						<td>:</td>
						<td><b>$data_mhs[nama_kelas] - $data_mhs[semester] <input type='hidden' name='kelas_id' value='$data_mhs[kelas_id]'></b></td>
					</tr>
					<tr valign='top'>
						<td>Mata Kuliah</td>
						<td>:</td>
						<td><b>$data_makul[kode_mata_kuliah] - $data_makul[nama_mata_kuliah_eng]</b></td>
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
			</div>
		</div>
			
		<table class='data display datatable' id='example'>
			<thead>
			<tr>
				<th width='30'>No</th>
				<th width='140'>NIM</th>
				<th width='250'>Nama Mahasiswa</th>
				<th width='100'>Absensi (10%)</th>
				<th width='90'>Tugas (40%)</th>
				<th width='80'>UTS (20%)</th>
				<th width='80'>UAS (30%)</th>
			</tr>
			</thead><tbody>";
			$i = 1;
		$sql_data = $db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_krs B ON B.jadwal_id=A.jadwal_id
													INNER JOIN as_kelas C ON C.kelas_id=A.kelas_id
													INNER JOIN as_angkatan D ON C.angkatan_id=C.angkatan_id
													INNER JOIN as_mahasiswa E ON E.id_mhs=B.id_mhs
													WHERE 	A.makul_id=? AND
															A.kelas_id=? AND
															C.angkatan_id = ? AND
															A.semester = ? GROUP BY B.id_mhs")->execute($_GET['makul'],$kelas[0],$kelas[2],$kelas[1]);
		while ($data_data = $db->database_fetch_array($sql_data)){
			$nums = $db->database_num_rows($db->database_prepare("SELECT * FROM as_nilai_semester_mhs WHERE id_mhs = ? AND makul_id = ?")->execute($data_data["id_mhs"],$_GET["makul"]));
			
			if ($nums == 0){
				$abs_hadir = $db->database_num_rows($db->database_prepare("SELECT * FROM as_absensi_mhs WHERE jadwal_id = ? AND id_mhs = ? AND paraf = 'H'")->execute($data_data['jadwal_id'],$data_data['id_mhs']));
				$abs_total = $db->database_num_rows($db->database_prepare("SELECT * FROM as_absensi_mhs WHERE jadwal_id = ? AND id_mhs = ?")->execute($data_data['jadwal_id'],$data_data['id_mhs']));
				$nilai_abs = ($abs_hadir / $abs_total) * 10;
				
				echo "<tr>
						<td>$i</td>
						<td>$data_data[NIM] <input type='hidden' name='id_mhs[]' value='$data_data[id_mhs]'></td>
						<td>$data_data[nama_mahasiswa]</td>
						<td><input type='text' name='absensi[]' size='5' value='$nilai_abs' DISABLED><input type='hidden' name='absensi[]' size='5' value='$nilai_abs'></td>
						<td><input type='text' name='tugas[]' value='0' size='5'></td>
						<td><input type='text' name='uts[]' value='0' size='5'></td>
						<td><input type='text' name='uas[]' value='0' size='5'></td>
					</tr>";
			}
			$i++;
		}
	echo "</tbody></table><p>&nbsp;</p><p>&nbsp;</p>";
	if ($nums == 0){
		echo "	<div>
				<button type='submit' class='btn btn-primary'>Simpan Nilai</button>
			</div>";
	}
	echo "	</div>
	</form>
	";
	break;
	
	case "preview":
	$kelas = explode("*", $_GET['kelas']);
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_kelas B ON A.kelas_id=B.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id 
														INNER JOIN mspst D ON D.IDPSTMSPST=B.prodi_id
														INNER JOIN msdos E ON E.IDDOSMSDOS=A.dosen_id
														INNER JOIN as_ruang F ON F.ruang_id=A.ruang_id
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																B.angkatan_id = ? LIMIT 1")->execute($_GET['makul'],$kelas[0],$kelas[2]));
	$data_makul = $db->database_fetch_array($db->database_prepare("SELECT kode_mata_kuliah,nama_mata_kuliah_eng FROM as_makul WHERE mata_kuliah_id = ?")->execute($_GET['makul']));
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
	echo "<a href='index.php?mod=nilai_semester'><img src='../images/back.png'></a>
		<h5>Hasil Entri Data Nilai Semester</h5>
		<div class='well'>
			<div class='box round first fullpage'>
				<div class='block '>
					<table class='form'>
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
							<td>Mata Kuliah</td>
							<td>:</td>
							<td><b>$data_makul[kode_mata_kuliah] - $data_makul[nama_mata_kuliah_eng]</b></td>
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
				</div>
			</div>
			
			<table class='data display datatable' id='example'>
				<thead>
				<tr>
					<th width='30'>No.</th>
					<th width='100'>NIM</th>
					<th width='250'>Nama Mahasiswa</th>
					<th width='115'>Absensi (10%)</th>
					<th width='105'>Tugas (40%)</th>
					<th width='90'>UTS (20%)</th>
					<th width='90'>UAS (30%)</th>
					<th width='60'>Total</th>
					<th width='60'>Nilai</th>
					<th width='60'>Bobot</th>
				</tr></thead><tbody>";
				$i = 1;
			$sql_data = $db->database_prepare("SELECT * FROM as_nilai_semester_mhs A 
														INNER JOIN as_kelas B ON B.kelas_id=A.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id
														INNER JOIN as_mahasiswa D ON D.id_mhs=A.id_mhs
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																C.angkatan_id = ?")->execute($_GET['makul'],$kelas[0],$kelas[2]);
			while ($data_data = $db->database_fetch_array($sql_data)){
				
				$abs_hadir = $db->database_num_rows($db->database_prepare("SELECT * FROM as_absensi_mhs WHERE jadwal_id = ? AND id_mhs = ? AND paraf = 'H'")->execute($data_mhs['jadwal_id'],$data_data['id_mhs']));
				$abs_total = $db->database_num_rows($db->database_prepare("SELECT * FROM as_absensi_mhs WHERE jadwal_id = ? AND id_mhs = ?")->execute($data_mhs['jadwal_id'],$data_data['id_mhs']));
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
				
				echo "<tr>
						<td>$i</td>
						<td>$data_data[NIM]</td>
						<td>$data_data[nama_mahasiswa]</td>
						<td>$data_data[absensi]</td>
						<td>$data_data[tugas]</td>
						<td>$data_data[uts]</td>
						<td>$data_data[uas]</td>
						<td>$data_data[total]</td>
						<td>$mutu</td>
						<td>$bobot</td>
					</tr>";
				$i++;
			}
		echo "</tbody></table><p>&nbsp;</p><p>&nbsp;</p>
		<div>
			<a href='index.php?mod=nilai_semester'><button type='button' class='btn btn-primary'>Keluar / Selesai</button></a>
		</div>
	</div>	
	";
	break;
	
	case "update_nilai":
	$kelas = explode("*", $_GET['kelas']);
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_kelas B ON A.kelas_id=B.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id 
														INNER JOIN mspst D ON D.IDPSTMSPST=B.prodi_id
														INNER JOIN msdos E ON E.IDDOSMSDOS=A.dosen_id
														INNER JOIN as_ruang F ON F.ruang_id=A.ruang_id
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																B.angkatan_id = ? LIMIT 1")->execute($_GET['makul'],$kelas[0],$kelas[2]));
	$data_makul = $db->database_fetch_array($db->database_prepare("SELECT kode_mata_kuliah,nama_mata_kuliah_eng FROM as_makul WHERE mata_kuliah_id = ?")->execute($_GET['makul']));
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
	echo "<a href='index.php?mod=nilai_semester'><img src='../images/back.png'></a>
		<h5>Data Nilai Semester</h5>
		<form method='POST' action='modul/mod_nilai/aksi_nilai.php?mod=nilai_semester&act=update'>
		<div class='well'>
			<div class='box round first fullpage'>
				<div class='block '>
					<table class='form'>
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
							<td>Mata Kuliah</td>
							<td>:</td>
							<td><b>$data_makul[kode_mata_kuliah] $data_makul[nama_mata_kuliah_eng]</b></td>
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
				</div>
			</div>
			
			<table class='data display datatable' id='example'>
				<thead>
				<tr>
					<th width='30'>No</th>
					<th width='140'>NIM</th>
					<th width='250'>Nama Mahasiswa</th>
					<th width='115'>Absensi (10%)</th>
					<th width='105'>Tugas (40%)</th>
					<th width='90'>UTS (20%)</th>
					<th width='90'>UAS (30%)</th>
					<th width='60'>Total</th>
					<th width='60'>Nilai</th>
					<th width='60'>Bobot</th>
				</tr>
				</thead></tbody>";
				$j = 1;
			$sql_data = $db->database_prepare("SELECT * FROM as_nilai_semester_mhs A 
														INNER JOIN as_kelas B ON B.kelas_id=A.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id
														INNER JOIN as_mahasiswa D ON D.id_mhs=A.id_mhs
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																C.angkatan_id = ? ORDER BY D.NIM ASC")->execute($_GET['makul'],$kelas[0],$kelas[2]);
			while ($data_data = $db->database_fetch_array($sql_data)){
				$abs_hadir = $db->database_num_rows($db->database_prepare("SELECT * FROM as_absensi_mhs WHERE jadwal_id = ? AND id_mhs = ? AND paraf = 'H'")->execute($data_mhs['jadwal_id'],$data_data['id_mhs']));
				$abs_total = $db->database_num_rows($db->database_prepare("SELECT * FROM as_absensi_mhs WHERE jadwal_id = ? AND id_mhs = ?")->execute($data_mhs['jadwal_id'],$data_data['id_mhs']));
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
				
				echo "<tr>
						<td>$j</td>
						<td>$data_data[NIM] <input type='hidden' name='nilai_id[]' value='$data_data[nilai_id]'></td>
						<td>$data_data[nama_mahasiswa]</td>
						<td><input type='text' name='absensi[]' value='$nilai_abs' size='5' DISABLED><input type='hidden' name='absensi[]' value='$nilai_abs' size='5'></td>
						<td><input type='text' name='tugas[]' value='$data_data[tugas]' size='5'></td>
						<td><input type='text' name='uts[]' value='$data_data[uts]' size='5'></td>
						<td><input type='text' name='uas[]' value='$data_data[uas]' size='5'></td>
						<td><input type='text' name='total[]' value='$data_data[total]' size='5' DISABLED></td>
						<td><input type='text' name='mutu[]' value='$mutu' size='5' DISABLED></td>
						<td><input type='text' name='bobot[]' value='$bobot' size='5' DISABLED></td>
					</tr>";
				$j++;
			}
		echo "</tbody></table><p>&nbsp;</p><p>&nbsp;</p>
		<div>
			<button type='submit' class='btn btn-primary'><i class='icon-save'></i> Simpan Perubahan</button>
		</div>
		</div>
	</form>
	";
	break;
}
?>