<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data absensi Mahasiswa berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data absensi Mahasiswa berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data absensi Mahasiswa berhasil dihapus.</p>
	</div>
<?php
}
if ($_GET['code'] == 4){
?>
	<div class='message error'>
		<h5>Failed!</h5>
		<p>Absensi mahasiswa gagal disimpan, absensi sudah pernah disimpan pada tanggal ini sebelumnya</p>
	</div>
<?php
}
?>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	var htmlobjek;
	$(document).ready(function() {
		$( "#datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: '2013:c-0'
		});
		
		$( "#datepicker2" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: '2013:c-0'
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
		
		$("#prodi2").change(function(){
			var prodi2 = $("#prodi2").val();
			$.ajax({
				url: "modul/mod_kartu/ambilkelas2.php",
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
				url: "modul/mod_kartu/ambilmakul2.php",
				data: "kelas2="+kelas2,
				cache: false,
				success: function(msg){
					$("#makul2").html(msg);
				}
			});
		});
		
		$("#prodi3").change(function(){
			var prodi3 = $("#prodi3").val();
			$.ajax({
				url: "modul/mod_kartu/ambilkelas3.php",
				data: "prodi3="+prodi3,
				cache: false,
				success: function(msg){
					$("#kelas3").html(msg);
				}
			});
		});
		
		$("#kelas3").change(function(){
			var kelas3 = $("#kelas3").val();
			$.ajax({
				url: "modul/mod_kartu/ambilmakul3.php",
				data: "kelas3="+kelas3,
				cache: false,
				success: function(msg){
					$("#makul3").html(msg);
				}
			});
		});
		
		$("#prodi4").change(function(){
			var prodi4 = $("#prodi4").val();
			$.ajax({
				url: "modul/mod_kartu/ambilkelas4.php",
				data: "prodi4="+prodi4,
				cache: false,
				success: function(msg){
					$("#kelas4").html(msg);
				}
			});
		});
		
		$("#kelas4").change(function(){
			var kelas4 = $("#kelas4").val();
			$.ajax({
				url: "modul/mod_kartu/ambilmakul4.php",
				data: "kelas4="+kelas4,
				cache: false,
				success: function(msg){
					$("#makul4").html(msg);
				}
			});
		});
		
		$("#prodi5").change(function(){
			var prodi5 = $("#prodi5").val();
			$.ajax({
				url: "modul/mod_kartu/ambilkelas5.php",
				data: "prodi5="+prodi5,
				cache: false,
				success: function(msg){
					$("#kelas5").html(msg);
				}
			});
		});
		
		$("#kelas5").change(function(){
			var kelas5 = $("#kelas5").val();
			$.ajax({
				url: "modul/mod_kartu/ambilmakul5.php",
				data: "kelas5="+kelas5,
				cache: false,
				success: function(msg){
					$("#makul5").html(msg);
				}
			});
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h5>Absensi Harian</h5>
	<!--<a href="?mod=kartu_absensi_harian&act=abs_harian_staff"><button type="button" class="btn btn-primary">Staff</button></a>&nbsp;-->
	<a href="?mod=kartu_absensi_harian&act=abs_harian_mhs"><button type="button" class="btn btn-green">Mahasiswa</button></a>
	
<?php

	break;
	
	case "abs_harian_mhs":
	echo "<a href='?mod=kartu_absensi_harian'><img src='../images/back.png'></a>
	<h5>Absensi Harian Mahasiswa</h5>
	<div class='well'>
		<ul id='menu2' class='menu2'>
			<li class='active'><a href='#home'>Cetak Kartu Absensi</a></li>
			<li><a href='#entri'>Tambah Data Absensi</a></li>
			<li><a href='#buka'>Buka/Ubah Data Absensi</a></li>
			<li><a href='#laporan'>Laporan Kumulatif Absensi</a></li>
			<li><a href='#laporan-detil'>Laporan Detil Absensi</a></li>
		</ul>
	    
		<div id='home' class='content2'>
			<h5><i>Cetak Kartu Absensi</i></h5>
			<div class='box round first fullpage'>
				<div class='block '>
				<form method='GET' action='modul/mod_kartu/cetak_kartu.php' target='_blank'>
				<table class='form'>
					<tr valign='top'>
						<td width='200'><label>Program Studi</label></td>
						<td><select name='prodi' id='prodi'>
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
					<tr valign='top'>
						<td><label>Kelas</label></td>
						<td><select name='kelas' id='kelas'>
								<option value=''>- none -</option>
							</select>
						</td>
					</tr>
					<tr valign='top'>
						<td><label>Mata Kuliah</label></td>
						<td><select id='makul' name='makul'>
								<option value=''>- none -</option>
							</select>
						</td>
					</tr>
					<tr valign='top'>
						<td><label>Tanggal Ujian</label></td>
						<td><input type='text' name='tgl' id='datepicker2' size='40'></td>
					</tr>
					<tr valign='top'>
						<td></td>
						<td><button type='submit' class='btn btn-primary'>Cetak Kartu</button></td>
					</tr>
				</table>
				</form>
				</div>
			</div>
		</div>
		
		<div id='entri' class='content2'>
			<h5><i>Entri Data Absensi</i></h5>
			<div class='box round first fullpage'>
				<div class='block '>
				<form method='GET' action=''>
				<input type='hidden' name='mod' value='kartu_absensi_harian'>
				<input type='hidden' name='act' value='entri'>
				<table class='form'>
					<tr valign='top'>
						<td width='200'><label>Program Studi</label></td>
						<td><select name='prodi' id='prodi2'>
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
					<tr valign='top'>
						<td><label>Kelas</label></td>
						<td><select name='kelas' id='kelas2'>
								<option value=''>- none -</option>
							</select>
						</td>
					</tr>
					<tr valign='top'>
						<td><label>Mata Kuliah</label></td>
						<td><select id='makul2' name='makul2'>
								<option value=''>- none -</option>
							</select>
						</td>
					</tr>
					<tr valign='top'>
						<td></td>
						<td><button type='submit' class='btn btn-primary'>Buka Data</button></td>
					</tr>
				</table>
				</form>
				</div>
			</div>
		</div>
		
		<div id='buka' class='content2'>
			<h5><i>Buka Data Absensi</i></h5>
			<div class='box round first fullpage'>
				<div class='block '>
				<form method='GET' action=''>
				<input type='hidden' name='mod' value='kartu_absensi_harian'>
				<input type='hidden' name='act' value='buka'>
				<table class='form'>
					<tr valign='top'>
						<td><label>Tanggal Absensi</label></td>
						<td><input type='text' name='tgl' id='datepicker' style='margin: 5px;'></td>
					</tr>
					<tr valign='top'>
						<td width='200'><label>Program Studi</label></td>
						<td><select name='prodi' id='prodi3'>
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
					<tr valign='top'>
						<td><label>Kelas</label></td>
						<td><select name='kelas' id='kelas3'>
								<option value=''>- none -</option>
							</select>
						</td>
					</tr>
					<tr valign='top'>
						<td><label>Mata Kuliah</label></td>
						<td><select id='makul3' name='makul3'>
								<option value=''>- none -</option>
							</select>
						</td>
					</tr>
					<tr valign='top'>
						<td></td>
						<td><button type='submit' class='btn btn-primary'>Buka Data</button></td>
					</tr>
				</table>
				</form>
				</div>
			</div>
		</div>
		
		
		<div id='laporan' class='content2'>
			<h5><i>Laporan Kumulatif Absensi</i></h5>
			<div class='box round first fullpage'>
				<div class='block '>
				<form method='GET' action=''>
				<input type='hidden' name='mod' value='kartu_absensi_harian'>
				<input type='hidden' name='act' value='laporan'>
				<table class='form'>
					<tr valign='top'>
						<td width='200'><label>Program Studi</label></td>
						<td><select name='prodi' id='prodi4'>
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
					<tr valign='top'>
						<td><label>Kelas</label></td>
						<td><select name='kelas' id='kelas4'>
								<option value=''>- none -</option>
							</select>
						</td>
					</tr>
					<tr valign='top'>
						<td><label>Mata Kuliah</label></td>
						<td><select id='makul4' name='makul4'>
								<option value=''>- none -</option>
							</select>
						</td>
					</tr>
					<tr valign='top'>
						<td></td>
						<td><button type='submit' class='btn btn-primary'>Lihat Laporan</button></td>
					</tr>
				</table>
				</form>
				</div>
			</div>
		</div>
		
		<div id='laporan-detil' class='content2'>
			<h5><i>Laporan Detil Absensi</i></h5>
			<div class='box round first fullpage'>
				<div class='block '>
				<form method='GET' action=''>
				<input type='hidden' name='mod' value='kartu_absensi_harian'>
				<input type='hidden' name='act' value='laporan-detil'>
				<table class='form'>
					<tr valign='top'>
						<td width='200'><label>Program Studi</label></td>
						<td><select name='prodi' id='prodi5'>
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
					<tr valign='top'>
						<td><label>Kelas</label></td>
						<td><select name='kelas' id='kelas5'>
								<option value=''>- none -</option>
							</select>
						</td>
					</tr>
					<tr valign='top'>
						<td><label>Mata Kuliah</label></td>
						<td><select id='makul5' name='makul5'>
								<option value=''>- none -</option>
							</select>
						</td>
					</tr>
					<tr valign='top'>
						<td></td>
						<td><button type='submit' class='btn btn-primary'>Lihat Laporan</button></td>
					</tr>
				</table>
				</form>
				</div>
			</div>
		</div>
	</div>";
	break;
	
	case "buka";
	$kelas = explode("*", $_GET['kelas']);
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_kelas B ON A.kelas_id=B.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id 
														INNER JOIN mspst D ON D.IDPSTMSPST=B.prodi_id
														INNER JOIN msdos E ON E.IDDOSMSDOS=A.dosen_id
														INNER JOIN as_ruang F ON F.ruang_id=A.ruang_id
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																B.angkatan_id = ? LIMIT 1")->execute($_GET['makul3'],$kelas[0],$kelas[2]));
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
	$tgl_absensi = tgl_indo($_GET['tgl']);
	$data_makul = $db->database_fetch_array($db->database_prepare("SELECT kode_mata_kuliah,nama_mata_kuliah_eng FROM as_makul WHERE mata_kuliah_id = ?")->execute($_GET["makul3"]));
	echo "<a href='index.php?mod=kartu_absensi_harian&act=abs_harian_mhs#buka-tab'><img src='../images/back.png'></a>
		<h5>Ubah Data Absensi</h5>
		<form method='POST' action='modul/mod_kartu/aksi_kartu.php?mod=kartu_absensi_harian&act=update'>
		<div class='box round first fullpage'>
		<div class='block '>
			<table class='form'>
				<tr>
					<td width='100'>Program Studi</td>
					<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST] <input type='hidden' name='kelas' value='$_GET[kelas]'><input type='hidden' name='prodi' value='$_GET[prodi]'><input type='hidden' name='makul2' value='$_GET[makul2]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Kelas/Semester</td>
					<td><b>$data_mhs[nama_kelas] - $data_mhs[semester] <input type='hidden' name='kelas_id' value='$data_mhs[kelas_id]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Mata Kuliah</td>
					<td><b>$data_makul[kode_mata_kuliah] - $data_makul[nama_mata_kuliah_eng]</b></td>
				</tr>
				<tr valign='top'>
					<td>Dosen</td>
					<td><b>$data_mhs[NMDOSMSDOS] $data_mhs[GELARMSDOS]</b></td>
				</tr>
				<tr valign='top'>
					<td>Ruang</td>
					<td><b>$data_mhs[nama_ruang]</b></td>
				</tr>
				<tr valign='top'>
					<td>Tgl. Absensi</td>
					<td><b>$tgl_absensi</b></td>
				</tr>
			</table>
			</div></div>
			<table class='data display datatable' id='example'>
			<thead>
				<tr>
					<th width='30'>No</th>
					<th width='120'>NIM</th>
					<th width='250'>Nama Mahasiswa</th>
					<th>Paraf</th>
				</tr></thead><tbody>";
				$j = 1;
			$sql_data = $db->database_prepare("SELECT * FROM as_absensi_mhs A INNER JOIN as_jadwal_kuliah B ON A.jadwal_id=B.jadwal_id
												INNER JOIN as_kelas C ON C.kelas_id=B.kelas_id
												INNER JOIN as_angkatan D ON D.angkatan_id=C.angkatan_id
												INNER JOIN as_mahasiswa E ON E.id_mhs=A.id_mhs
												WHERE
												B.makul_id = ? AND
												B.kelas_id = ? AND
												D.angkatan_id = ? AND
												A.tanggal_absen = ?")->execute($_GET['makul3'],$kelas[0],$kelas[2],$_GET["tgl"]);
			while ($data_data = $db->database_fetch_array($sql_data)){
				if ($data_data['paraf'] == 'H'){
					$h = "SELECTED";
				}
				else{
					$h = "";
				}
				
				if ($data_data['paraf'] == 'A'){
					$a = "SELECTED";
				}
				else{
					$a = "";
				}
				
				if ($data_data['paraf'] == 'I'){
					$i = "SELECTED";
				}
				else{
					$i = "";
				}
				
				if ($data_data['paraf'] == 'S'){
					$s = "SELECTED";
				}
				else{
					$s = "";
				}
				echo "<tr>
						<td>$j</td>
						<td>$data_data[NIM] 
							<input type='hidden' name='id_absensi[]' value='$data_data[absensi_id]'>
							<input type='hidden' name='id_mhs[]' value='$data_data[id_mhs]'>
							<input type='hidden' name='jadwal_id[]' value='$data_data[jadwal_id]'>
							<input type='hidden' name='semester[]' value='$data_data[semester]'>
							<input type='hidden' name='kelas' value='$_GET[kelas]'>
							<input type='hidden' name='makul3' value='$_GET[makul3]'>
							<input type='hidden' name='tgl' value='$_GET[tgl]'>
							<input type='hidden' name='prodi' value='$_GET[prodi]'>
							</td>
						<td>$data_data[nama_mahasiswa]</td>
						<td><select name='paraf[]'>
							<option value='H' $h>Hadir</option>
							<option value='A' $a>Alpha</option>
							<option value='S' $s>Sakit</option>
							<option value='I' $i>Izin</option>
						</select></td>
					</tr>";
				$j++;
			}
		echo "</tbody></table><p>&nbsp;</p><p>&nbsp;</p>
		<div>
		<button type='submit' class='btn btn-green'><i class='icon-save'></i> Simpan Perubahan</button>
	</div>
		</form>
	";
	break;
	
	case "viewentriupdate";
	$kelas = explode("*", $_GET['kelas']);
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_kelas B ON A.kelas_id=B.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id 
														INNER JOIN mspst D ON D.IDPSTMSPST=B.prodi_id
														INNER JOIN msdos E ON E.IDDOSMSDOS=A.dosen_id
														INNER JOIN as_ruang F ON F.ruang_id=A.ruang_id
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																B.angkatan_id = ? LIMIT 1")->execute($_GET['makul3'],$kelas[0],$kelas[2]));
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
	$tgl_absensi = tgl_indo($_GET['date']);
	$data_makul = $db->database_fetch_array($db->database_prepare("SELECT kode_mata_kuliah,nama_mata_kuliah_eng FROM as_makul WHERE mata_kuliah_id = ?")->execute($_GET["makul3"]));
	echo "<h5>Data Absensi</h5>
		<div class='box round first fullpage'>
			<div class='block '>
			<table class='form'>
				<tr>
					<td width='100'>Program Studi</td>
					<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST] <input type='hidden' name='kelas' value='$_GET[kelas]'><input type='hidden' name='prodi' value='$_GET[prodi]'><input type='hidden' name='makul2' value='$_GET[makul2]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Kelas/Semester</td>
					<td><b>$data_mhs[nama_kelas] - $data_mhs[semester] <input type='hidden' name='kelas_id' value='$data_mhs[kelas_id]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Mata Kuliah</td>
					<td><b>$data_makul[kode_mata_kuliah] - $data_makul[nama_mata_kuliah_eng]</b></td>
				</tr>
				<tr valign='top'>
					<td>Dosen</td>
					<td><b>$data_mhs[NMDOSMSDOS] $data_mhs[GELARMSDOS]</b></td>
				</tr>
				<tr valign='top'>
					<td>Ruang</td>
					<td><b>$data_mhs[nama_ruang]</b></td>
				</tr>
				<tr valign='top'>
					<td>Tgl. Absensi</td>
					<td><b>$tgl_absensi</b></td>
				</tr>
			</table>
			</div></div>
			<table class='data display datatable' id='example'>
				<thead>
				<tr>
					<th width='30'>No</th>
					<th width='120'>NIM</th>
					<th width='250'>Nama Mahasiswa</th>
					<th>Paraf</th>
				</tr></thead><tbody>";
				$j = 1;
			$sql_data = $db->database_prepare("SELECT * FROM as_absensi_mhs A INNER JOIN as_jadwal_kuliah B ON A.jadwal_id=B.jadwal_id
												INNER JOIN as_kelas C ON C.kelas_id=B.kelas_id
												INNER JOIN as_angkatan D ON D.angkatan_id=C.angkatan_id
												INNER JOIN as_mahasiswa E ON E.id_mhs=A.id_mhs
												WHERE
												B.makul_id = ? AND
												B.kelas_id = ? AND
												D.angkatan_id = ? AND
												A.tanggal_absen = ?")->execute($_GET['makul3'],$kelas[0],$kelas[2],$_GET["date"]);
			while ($data_data = $db->database_fetch_array($sql_data)){
				if ($data_data['paraf'] == 'H'){
					$paraf = "Hadir";
				}
				elseif($data_data['paraf'] == 'A'){
					$paraf = "Alpha";
				}
				elseif($data_data['paraf'] == 'I'){
					$paraf = "Izin";
				}
				elseif($data_data['paraf'] == 'S'){
					$paraf = "Sakit";
				}
				echo "<tr>
						<td>$j</td>
						<td>$data_data[NIM]</td>
						<td>$data_data[nama_mahasiswa]</td>
						<td><b>$paraf</b></td>
					</tr>";
				$j++;
			}
		echo "</tbody></table><p>&nbsp;</p><p>&nbsp;</p>
		<div>
			<a href='index.php?mod=kartu_absensi_harian'><button type='button' class='btn btn-green'> Selesai/Keluar</button></a>
		</div>
	";
	break;
	
	case "entri";
	$kelas = explode("*", $_GET['kelas']);
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_kelas B ON A.kelas_id=B.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id 
														INNER JOIN mspst D ON D.IDPSTMSPST=B.prodi_id
														INNER JOIN msdos E ON E.IDDOSMSDOS=A.dosen_id
														INNER JOIN as_ruang F ON F.ruang_id=A.ruang_id
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																B.angkatan_id = ? LIMIT 1")->execute($_GET['makul2'],$kelas[0],$kelas[2]));
	$data_makul = $db->database_fetch_array($db->database_prepare("SELECT kode_mata_kuliah, nama_mata_kuliah_eng FROM as_makul WHERE mata_kuliah_id = ?")->execute($_GET["makul2"]));
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
	$date = date('Y-m-d');
	echo "<a href='index.php?mod=kartu_absensi_harian&act=abs_harian_mhs#entri-tab'><img src='../images/back.png'></a>
		<h4>Entri Data Absensi</h4>
		<form method='POST' action='modul/mod_kartu/aksi_kartu.php?mod=kartu_absensi_harian&act=input'>
		<div class='box round first fullpage'>
			<div class='block '>
			<table class='form'>
				<tr valign='top'>
					<td width='100'>Program Studi</td>
					<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST] <input type='hidden' name='kelas' value='$_GET[kelas]'><input type='hidden' name='prodi' value='$_GET[prodi]'><input type='hidden' name='makul2' value='$_GET[makul2]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Kelas/Semester</td>
					<td><b>$data_mhs[nama_kelas] - $data_mhs[semester_kelas] <input type='hidden' name='kelas_id' value='$data_mhs[kelas_id]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Mata Kuliah</td>
					<td><b>$data_makul[kode_mata_kuliah] - $data_makul[nama_mata_kuliah_eng]</b></td>
				</tr>
				<tr valign='top'>
					<td>Dosen</td>
					<td><b>$data_mhs[NMDOSMSDOS] $data_mhs[GELARMSDOS]</b></td>
				</tr>
				<tr valign='top'>
					<td>Ruang</td>
					<td><b>$data_mhs[nama_ruang]</b></td>
				</tr>
				<tr valign='top'>
					<td>Tgl. Absensi</td>
					<td><b><input type='text' name='tgl_absen' id='datepicker' value='$date'></b></td>
				</tr>
			</table>
		</div>
		</div>
			<table class='data display datatable' id='example'>
				<thead>
				<tr>
					<th width='30'>No</th>
					<th width='100'>NIM</th>
					<th width='250'>Nama Mahasiswa</th>
					<th>Paraf</th>
				</tr></thead><tbody>";
				$i = 1;
			$sql_data = $db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_krs B ON B.jadwal_id=A.jadwal_id
														INNER JOIN as_kelas C ON C.kelas_id=A.kelas_id
														INNER JOIN as_angkatan D ON C.angkatan_id=C.angkatan_id
														INNER JOIN as_mahasiswa E ON E.id_mhs=B.id_mhs
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																C.angkatan_id = ? AND
																A.semester = ? GROUP BY B.id_mhs")->execute($_GET['makul2'],$kelas[0],$kelas[2],$kelas[1]);
			while ($data_data = $db->database_fetch_array($sql_data)){
								
				echo "<tr>
						<td>$i</td>
						<td>$data_data[NIM] <input type='hidden' name='id_mhs[]' value='$data_data[id_mhs]'><input type='hidden' name='jadwal' value='$data_data[jadwal_id]'><input type='hidden' name='jadwal_id[]' value='$data_data[jadwal_id]'><input type='hidden' name='semester[]' value='$data_data[semester]'></td>
						<td>$data_data[nama_mahasiswa]</td>
						<td><select name='paraf[]'>
							<option value='H'>Hadir</option>
							<option value='A'>Alpha</option>
							<option value='S'>Sakit</option>
							<option value='I'>Izin</option>
						</select></td>
					</tr>";
				$i++;
			}
		echo "</tbody></table><p>&nbsp;</p><p>&nbsp;</p>
		<div>
			<button type='submit' class='btn btn-primary'><i class='icon-green'></i> Simpan Absensi</button>
		</div>
		</form>
	";
	break;
	
	case "viewentri";
	$kelas = explode("*", $_GET['kelas']);
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_kelas B ON A.kelas_id=B.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id 
														INNER JOIN mspst D ON D.IDPSTMSPST=B.prodi_id
														INNER JOIN msdos E ON E.IDDOSMSDOS=A.dosen_id
														INNER JOIN as_ruang F ON F.ruang_id=A.ruang_id
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																B.angkatan_id = ? LIMIT 1")->execute($_GET['makul2'],$kelas[0],$kelas[2]));
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
	$date = tgl_indo($_GET['date']);
	$data_makul = $db->database_fetch_array($db->database_prepare("SELECT kode_mata_kuliah,nama_mata_kuliah_eng FROM as_makul WHERE mata_kuliah_id = ?")->execute($_GET["makul2"]));
	echo "<a href='index.php?mod=kartu_absensi_harian&act=abs_harian_mhs'><img src='../images/back.png'></a>
		<h5>Entri Data Absensi</h5>
		<div class='box round first fullpage'>
				<div class='block '>
			<table class='form'>
				<tr>
					<td width='100'>Program Studi</td>
					<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST] <input type='hidden' name='kelas' value='$_GET[kelas]'><input type='hidden' name='prodi' value='$_GET[prodi]'><input type='hidden' name='makul2' value='$_GET[makul2]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Kelas/Semester</td>
					<td><b>$data_mhs[nama_kelas] - $data_mhs[semester] <input type='hidden' name='kelas_id' value='$data_mhs[kelas_id]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Mata Kuliah</td>
					<td><b>$data_makul[kode_mata_kuliah] - $data_makul[nama_mata_kuliah_eng]</b></td>
				</tr>
				<tr valign='top'>
					<td>Dosen</td>
					<td><b>$data_mhs[NMDOSMSDOS] $data_mhs[GELARMSDOS]</b></td>
				</tr>
				<tr valign='top'>
					<td>Ruang</td>
					<td><b>$data_mhs[nama_ruang]</b></td>
				</tr>
				<tr valign='top'>
					<td>Tgl. Absensi</td>
					<td><b>$date</b></td>
				</tr>
			</table>
			</div></div>
			<table class='data display datatable' id='example'>
				<thead>
				<tr>
					<th width='30'>No</th>
					<th width='120'>NIM</th>
					<th width='250'>Nama Mahasiswa</th>
					<th>Paraf</th>
				</tr>
				</thead><tbody>";
				$i = 1;
			$sql_data = $db->database_prepare("SELECT * FROM as_absensi_mhs A INNER JOIN as_jadwal_kuliah B ON A.jadwal_id=B.jadwal_id
												INNER JOIN as_kelas C ON C.kelas_id=B.kelas_id
												INNER JOIN as_angkatan D ON D.angkatan_id=C.angkatan_id
												INNER JOIN as_mahasiswa E ON E.id_mhs=A.id_mhs
												WHERE
												B.makul_id = ? AND
												B.kelas_id = ? AND
												D.angkatan_id = ? AND
												A.tanggal_absen = ?")->execute($_GET['makul2'],$kelas[0],$kelas[2],$_GET["date"]);
			while ($data_data = $db->database_fetch_array($sql_data)){
				if ($data_data['paraf'] == 'A'){
					$paraf = "Alpha";
				}
				elseif ($data_data['paraf'] == 'I'){
					$paraf = "Izin";
				}
				elseif ($data_data['paraf'] == 'S'){
					$paraf = "Sakit";
				}
				else{
					$paraf = "Hadir";
				}
				
				echo "<tr>
						<td>$i</td>
						<td>$data_data[NIM]</td>
						<td>$data_data[nama_mahasiswa]</td>
						<td><b>$paraf</b></td>
					</tr>";
				$i++;
			}
		echo "</thead></table><p>&nbsp;</p><p>&nbsp;</p>
		<div>
			<a href='index.php?mod=kartu_absensi_harian'><button type='button' class='btn btn-green'> Selesai/Keluar</button></a>
		</div>
		</form>
	";
	break;
	
	case "laporan";
	$kelas = explode("*", $_GET['kelas']);
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_kelas B ON A.kelas_id=B.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id 
														INNER JOIN mspst D ON D.IDPSTMSPST=B.prodi_id
														INNER JOIN msdos E ON E.IDDOSMSDOS=A.dosen_id
														INNER JOIN as_ruang F ON F.ruang_id=A.ruang_id
														INNER JOIN as_makul G ON A.makul_id=G.mata_kuliah_id
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																B.angkatan_id = ? LIMIT 1")->execute($_GET['makul4'],$kelas[0],$kelas[2]));
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
	echo "<a href='?mod=kartu_absensi_harian&act=abs_harian_mhs#laporan-tab'><img src='../images/back.png'></a>
		<h5>Laporan Data Absensi</h5>
		<div class='box round first fullpage'>
		<div class='block '>
			<table class='form'>
				<tr>
					<td width='100'>Program Studi</td>
					<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST] <input type='hidden' name='kelas' value='$_GET[kelas]'><input type='hidden' name='prodi' value='$_GET[prodi]'><input type='hidden' name='makul2' value='$_GET[makul2]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Kelas/Semester</td>
					<td><b>$data_mhs[nama_kelas] - $data_mhs[semester] <input type='hidden' name='kelas_id' value='$data_mhs[kelas_id]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Mata Kuliah</td>
					<td><b>$data_mhs[kode_mata_kuliah] - $data_mhs[nama_mata_kuliah_eng]</b></td>
				</tr>
				<tr valign='top'>
					<td>Dosen</td>
					<td><b>$data_mhs[NMDOSMSDOS] $data_mhs[GELARMSDOS]</b></td>
				</tr>
				<tr valign='top'>
					<td>Ruang</td>
					<td><b>$data_mhs[nama_ruang]</b></td>
				</tr>
			</table>
			</div></div>
			<table class='data display datatable' id='example'>
				<thead>
				<tr>
					<th width='30'>No</th>
					<th width='120'>NIM</th>
					<th width='250'>Nama Mahasiswa</th>
					<th width='80'>Hadir</th>
					<th width='80'>Alpha</th>
					<th width='80'>Izin</th>
					<th width='80'>Sakit</th>
					<th>Total &nbsp;</th>
				</tr></thead><tbody>";
				$j = 1;
			$sql_data = $db->database_prepare("SELECT * FROM as_absensi_mhs A INNER JOIN as_jadwal_kuliah B ON A.jadwal_id=B.jadwal_id
												INNER JOIN as_kelas C ON C.kelas_id=B.kelas_id
												INNER JOIN as_angkatan D ON D.angkatan_id=C.angkatan_id
												INNER JOIN as_mahasiswa E ON E.id_mhs=A.id_mhs
												WHERE
												B.makul_id = ? AND
												B.kelas_id = ? AND
												D.angkatan_id = ? GROUP BY A.id_mhs, A.jadwal_id")->execute($_GET['makul4'],$kelas[0],$kelas[2]);											
			while ($data_data = $db->database_fetch_array($sql_data)){
				$numsH = $db->database_num_rows($db->database_prepare("SELECT * FROM as_absensi_mhs WHERE id_mhs = ? AND jadwal_id = ? AND paraf = ?")->execute($data_data['id_mhs'],$data_data['jadwal_id'],H));
				$numsA = $db->database_num_rows($db->database_prepare("SELECT * FROM as_absensi_mhs WHERE id_mhs = ? AND jadwal_id = ? AND paraf = ?")->execute($data_data['id_mhs'],$data_data['jadwal_id'],A));
				$numsI = $db->database_num_rows($db->database_prepare("SELECT * FROM as_absensi_mhs WHERE id_mhs = ? AND jadwal_id = ? AND paraf = ?")->execute($data_data['id_mhs'],$data_data['jadwal_id'],I));
				$numsS = $db->database_num_rows($db->database_prepare("SELECT * FROM as_absensi_mhs WHERE id_mhs = ? AND jadwal_id = ? AND paraf = ?")->execute($data_data['id_mhs'],$data_data['jadwal_id'],S));
				$nums = $db->database_num_rows($db->database_prepare("SELECT * FROM as_absensi_mhs A INNER JOIN as_jadwal_kuliah B ON A.jadwal_id=B.jadwal_id
												INNER JOIN as_kelas C ON C.kelas_id=B.kelas_id
												INNER JOIN as_angkatan D ON D.angkatan_id=C.angkatan_id
												INNER JOIN as_mahasiswa E ON E.id_mhs=A.id_mhs
												WHERE
												B.makul_id = ? AND
												B.kelas_id = ? AND
												D.angkatan_id = ? AND
												A.id_mhs = ?")->execute($_GET['makul4'],$kelas[0],$kelas[2],$data_data['id_mhs']));
				if ($data_data['paraf'] == 'H'){
					$paraf = "Hadir";
				}
				elseif($data_data['paraf'] == 'A'){
					$paraf = "Alpha";
				}
				elseif($data_data['paraf'] == 'I'){
					$paraf = "Izin";
				}
				elseif($data_data['paraf'] == 'S'){
					$paraf = "Sakit";
				}
				echo "<tr>
						<td>$j</td>
						<td>$data_data[NIM]</td>
						<td>$data_data[nama_mahasiswa]</td>
						<td><b>$numsH</b></td>
						<td><b>$numsA</b></td>
						<td><b>$numsI</b></td>
						<td><b>$numsS</b></td>
						<td><b>$nums</b></td>
					</tr>";
				$j++;
			}
		echo "</table><p>&nbsp;</p><p>&nbsp;</p>
		<div>
			<a href='modul/mod_kartu/laporan_absen.php?makul4=$_GET[makul4]&kelas=$_GET[kelas]' target='_blank'><button type='button' class='btn btn-primary'> Export to PDF</button></a>
		</div>
	";
	break;
	
	case "laporan-detil";
	$kelas = explode("*", $_GET['kelas']);
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_kelas B ON A.kelas_id=B.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id 
														INNER JOIN mspst D ON D.IDPSTMSPST=B.prodi_id
														INNER JOIN msdos E ON E.IDDOSMSDOS=A.dosen_id
														INNER JOIN as_ruang F ON F.ruang_id=A.ruang_id
														INNER JOIN as_makul G ON A.makul_id=G.mata_kuliah_id
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																B.angkatan_id = ? LIMIT 1")->execute($_GET['makul5'],$kelas[0],$kelas[2]));
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
	echo "<a href='?mod=kartu_absensi_harian&act=abs_harian_mhs#laporan-tab'><img src='../images/back.png'></a>
		<h5>Laporan Detil Absensi</h5>
		<div class='box round first fullpage'>
		<div class='block '>
			<table class='form'>
				<tr>
					<td width='100'>Program Studi</td>
					<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST] <input type='hidden' name='kelas' value='$_GET[kelas]'><input type='hidden' name='prodi' value='$_GET[prodi]'><input type='hidden' name='makul2' value='$_GET[makul2]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Kelas/Semester</td>
					<td><b>$data_mhs[nama_kelas] - $data_mhs[semester] <input type='hidden' name='kelas_id' value='$data_mhs[kelas_id]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Mata Kuliah</td>
					<td><b>$data_mhs[kode_mata_kuliah] - $data_mhs[nama_mata_kuliah_eng]</b></td>
				</tr>
				<tr valign='top'>
					<td>Dosen</td>
					<td><b>$data_mhs[NMDOSMSDOS] $data_mhs[GELARMSDOS]</b></td>
				</tr>
				<tr valign='top'>
					<td>Ruang</td>
					<td><b>$data_mhs[nama_ruang]</b></td>
				</tr>
			</table>
			</div></div>
			<table class='data display datatable' id='example'>
				<thead>
				<tr>
					<th width='30'>No</th>
					<th>Tanggal Absensi</th>
				</tr></thead><tbody>";
				$j = 1;
			$sql_data = $db->database_prepare("SELECT * FROM as_absensi_mhs A INNER JOIN as_jadwal_kuliah B ON A.jadwal_id=B.jadwal_id
												INNER JOIN as_kelas C ON C.kelas_id=B.kelas_id
												INNER JOIN as_angkatan D ON D.angkatan_id=C.angkatan_id
												INNER JOIN as_mahasiswa E ON E.id_mhs=A.id_mhs
												WHERE
												B.makul_id = ? AND
												B.kelas_id = ? AND
												D.angkatan_id = ? GROUP BY A.jadwal_id, A.tanggal_absen")->execute($_GET['makul5'],$kelas[0],$kelas[2]);
			while ($data_data = $db->database_fetch_array($sql_data)){
				
				$tanggal_absen = tgl_indo($data_data['tanggal_absen']);
				
				echo "<tr>
						<td>$j</td>
						<td><b>$tanggal_absen</b></td>
					</tr>";
				$j++;
			}
		echo "</table><p>&nbsp;</p><p>&nbsp;</p>
		<div>
			<a href='modul/mod_kartu/laporan_detil_absen.php?makul5=$_GET[makul5]&kelas=$_GET[kelas]' target='_blank'><button type='button' class='btn btn-primary'> Export to PDF</button></a>
		</div>
	";
	break;
}
?>