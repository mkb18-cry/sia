<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	function checkAll(form){
		for (var i=0;i<document.forms[form].elements.length;i++)
		{
			var e=document.forms[form].elements[i];
			if ((e.name !='allbox') && (e.type=='checkbox'))
			{
				e.checked=document.forms[form].allbox.checked;
			}
		}
	}

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
		
		$( "#datepicker3" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: '2013:c-0'
		});
		
		$( "#datepicker4" ).datepicker({
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
	});
</script>

<?php
switch($_GET['act']){
	default:

	echo "
	<div class='well'>
		<ul id='menu2' class='menu2'>
			<li class='active'><a href='#uts'>UTS</a></li>
			<li><a href='#uas'>UAS</a></li>
		</ul>
		
		<div id='uts' class='content2'>
			<h5><i>Cetak Kartu UTS</i></h5>
			<div class='box round first fullpage'>
				<div class='block '>
					<form method='GET' action='?mod=kartu_ujian&act=data_uts'>
					<input type='hidden' name='mod' value='kartu_ujian'>
					<input type='hidden' name='act' value='data_uts'>
					<table class='form'>
						<tr valign='top'>
							<td width='200'><label>Mulai Jadwal Ujian</label></td>
							<td><input type='text' name='awal' id='datepicker'></td>
						</tr>
						<tr valign='top'>
							<td><label>Akhir Jadwal Ujian</label></td>
							<td><input type='text' name='akhir' id='datepicker2'></td>
						</tr>
						<tr valign='top'>
							<td><label>Program Studi</label></td>
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
											elseif ($data_prodi['KDJENMSPST'] == 'J'){
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
							<td></td>
							<td><button type='submit' class='btn btn-primary'>Buka Data</button></td>
						</tr>
					</table>
					</form>
				</div>
			</div>
		</div>
		
		<div id='uas' class='content2'>
			<h5><i>Cetak Kartu UAS</i></h5>
			<div class='box round first fullpage'>
				<div class='block '>
					<form method='GET' action='?mod=kartu_ujian&act=data_uas'>
					<input type='hidden' name='mod' value='kartu_ujian'>
					<input type='hidden' name='act' value='data_uas'>
					<table class='form'>
						<tr valign='top'>
							<td width='200'><label>Mulai Jadwal Ujian</label></td>
							<td><input type='text' name='awal' id='datepicker3'></td>
						</tr>
						<tr valign='top'>
							<td><label>Akhir Jadwal Ujian</label></td>
							<td><input type='text' name='akhir' id='datepicker4'></td>
						</tr>
						<tr valign='top'>
							<td><label>Program Studi</label></td>
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
											elseif ($data_prodi['KDJENMSPST'] == 'J'){
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
							<td></td>
							<td><button type='submit' class='btn btn-primary'>Buka Data</button></td>
						</tr>
					</table>
					</form>
				</div>
			</div>
		</div>
	</div>";
	break;
	
	case "data_uts";
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
	else{
		$kd_jenjang_studi = "Profesi";
	}
	$tgl_absensi = tgl_indo($_GET['tgl']);
	$data_makul = $db->database_fetch_array($db->database_prepare("SELECT kode_mata_kuliah,nama_mata_kuliah_eng FROM as_makul WHERE mata_kuliah_id = ?")->execute($_GET["makul3"]));
	echo "<a href='index.php?mod=kartu_ujian'><img src='../images/back.png'></a>
		<h5>Cetak Kartu Ujian Tengah Semester (UTS)</h5>
		<form method='GET' action='modul/mod_kartu/uts.php' target='_blank' name='form[0]'>
		<div class='box round first fullpage'>
			<div class='block '>
			<input type='hidden' name='act' value='uts'>
			<table class='form'>
				<tr valign='top'>
					<td width='200'>Program Studi</td>
					<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST] 
					<input type='hidden' name='kelas' value='$_GET[kelas]'>
					<input type='hidden' name='prodi' value='$_GET[prodi]'>
					<input type='hidden' name='awal' value='$_GET[awal]'>
					<input type='hidden' name='akhir' value='$_GET[akhir]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Kelas/Semester</td>
					<td><b>$data_mhs[nama_kelas] - $data_mhs[semester]</b></td>
				</tr>
			</table>
			</div>
		</div>
			<table class='data display datatable' id='example'>
				<thead>
				<tr>
					<th width='30'>No</th>
					<th width='140' align='left'>NIM</th>
					<th width='220'>Nama Mahasiswa</th>
					<th>Checklist</th>
				</tr></thead><tbody>";
				$j = 1;
			$sql_data = $db->database_prepare("SELECT * FROM as_mahasiswa A INNER JOIN as_kelas_mahasiswa B ON B.id_mhs = A.id_mhs
											WHERE A.kode_program_studi = ? AND B.kelas_id = ?")->execute($_GET["prodi"],$kelas[0]);
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
						<td>$data_data[NIM]</td>
						<td>$data_data[nama_mahasiswa]</td>
						<td><input type='checkbox' name='check[]' value='$data_data[id_mhs]'></td>
					</tr>";
				$j++;
			}
		echo "</tbody>
		</table><p>&nbsp;</p><p>&nbsp;</p>
		<input type='checkbox' name='allbox' value='check' onclick='checkAll(0);' /><b> Check All</b><p>&nbsp;</p>
		<div>
			<button type='submit' class='btn btn-green'>Cetak Kartu</button>
		</div>
		</form>
	";
	break;
	
	case "data_uas";
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
	else{
		$kd_jenjang_studi = "Profesi";
	}
	$tgl_absensi = tgl_indo($_GET['tgl']);
	$data_makul = $db->database_fetch_array($db->database_prepare("SELECT kode_mata_kuliah,nama_mata_kuliah_eng FROM as_makul WHERE mata_kuliah_id = ?")->execute($_GET["makul3"]));
	echo "<a href='index.php?mod=kartu_ujian'><img src='../images/back.png'></a>
		<h5>Cetak Kartu Ujian Akhir Semester (UAS)</h5>
		<form method='GET' action='modul/mod_kartu/uas.php' target='_blank' name='form[0]'>
		<div class='box round first fullpage'>
		<div class='block '>
		<input type='hidden' name='act' value='uas'>
			<table class='form'>
				<tr>
					<td width='100'>Program Studi</td>
					<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST] 
					<input type='hidden' name='kelas' value='$_GET[kelas]'>
					<input type='hidden' name='prodi' value='$_GET[prodi]'>
					<input type='hidden' name='awal' value='$_GET[awal]'>
					<input type='hidden' name='akhir' value='$_GET[akhir]'></b></td>
				</tr>
				<tr valign='top'>
					<td>Kelas/Semester</td>
					<td><b>$data_mhs[nama_kelas] - $data_mhs[semester]</b></td>
				</tr>
			</table>
		</div>
		</div>
			<table class='data display datatable' id='example'>
				<thead>
				<tr>
					<th width='30'>No</th>
					<th width='120'>NIM</th>
					<th width='200'>Nama Mahasiswa</th>
					<th>Checklist</th>
				</tr></thead><tbody>";
				$j = 1;
			$sql_data = $db->database_prepare("SELECT * FROM as_mahasiswa A INNER JOIN as_kelas_mahasiswa B ON B.id_mhs = A.id_mhs
											WHERE A.kode_program_studi = ? AND B.kelas_id = ?")->execute($_GET["prodi"],$kelas[0]);
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
						<td>$data_data[NIM]</td>
						<td>$data_data[nama_mahasiswa]</td>
						<td><input type='checkbox' name='check[]' value='$data_data[id_mhs]'></td>
					</tr>";
				$j++;
			}
		echo "</tbody>
		</table><p>&nbsp;</p><p>&nbsp;</p>
		<input type='checkbox' name='allbox' value='check' onclick='checkAll(0);' /><b> Check All</b><p>&nbsp;</p>
		<div>
			<button type='submit' class='btn btn-primary'><i class='icon-print'></i> Cetak Kartu</button>
		</div>
		</form>
	";
	break;
	
	case "viewentriupdate";
	$kelas = explode("%", $_GET['kelas']);
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_kelas B ON A.kelas_id=B.kelas_id
														INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id 
														INNER JOIN mspst D ON D.IDPSTMSPST=B.prodi_id
														INNER JOIN msdos E ON E.IDDOSMSDOS=A.dosen_id
														INNER JOIN as_ruang F ON F.ruang_id=A.ruang_id
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																B.angkatan_id = ? LIMIT 1")->execute($_GET['makul3'],$_GET['kelas'],$_GET['angkatan_id']));
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
	$tgl_absensi = tgl_indo($_GET['date']);
	$data_makul = $db->database_fetch_array($db->database_prepare("SELECT kode_mata_kuliah,nama_mata_kuliah_eng FROM as_makul WHERE mata_kuliah_id = ?")->execute($_GET["makul3"]));
	echo "<p>&nbsp;</p>
		<h4>Data Absensi</h4>
		<div class='well'>
			<table>
				<tr>
					<td width='100'>Program Studi</td>
					<td width='5'>:</td>
					<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST] <input type='hidden' name='kelas' value='$_GET[kelas]'><input type='hidden' name='prodi' value='$_GET[prodi]'><input type='hidden' name='makul2' value='$_GET[makul2]'></b></td>
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
				<tr valign='top'>
					<td>Tgl. Absensi</td>
					<td>:</td>
					<td><b>$tgl_absensi</b></td>
				</tr>
			</table>
			<br>
			<table>
				<tr bgcolor='#B7D577'>
					<th width='25'>No</th>
					<th width='140' align='left'>NIM</th>
					<th align='left' width='300'>Nama Mahasiswa</th>
					<th align='left'>Paraf</th>
				</tr>";
				$j = 1;
			$sql_data = $db->database_prepare("SELECT * FROM as_absensi_mhs A INNER JOIN as_jadwal_kuliah B ON A.jadwal_id=B.jadwal_id
												INNER JOIN as_kelas C ON C.kelas_id=B.kelas_id
												INNER JOIN as_angkatan D ON D.angkatan_id=C.angkatan_id
												INNER JOIN as_mahasiswa E ON E.id_mhs=A.id_mhs
												WHERE
												B.makul_id = ? AND
												B.kelas_id = ? AND
												D.angkatan_id = ? AND
												A.tanggal_absen = ?")->execute($_GET['makul3'],$_GET['kelas'],$_GET['angkatan_id'],$_GET["date"]);
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
				
				if ($j % 2 == 1){
					$bg = "#CCCCCC";
				}
				else{
					$bg = "#FFFFFF";
				}
				echo "<tr>
						<td bgcolor=$bg>$j</td>
						<td bgcolor=$bg>$data_data[NIM]</td>
						<td bgcolor=$bg>$data_data[nama_mahasiswa]</td>
						<td bgcolor=$bg><b>$paraf</b></td>
					</tr>";
				$j++;
			}
		echo "</table></div>
		<div>
			<a href='index.php?mod=kartu_absensi_harian'><button type='button' class='btn btn-primary'> Selesai/Keluar</button></a>
		</div>
	";
	break;
	
	case "entri";
	$kelas = explode("%", $_GET['kelas']);
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
	elseif ($data_mhs['KDJENMSPST'] == 'J'){
		$kd_jenjang_studi = "Profesi";
	}
	$date = date('Y-m-d');
	echo "<p>&nbsp;</p><a href='index.php?mod=kartu_absensi_harian&act=abs_harian_mhs'><img src='../images/back.png'></a>
		<h4>Entri Data Absensi</h4>
		<form method='POST' action='modul/mod_kartu/aksi_kartu.php?mod=kartu_absensi_harian&act=input'>
		<div class='well'>
			<table>
				<tr>
					<td width='100'>Program Studi</td>
					<td width='5'>:</td>
					<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST] <input type='hidden' name='kelas' value='$_GET[kelas]'><input type='hidden' name='prodi' value='$_GET[prodi]'><input type='hidden' name='makul2' value='$_GET[makul2]'></b></td>
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
				<tr valign='top'>
					<td>Tgl. Absensi</td>
					<td>:</td>
					<td><b><input type='text' name='tgl_absen' id='datepicker' value='$date'></b></td>
				</tr>
			</table>
			<br>
			<table>
				<tr bgcolor='#B7D577'>
					<th width='25'>No.</th>
					<th align='center' width='140'>NIM</th>
					<th align='center' width='300'>Nama Mahasiswa</th>
					<th width='120' align='center'>Paraf</th>
				</tr>";
				$i = 1;
			$sql_data = $db->database_prepare("SELECT * FROM as_jadwal_kuliah A INNER JOIN as_krs B ON B.jadwal_id=A.jadwal_id
														INNER JOIN as_kelas C ON C.kelas_id=A.kelas_id
														INNER JOIN as_angkatan D ON C.angkatan_id=C.angkatan_id
														INNER JOIN as_mahasiswa E ON E.id_mhs=B.id_mhs
														WHERE 	A.makul_id=? AND
																A.kelas_id=? AND
																C.angkatan_id = ?")->execute($_GET['makul2'],$kelas[0],$kelas[2]);
			while ($data_data = $db->database_fetch_array($sql_data)){
				if ($i % 2 == 1){
					$bg = "#CCCCCC";
				}
				else{
					$bg = "#FFFFFF";
				}
				
				echo "<tr>
						<td bgcolor=$bg>$i</td>
						<td bgcolor=$bg>$data_data[NIM] <input type='hidden' name='id_mhs[]' value='$data_data[id_mhs]'><input type='hidden' name='jadwal' value='$data_data[jadwal_id]'><input type='hidden' name='jadwal_id[]' value='$data_data[jadwal_id]'><input type='hidden' name='semester[]' value='$data_data[semester]'></td>
						<td bgcolor=$bg>$data_data[nama_mahasiswa]</td>
						<td bgcolor=$bg><select name='paraf[]'>
							<option value='H'>Hadir</option>
							<option value='A'>Alpha</option>
							<option value='S'>Sakit</option>
							<option value='I'>Izin</option>
						</select></td>
					</tr>";
				$i++;
			}
		echo "</thead></table></div>
		<div>
		<button type='submit' class='btn btn-primary'><i class='icon-save'></i> Simpan Absensi</button>
	</div>
		</form>
	";
	break;
	
	case "viewentri";
	$kelas = explode("%", $_GET['kelas']);
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
	elseif ($data_mhs['KDJENMSPST'] == 'J'){
		$kd_jenjang_studi = "Profesi";
	}
	$date = tgl_indo($_GET['date']);
	$data_makul = $db->database_fetch_array($db->database_prepare("SELECT kode_mata_kuliah,nama_mata_kuliah_eng FROM as_makul WHERE mata_kuliah_id = ?")->execute($_GET["makul2"]));
	echo "<p>&nbsp;</p><a href='index.php?mod=kartu_absensi_harian&act=abs_harian_mhs'><img src='../images/back.png'></a>
		<h4>Entri Data Absensi</h4>
		<div class='well'>
			<table>
				<tr>
					<td width='100'>Program Studi</td>
					<td width='5'>:</td>
					<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST] <input type='hidden' name='kelas' value='$_GET[kelas]'><input type='hidden' name='prodi' value='$_GET[prodi]'><input type='hidden' name='makul2' value='$_GET[makul2]'></b></td>
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
				<tr valign='top'>
					<td>Tgl. Absensi</td>
					<td>:</td>
					<td><b>$date</b></td>
				</tr>
			</table>
			<br>
			<table>
				<tr bgcolor='#B7D577'>
					<th width='25'>No</th>
					<th align='left' width='140'>NIM</th>
					<th align='left' width='300'>Nama Mahasiswa</th>
					<th align='left'>Paraf</th>
				</tr>";
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
				
				if ($i % 2 == 1){
					$bg = "#CCCCCC";
				}
				else{
					$bg = "#FFFFFF";
				}
				echo "<tr>
						<td bgcolor=$bg>$i</td>
						<td bgcolor=$bg>$data_data[NIM]</td>
						<td bgcolor=$bg>$data_data[nama_mahasiswa]</td>
						<td bgcolor=$bg><b>$paraf</b></td>
					</tr>";
				$i++;
			}
		echo "</thead></table></div>
		<div>
			<a href='index.php?mod=kartu_absensi_harian'><button type='button' class='btn btn-primary'> Selesai/Keluar</button></a>
		</div>
		</form>
	";
	break;
	
	case "laporan";
	$kelas = explode("%", $_GET['kelas']);
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
	elseif ($data_mhs['KDJENMSPST'] == 'J'){
		$kd_jenjang_studi = "Profesi";
	}
	echo "<p>&nbsp;</p>
		<a href='javascript:history.go(-1)'><img src='../images/back.png'></a>
		<h4>Laporan Data Absensi</h4>
		<div class='well'>
			<table>
				<tr>
					<td width='100'>Program Studi</td>
					<td width='5'>:</td>
					<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST] <input type='hidden' name='kelas' value='$_GET[kelas]'><input type='hidden' name='prodi' value='$_GET[prodi]'><input type='hidden' name='makul2' value='$_GET[makul2]'></b></td>
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
					<td>Mata Kuliah</td>
					<td>:</td>
					<td><b>$data_mhs[kode_mata_kuliah] - $data_mhs[nama_mata_kuliah_eng]</b></td>
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
					<th width='25'>No</th>
					<th width='140' align='left'>NIM</th>
					<th align='left' width='300'>Nama Mahasiswa</th>
					<th align='left' width='80'>Hadir</th>
					<th align='left' width='80'>Alpha</th>
					<th align='left' width='80'>Izin</th>
					<th align='left' width='80'>Sakit</th>
					<th align='left'>Total &nbsp;</th>
				</tr>";
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
				
				if ($j % 2 == 1){
					$bg = "#CCCCCC";
				}
				else{
					$bg = "#FFFFFF";
				}
				echo "<tr>
						<td bgcolor=$bg>$j</td>
						<td bgcolor=$bg>$data_data[NIM]</td>
						<td bgcolor=$bg>$data_data[nama_mahasiswa]</td>
						<td bgcolor=$bg><b>$numsH</b></td>
						<td bgcolor=$bg><b>$numsA</b></td>
						<td bgcolor=$bg><b>$numsI</b></td>
						<td bgcolor=$bg><b>$numsS</b></td>
						<td bgcolor=$bg><b>$nums</b></td>
					</tr>";
				$j++;
			}
		echo "</table></div>
		<div>
			<a href='modul/mod_kartu/laporan_absen.php?makul4=$_GET[makul4]&kelas=$_GET[kelas]' target='_blank'><button type='button' class='btn btn-primary'> Export to PDF</button></a>
		</div>
	";
	break;
}
?>