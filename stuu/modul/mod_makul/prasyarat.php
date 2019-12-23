<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Mata kuliah prasyarat berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Mata kuliah prasyarat berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Mata kuliah prasyarat berhasil dihapus.</p>
	</div>
<?php
}
?>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
		$('#frm_makul_prasyarat').validate({
			rules:{
				makul_id: true,
				makul_id_prasyarat: true,
				status: true
			},
			messages:{
				makul_id:{
					required: "Pilih Nama mata kuliah."
				},
				makul_id_prasyarat:{
					required: "Pilih Nama mata kuliah prasyarat."
				},
				status:{
					required: "Pilih status mata kuliah prasyarat"
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h5>Mata Kuliah Prasyarat</h5><br>
	<div>
		<a title="Tambah Mata Kuliah Prasyarat" href="?mod=makul_prasyarat&act=add"><button type="button" class="btn btn-green">+ Tambah Mata Kuliah Prasyarat</button></a>
	</div>
		<br>		
	<table class="data display datatable" id="example">
	<thead>
		<tr>
			<td colspan="4" align="center" bgcolor="#999"><b>Mata Kuliah</b></td>
			<td colspan="6" align="center" bgcolor="#ccc"><b>Mata Kuliah Prasyarat</b></td>
		</tr>
		<tr>
			<th width='30'>No</th>
			<th width='80'>Kode</th>
			<th width='200'>Nama MK (Eng)</th>
			<!--<th width='50'>Sifat</th>-->
			<!--<th>Jenis MK</th>-->
			<th style='border-left:1px solid #ccc;' width='80'>Kode</th>
			<th width='200'>Nama MK (Eng)</th>
			<!--<th width='50'>Sifat</th>-->
			<th width='120'>Bobot Minimal</th>
			<th width='100'>Status</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$no = 1;
	$sql_makul = $db->database_prepare("SELECT * FROM as_makul_prasyarat A INNER JOIN as_makul B ON B.mata_kuliah_id=A.makul_id ORDER BY B.nama_mata_kuliah_eng ASC")->execute();
	while ($data_makul = $db->database_fetch_array($sql_makul)){
		if ($data_makul['jenis_mata_kuliah'] == 'A'){
			$jenis_mk = "Wajib";
		}
		elseif ($data_makul['jenis_mata_kuliah'] == 'B'){
			$jenis_mk = "Pilihan";
		}
		elseif ($data_makul['jenis_mata_kuliah'] == 'C'){
			$jenis_mk = "Wajib Peminatan";
		}
		elseif ($data_makul['jenis_mata_kuliah'] == 'S'){
			$jenis_mk = "TA/Skripsi/Tesis/Disertasi";
		}
		
		if ($data_makul['status'] == 'A'){
			$status = "Aktif";
		}
		else{
			$status = "Non-aktif";
		}
		
		$data_prasyarat = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_makul_prasyarat A INNER JOIN as_makul B ON B.mata_kuliah_id=A.makul_id_prasyarat WHERE A.makul_id_prasyarat = ?")->execute($data_makul['makul_id_prasyarat']));
			
		echo "
		<tr>
			<td>$no</td>
			<td>$data_makul[kode_mata_kuliah]</td>
			<td>$data_makul[nama_mata_kuliah_eng]</td>
			
			
			<td style='border-left:1px solid #ccc;'>$data_prasyarat[kode_mata_kuliah]</td>
			<td>$data_prasyarat[nama_mata_kuliah_eng]</td>
			
			<td>$data_prasyarat[bobot_minimal]</td>
			<td>$status</td>
			<td><a title='Ubah' href='?mod=makul_prasyarat&act=edit&id=$data_makul[prasyarat_id]'><img src='../images/edit.jpg' width='20'></a>";
			?>
				<a title='Hapus' href="modul/mod_makul/aksi_prasyarat.php?mod=makul_prasyarat&act=delete&id=<?php echo $data_makul[prasyarat_id];?>" onclick="return confirm('Anda Yakin ingin menghapus mata kuliah prasyarat <?php echo $data_makul[nama_mata_kuliah_eng];?>?');"><img src='../images/delete.jpg' width='20'></a>
			<?php
			echo "</td>
		</tr>";
		$no++;
	} 
	?>
	</tbody>
</table>
<?php

	break;
	
	case "add":	
?>
	<p><a href="?mod=makul_prasyarat"><img src="../images/back.png"></a></p>
	<h5>Tambah Mata Kuliah Prasyarat</h5>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_makul_prasyarat" action="modul/mod_makul/aksi_prasyarat.php?mod=makul_prasyarat&act=input" method="POST">
			<table class='form'>
				<tr valign="top">
					<td width='200'><label>Mata Kuliah <font color="red">*</font> </label></td>
					<td><select name="makul_id" class="required">
							<option value="">- none -</option>
							<?php
							$sql_makul = $db->database_prepare("SELECT * FROM as_makul WHERE status_mata_kuliah = 'A' ORDER BY nama_mata_kuliah_eng ASC")->execute();
							while ($data_makul = $db->database_fetch_array($sql_makul)){
								echo "<option value=$data_makul[mata_kuliah_id]>$data_makul[kode_mata_kuliah] - $data_makul[nama_mata_kuliah_eng]</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Mata Kuliah Prasyarat <font color="red">*</font> </label></td>
					<td><select name="makul_id_prasyarat" class="required">
							<option value="">- none -</option>
							<?php
							$sql_makul = $db->database_prepare("SELECT * FROM as_makul WHERE status_mata_kuliah = 'A' ORDER BY nama_mata_kuliah_eng ASC")->execute();
							while ($data_makul = $db->database_fetch_array($sql_makul)){
								echo "<option value=$data_makul[mata_kuliah_id]>$data_makul[kode_mata_kuliah] - $data_makul[nama_mata_kuliah_eng]</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Minimal Bobot Nilai <font color="red">*</font> <i>Minimal bobot nilai prasyarat</i></label></td>
					<td><input type="text" name="bobot_nilai" size="40" maxlength="10" value="0"></td>
				</tr>
				<tr valign="top">
					<td><label>Status Prasyarat</label></td>
					<td><select name="status" class="required">
							<option value="">- none -</option>
							<option value="A">Aktif</option>
							<option value="N">Non-aktif</option>
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
	
	case "edit":
	$data_prasyarat = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_makul_prasyarat WHERE prasyarat_id = ?")->execute($_GET["id"]));
	
?>
	<p><a href="?mod=makul_prasyarat"><img src="../images/back.png"></a></p>
	<h5>Ubah Mata Kuliah Prasyarat</h5>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_makul_prasyarat" action="modul/mod_makul/aksi_prasyarat.php?mod=makul_prasyarat&act=update" method="POST">
			<input type="hidden" name="id" value="<?php echo $data_prasyarat['prasyarat_id']; ?>">
			<table class='form'>
				<tr valign="top">
					<td width='200'><label>Mata Kuliah <font color="red">*</font> </label></td>
					<td><select name="makul_id" class="required">
							<?php
							$sql_makul = $db->database_prepare("SELECT * FROM as_makul WHERE status_mata_kuliah = 'A' ORDER BY nama_mata_kuliah_eng ASC")->execute();
							while ($data_makul = $db->database_fetch_array($sql_makul)){
								if ($data_prasyarat['makul_id'] == $data_makul['mata_kuliah_id']){
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
					<td><label>Mata Kuliah Prasyarat <font color="red">*</font> </label></td>
					<td><select name="makul_id_prasyarat" class="required">
							<?php
							$sql_makul2 = $db->database_prepare("SELECT * FROM as_makul WHERE status_mata_kuliah = 'A' ORDER BY nama_mata_kuliah_eng ASC")->execute();
							while ($data_makul2 = $db->database_fetch_array($sql_makul2)){
								if ($data_prasyarat['makul_id_prasyarat'] == $data_makul2['mata_kuliah_id']){
									echo "<option value=$data_makul2[mata_kuliah_id] SELECTED>$data_makul2[kode_mata_kuliah] - $data_makul2[nama_mata_kuliah_eng]</option>";
								}
								else{
									echo "<option value=$data_makul2[mata_kuliah_id]>$data_makul2[kode_mata_kuliah] - $data_makul2[nama_mata_kuliah_eng]</option>";
								}
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Minimal Bobot Nilai <font color="red">*</font> <i>Minimal bobot nilai prasyarat</i></label></td>
					<td><input type="text" name="bobot_nilai" size="40" maxlength="10" value="<?php echo $data_prasyarat['bobot_minimal']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Status Prasyarat</label></td>
					<td><select name="status" class="required">
							<option value="A" <?php if ($data_prasyarat['status'] == 'A'){ echo "SELECTED"; } ?>>Aktif</option>
							<option value="N" <?php if ($data_prasyarat['status'] == 'N'){ echo "SELECTED"; } ?>>Non-aktif</option>
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
}
?>