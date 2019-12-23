<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Jadwal Baru berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Jadwal berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Jadwal berhasil dihapus.</p>
	</div>
<?php
}
?>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
		$('#frm_jadwal').validate({
			rules:{
				prodi: true,
				tahun_angkatan: true
			},
			messages:{
				prodi:{
					required: "Pilih program studi terlebih dahulu."
				},
				tahun_angkatan:{
					required: "Pilih tahun angkatan terlebih dahulu."
				}
			}
		});
		
		$('#frm_jadwal_kul').validate({
			rules:{
				makul_id: true,
				hari: true,
				jam_mulai: true,
				jam_selesai: true,
				ruang_id: true,
				program: true,
				dosen_id: true
			},
			messages:{
				makul_id:{
					required: "Mata kuliah jawib diisi."
				},
				hari:{
					required: "Hari wajib diisi."
				},
				jam_mulai:{
					required: "Jam mulai mata kuliah wajib diisi."
				},
				jam_selesai:{
					required: "Jam selesai mata kuliah wajib diisi."
				},
				ruang_id:{
					required: "Ruang kelas wajib diisi."
				},
				program:{
					required: "Program kuliah wajib diisi."
				},
				dosen_id:{
					required: "Dosen pengajar wajib diisi."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h5>Penjadwalan Mata Kuliah</h5>
	<div class="box round first fullpage">
		<div class="block ">
			<form method="GET" action="" id="frm_jadwal">
			<input type="hidden" name="mod" value="jadwal_mata_kuliah">
			<input type="hidden" name="act" value="mgm_mata_kuliah">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>Program Studi</label></td>
					<td><select name='prodi' class='required'>
							<option value="">- none -</option>
							<?php
							$sql_prodi = $db->database_prepare("SELECT * FROM mspst WHERE STATUMSPST = 'A' ORDER BY KDJENMSPST,NMPSTMSPST ASC")->execute();
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
					<td><label>Tahun Angkatan</label></td>
					<td><select name='tahun_angkatan' class='required'>
							<option value="">- none -</option>
							<?php
							$sql_angkatan = $db->database_prepare("SELECT * FROM as_angkatan WHERE aktif = 'A' ORDER BY angkatan_id DESC")->execute();
							while ($data_angkatan = $db->database_fetch_array($sql_angkatan)){
								if ($data_angkatan['semester_angkatan'] == 'A'){
									$semester = "Genap";
								}
								else{
									$semester = "Ganjil";
								}
								echo "<option value=$data_angkatan[angkatan_id]>$data_angkatan[tahun_angkatan] - $semester</option>";
							}
						?>
						</select>
					</td>
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
	
	case "mgm_mata_kuliah":
	echo "
		<a href='index.php?mod=jadwal_mata_kuliah'><img src='../images/back.png'></a>
		<h5>Data Kelas</h5>
		<table class='data display datatable' id='example'>
			<thead>
				<tr>
					<th width='30'>No</th>
					<th width='100'>Kelas</th>
					<th width='100'>Semester</th>
					<th align='left'>Aksi</th>
				</tr>
			</thead>
			<tbody>
			";
			$i = 1;
			$sql_kelas = $db->database_prepare("SELECT * FROM as_kelas WHERE aktif = 'A' AND prodi_id = ? AND angkatan_id = ? ORDER BY semester_kelas DESC")
					->execute($_GET["prodi"],$_GET["tahun_angkatan"]);
			while ($data_kelas = $db->database_fetch_array($sql_kelas)){
				echo "	<tr>
						<td>$i</td>
						<td>$data_kelas[nama_kelas]</td>
						<td>$data_kelas[semester_kelas]</td>
						<td><a title='Lihat' href='index.php?mod=jadwal_mata_kuliah&act=mgm_mata_kuliah&prodi=$_GET[prodi]&tahun_angkatan=$_GET[tahun_angkatan]&kelas_id=$data_kelas[kelas_id]&semester=$data_kelas[semester_kelas]'><img src='../images/view.png' width='20'></a></td>
					</tr>";
				$i++;
			}
			echo "</tbody>
		</table>
	";
	
	if ($_GET['kelas_id'] != ''){
		$data2 = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_kelas WHERE kelas_id = ?")->execute($_GET["kelas_id"]));
		echo "<p>&nbsp;</p><p>&nbsp;</p>
			<div class='message info'>
				<h5>Jadwal Mata Kuliah</h5><p>Kelas: $data2[nama_kelas]<br>Semester: $_GET[semester]</p>
			</div>
			<div>
				<a href='?mod=jadwal_mata_kuliah&act=add&prodi=$_GET[prodi]&tahun_angkatan=$_GET[tahun_angkatan]&kelas_id=$_GET[kelas_id]&semester=$_GET[semester]'><button type='button' class='btn btn-green'>+ Tambah Jadwal</button></a>
			</div><br>
			<table class='data display datatable' id='example'>
				<thead>
					<tr>
						<th width='30'>No</th>
						<th width='70'>Program</th>
						<th width='80'>Kode MK</th>
						<th width='150'>Nama Mata Kuliah</th>
						<th width='50'>Kelas</th>
						<th width='40'>Hari</th>
						<th width='85'>Jam Mulai</th>
						<th width='90'>Jam Selesai</th>
						<th width='170'>Dosen</th>
						<th width='60'>Ruang</th>
						<th width='60'>Aksi</th>
					</tr>
				</thead>
				<tbody>
				";
				$i = 1;
				$sql_jadwal = $db->database_prepare("SELECT * FROM as_jadwal_kuliah INNER JOIN as_makul ON as_makul.mata_kuliah_id=as_jadwal_kuliah.makul_id 
													INNER JOIN as_kelas ON as_kelas.kelas_id=as_jadwal_kuliah.kelas_id
													INNER JOIN as_ruang ON as_ruang.ruang_id=as_jadwal_kuliah.ruang_id
													INNER JOIN msdos ON msdos.IDDOSMSDOS=as_jadwal_kuliah.dosen_id
													WHERE as_jadwal_kuliah.kelas_id = ? AND as_jadwal_kuliah.semester = ? ORDER BY jadwal_id DESC")->execute($_GET["kelas_id"],$_GET["semester"]);
				while ($data_jadwal = $db->database_fetch_array($sql_jadwal)){
					if ($data_jadwal['program'] == 'A'){
						$program = "Reguler";
					}
					else{
						$program = "Non-Reguler";
					}
					
					if ($data_jadwal['hari'] == 1){
						$hari = "Senin";
					}
					elseif ($data_jadwal['hari'] == 2){
						$hari = "Selasa";
					}
					elseif ($data_jadwal['hari'] == 3){
						$hari = "Rabu";
					}
					elseif ($data_jadwal['hari'] == 4){
						$hari = "Kamis";
					}
					elseif ($data_jadwal['hari'] == 5){
						$hari = "Jumat";
					}
					elseif ($data_jadwal['hari'] == 6){
						$hari = "Sabtu";
					}
					else{
						$hari = "Minggu";
					}
					echo "	<tr valign=top>
							<td>$i</td>
							<td>$program</td>
							<td>$data_jadwal[kode_mata_kuliah]</td>
							<td>$data_jadwal[nama_mata_kuliah_eng]</td>
							<td>$data_jadwal[nama_kelas]</td>
							<td>$hari</td>
							<td>$data_jadwal[jam_mulai]</td>
							<td>$data_jadwal[jam_selesai]</td>
							<td>$data_jadwal[NMDOSMSDOS] $data_jadwal[GELARMSDOS]</td>
							<td>$data_jadwal[nama_ruang]</td>
							<td><a title='Ubah' href='index.php?mod=jadwal_mata_kuliah&act=edit&id=$data_jadwal[jadwal_id]&prodi=$_GET[prodi]&tahun_angkatan=$_GET[tahun_angkatan]&kelas_id=$_GET[kelas_id]&semester=$_GET[semester]'><img src='../images/edit.jpg' width='20'></a> ";
							?>
							<a title='Hapus' href="modul/mod_jadwal/aksi_jadwal.php?mod=jadwal_mata_kuliah&act=delete&id=<?php echo $data_jadwal[jadwal_id];?>&prodi=<?php echo $_GET['prodi']; ?>&angkatan_id=<?php echo $_GET['tahun_angkatan']; ?>&kelas_id=<?php echo $_GET['kelas_id']; ?>&semester=<?php echo $_GET['semester']; ?>" onclick="return confirm('Anda Yakin ingin menghapus jadwal mata kuliah <?php echo $data_jadwal[nama_mata_kuliah_eng];?>?');"><img src='../images/delete.jpg' width='20'></a>
							<?php
						echo "</td>
						</tr>";
					$i++;
				}
				echo "</tbody>
			</table>
		";
	}
	break;
	
	case "edit":
	$data_jadwal = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_jadwal_kuliah WHERE jadwal_id = ?")->execute($_GET["id"]));
	$data_ang = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_angkatan WHERE angkatan_id = ?")->execute($_GET['tahun_angkatan']));
	$dt_prodi = $db->database_fetch_array($db->database_prepare("SELECT * FROM mspst WHERE IDPSTMSPST = ?")->execute($_GET["prodi"]));
	if ($dt_prodi['KDJENMSPST'] == 'A'){
		$kd_jenjang_studi = "S3";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'B'){
		$kd_jenjang_studi = "S2";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'C'){
		$kd_jenjang_studi = "S1";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'D'){
		$kd_jenjang_studi = "D4";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'E'){
		$kd_jenjang_studi = "D3";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'F'){
		$kd_jenjang_studi = "D2";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'G'){
		$kd_jenjang_studi = "D1";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'H'){
		$kd_jenjang_studi = "Sp-1";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'I'){
		$kd_jenjang_studi = "Sp-2";
	}
	else{
		$kd_jenjang_studi = "Profesi";
	}
?>
	<a href="javascript:history.go(-1)"><img src="../images/back.png"></a>
	<h5>Ubah Jadwal Mata Kuliah</h5>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_jadwal_kul" action="modul/mod_jadwal/aksi_jadwal.php?mod=jadwal_mata_kuliah&act=update" method="POST">
			<input type="hidden" name="id" value="<?php echo $data_jadwal['jadwal_id']; ?>">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>Program Studi</label></td>
					<td><b><?php echo $kd_jenjang_studi." - ".$dt_prodi['NMPSTMSPST']; ?></b><p></p>
						<input type="hidden" name="prodi" value="<?php echo $_GET['prodi']; ?>">
						<input type="hidden" name="kelas_id" value="<?php echo $_GET['kelas_id']; ?>">
						<input type="hidden" name="semester" value="<?php echo $_GET['semester']; ?>">
					</td>
				</tr>
				<tr valign="top">
					<td><label>Tahun Angkatan</label></td>
					<td><b><?php echo $data_ang['tahun_angkatan']; ?></b><p></p>
						<input type="hidden" name="angkatan_id" value="<?php echo $data_ang['angkatan_id']; ?>">
					</td>
				</tr>
				<tr valign="top">
					<td><label>Kode Mata Kuliah <font color="red">*</font></label></td>
					<td><select name="makul_id" class="required">
							<?php
							$sql_makul = $db->database_prepare("SELECT * FROM as_makul WHERE status_mata_kuliah = 'A' ORDER BY kode_mata_kuliah ASC")->execute();
							while ($data_makul = $db->database_fetch_array($sql_makul)){
								if ($data_jadwal['makul_id'] == $data_makul['mata_kuliah_id']){
									echo "<option value=$data_makul[mata_kuliah_id] SELECTED>$data_makul[kode_mata_kuliah] - $data_makul[nama_mata_kuliah_eng]</option>";
								}
								else{
									echo "<option value=$data_makul[mata_kuliah_id]>$data_makul[kode_mata_kuliah] - $data_makul[nama_mata_kuliah_eng]</option>";
								}
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Hari <font color="red">*</font> <i>Hari mata kuliah</i></label></td>
					<td><select name="hari" class="required">
							<option value="1" <?php if($data_jadwal['hari'] == 1){ echo "SELECTED"; } ?>>Senin</option>
							<option value="2" <?php if($data_jadwal['hari'] == 2){ echo "SELECTED"; } ?>>Selasa</option>
							<option value="3" <?php if($data_jadwal['hari'] == 3){ echo "SELECTED"; } ?>>Rabu</option>
							<option value="4" <?php if($data_jadwal['hari'] == 4){ echo "SELECTED"; } ?>>Kamis</option>
							<option value="5" <?php if($data_jadwal['hari'] == 5){ echo "SELECTED"; } ?>>Jumat</option>
							<option value="6" <?php if($data_jadwal['hari'] == 6){ echo "SELECTED"; } ?>>Sabtu</option>
							<option value="7" <?php if($data_jadwal['hari'] == 7){ echo "SELECTED"; } ?>>Minggu</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Jam Mulai <font color="red">*</font> <i>Jam mulai mata kuliah</i></label></td>
					<td><input type="text" name="jam_mulai" class="required" value="<?php echo $data_jadwal['jam_mulai']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Jam Selesai <font color="red">*</font> <i>Jam selesai mata kuliah</i></label></td>
					<td><input type="text" name="jam_selesai" class="required" value="<?php echo $data_jadwal['jam_selesai']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Ruang Kuliah <font color="red">*</font></label></td>
					<td><select name="ruang_id" class="required">
							<?php
							$sql_ruang = $db->database_prepare("SELECT * FROM as_ruang WHERE aktif = 'A' ORDER BY kode_ruang,nama_ruang ASC")->execute();
							while ($data_ruang = $db->database_fetch_array($sql_ruang)){
								if ($data_jadwal['ruang_id'] == $data_ruang['ruang_id']){
									echo "<option value=$data_ruang[ruang_id] SELECTED>$data_ruang[kode_ruang] - $data_ruang[nama_ruang]</option>";
								}
								else{
									echo "<option value=$data_ruang[ruang_id]>$data_ruang[kode_ruang] - $data_ruang[nama_ruang]</option>";
								}
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Program Kuliah <font color="red">*</font></label></td>
					<td><select name="program" class="required">
							<option value="A" <?php if($data_jadwal['program'] == 'A'){ echo "SELECTED"; } ?>>Reguler</option>
							<option value="B" <?php if($data_jadwal['program'] == 'B'){ echo "SELECTED"; } ?>>Non-Reguler</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Dosen Pengajar <font color="red">*</font></label></td>
					<td><select name="dosen_id" class="required">
							<?php
							$sql_dosen = $db->database_prepare("SELECT * FROM msdos WHERE STDOSMSDOS = 'A' ORDER BY NODOSMSDOS,NMDOSMSDOS ASC")->execute();
							while ($data_dosen = $db->database_fetch_array($sql_dosen)){
								if ($data_jadwal['dosen_id'] == $data_dosen['IDDOSMSDOS']){
									echo "<option value=$data_dosen[IDDOSMSDOS] SELECTED>$data_dosen[NODOSMSDOS] - $data_dosen[NMDOSMSDOS] $data_dosen[GELARMSDOS]</option>";
								}
								else{
									echo "<option value=$data_dosen[IDDOSMSDOS]>$data_dosen[NODOSMSDOS] - $data_dosen[NMDOSMSDOS] $data_dosen[GELARMSDOS]</option>";
								}
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td></td>
					<td><button type="submit" class="btn btn-primary">Simpan Perubahan</button></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	<?php
	break;
	
	case "add":
	$data_ang = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_angkatan WHERE angkatan_id = ?")->execute($_GET['tahun_angkatan']));
	$dt_prodi = $db->database_fetch_array($db->database_prepare("SELECT * FROM mspst WHERE IDPSTMSPST = ?")->execute($_GET["prodi"]));
	if ($dt_prodi['KDJENMSPST'] == 'A'){
		$kd_jenjang_studi = "S3";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'B'){
		$kd_jenjang_studi = "S2";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'C'){
		$kd_jenjang_studi = "S1";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'D'){
		$kd_jenjang_studi = "D4";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'E'){
		$kd_jenjang_studi = "D3";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'F'){
		$kd_jenjang_studi = "D2";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'G'){
		$kd_jenjang_studi = "D1";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'H'){
		$kd_jenjang_studi = "Sp-1";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'I'){
		$kd_jenjang_studi = "Sp-2";
	}
	else{
		$kd_jenjang_studi = "Profesi";
	}
?>
	<a href="javascript:history.go(-1)"><img src="../images/back.png"></a>
	<h5>Tambah Jadwal Mata Kuliah</h5>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_jadwal_kul" action="modul/mod_jadwal/aksi_jadwal.php?mod=jadwal_mata_kuliah&act=input" method="POST">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>Program Studi</label></td>
					<td><b><?php echo $kd_jenjang_studi." - ".$dt_prodi['NMPSTMSPST']; ?></b><p></p>
							<input type="hidden" name="proid" value="<?php echo $dt_prodi['IDPSTMSPST']; ?>">
							<input type="hidden" name="kelas_id" value="<?php echo $_GET['kelas_id']; ?>">
							<input type="hidden" name="semester" value="<?php echo $_GET['semester']; ?>">
					</td>
				</tr>
				<tr valign="top">
					<td><label>Tahun Angkatan</label></td>
					<td><b><?php echo $data_ang['tahun_angkatan']; ?></b><p></p>
						<input type="hidden" name="angkatan_id" value="<?php echo $data_ang['angkatan_id']; ?>">
					</td>
				</tr>
				<tr valign="top">
					<td><label>Kode Mata Kuliah <font color="red">*</font></label></td>
					<td><select name="makul_id" class="required">
							<option value="">- none -</option>
							<?php
							$sql_makul = $db->database_prepare("SELECT * FROM as_makul WHERE status_mata_kuliah = 'A' ORDER BY kode_mata_kuliah ASC")->execute();
							while ($data_makul = $db->database_fetch_array($sql_makul)){
								echo "<option value=$data_makul[mata_kuliah_id]>$data_makul[kode_mata_kuliah] - $data_makul[nama_mata_kuliah_eng]</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Hari <font color="red">*</font> <i>Hari mata kuliah</i></label></td>
					<td><select name="hari" class="required">
							<option value="">- none -</option>
							<option value="1">Senin</option>
							<option value="2">Selasa</option>
							<option value="3">Rabu</option>
							<option value="4">Kamis</option>
							<option value="5">Jumat</option>
							<option value="6">Sabtu</option>
							<option value="7">Minggu</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Jam Mulai <font color="red">*</font> <i>Jam mulai mata kuliah</i></label></td>
					<td><input type="text" name="jam_mulai" class="required"></td>
				</tr>
				<tr valign="top">
					<td><label>Jam Selesai <font color="red">*</font> <i>Jam selesai mata kuliah</i></label></td>
					<td><input type="text" name="jam_selesai" class="required"></td>
				</tr>
				<tr valign="top">
					<td><label>Ruang Kuliah <font color="red">*</font></label></td>
					<td><select name="ruang_id" class="required">
							<option value="">- none -</option>
							<?php
							$sql_ruang = $db->database_prepare("SELECT * FROM as_ruang WHERE aktif = 'A' ORDER BY kode_ruang,nama_ruang ASC")->execute();
							while ($data_ruang = $db->database_fetch_array($sql_ruang)){
								echo "<option value=$data_ruang[ruang_id]>$data_ruang[kode_ruang] - $data_ruang[nama_ruang]</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Program Kuliah <font color="red">*</font></label></td>
					<td><select name="program" class="required">
							<option value="">- none -</option>
							<option value="A">Reguler</option>
							<option value="B">Non-Reguler</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Dosen Pengajar <font color="red">*</font></label></td>
					<td><select name="dosen_id" class="required">
							<option value="">- none -</option>
							<?php
							$sql_dosen = $db->database_prepare("SELECT * FROM msdos WHERE STDOSMSDOS = 'A' ORDER BY NODOSMSDOS,NMDOSMSDOS ASC")->execute();
							while ($data_dosen = $db->database_fetch_array($sql_dosen)){
								echo "<option value=$data_dosen[IDDOSMSDOS]>$data_dosen[NODOSMSDOS] - $data_dosen[NMDOSMSDOS] $data_dosen[GELARMSDOS]</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td></td>
					<td><button type="submit" class="btn btn-primary">Simpan</button></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	<?php
	break;
}
?>