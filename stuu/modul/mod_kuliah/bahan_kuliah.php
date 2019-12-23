<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Bahan kuliah / tugas kuliah Baru berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Bahan kuliah / tugas kuliah berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Bahan kuliah / tugas kuliah berhasil dihapus.</p>
	</div>
<?php
}
if ($_GET['code'] == 4){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Bahan kuliah / tugas kuliah gagal disimpan.</p>
	</div>
<?php
}
?>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	var htmlobjek;
	$(document).ready(function() {
		$('#frm_kuliah').validate({
			rules:{
				judul: true,
				jenis: true,
				status: true,
				prodi: true,
				kelas: true,
				makul: true,
				name_file: true
			},
			messages:{
				judul:{
					required: "Judul wajib diisi."
				},
				jenis:{
					required: "Jenis wajib Diisi."
				},
				status:{
					required: "Status wajib diisi."
				},
				prodi:{
					required: "Program studi wajib diisi."
				},
				kelas:{
					required: "Kelas wajib diisi."
				},
				makul:{
					required: "Mata kuliah wajib diisi."
				},
				name_file:{
					required: "File wajib diisi."
				}
			}
		});
		
		$( "#datepicker" ).datepicker({
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
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h5>Bahan Kuliah dan Tugas Kuliah</h5><br>
	<div>
		<a href="?mod=bahan_kuliah&act=add"><button type="button" class="btn btn-green">+ Tambah Bahan/Tugas Kuliah</button></a>
	</div>
	<br>
	<table class="data display datatable" id="example">
	<thead>
		<tr>
			<th width='30'>No</th>
			<th width='180'>Judul</th>
			<th width='180'>Dosen</th>
			<th width='230'>Makul</th>
			<th width='100'>Jenis</th>
			<th width='80'>Status</th>
			<th align='left'>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$no = 1;
	$sql_bahan = $db->database_prepare("SELECT * FROM as_bahan_kuliah A 
										INNER JOIN as_makul B ON B.mata_kuliah_id = A.makul_id
										INNER JOIN as_jadwal_kuliah C ON C.makul_id = A.makul_id
										INNER JOIN msdos D ON D.IDDOSMSDOS = C.dosen_id 
										GROUP BY A.bahan_id DESC")->execute();
	while ($data_bahan = $db->database_fetch_array($sql_bahan)){
		if ($data_bahan['status'] == 'A'){
			$status_bahan = "Aktif";
		}
		else{
			$status_bahan = "Non-Aktif";
		}
		
		if ($data_bahan['jenis'] == 'B'){
			$jenis = "Bahan Kuliah";
		}
		else{
			$jenis = "Tugas Kuliah";
		}
		echo "
		<tr>
			<td>$no</td>
			<td>$data_bahan[judul]</td>
			<td>$data_bahan[NMDOSMSDOS] $data_bahan[GELARMSDOS]</td>
			<td>$data_bahan[kode_mata_kuliah] - $data_bahan[nama_mata_kuliah_eng]</td>
			<td>$jenis</td>
			<td>$status_bahan</td>
			<td>
			<a href='modul/mod_kuliah/download.php?id=$data_bahan[bahan_id]' title='Download'><img src='../images/download.png' width='20'></a>
			<a href='?mod=bahan_kuliah&act=edit&id=$data_bahan[bahan_id]' title='Edit'><img src='../images/edit.jpg' width='20'></a>";
			?>
				<a title="Hapus" href="modul/mod_kuliah/aksi_bahan_kuliah.php?mod=bahan_kuliah&act=delete&id=<?php echo $data_bahan[bahan_id];?>" onclick="return confirm('Anda Yakin ingin menghapus bahan/tugas kuliah <?php echo $data_bahan[judul];?>?');"><img src='../images/delete.jpg' width='20'></a>
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
	<a href="?mod=bahan_kuliah"><img src="../images/back.png"></a>
	<h5>Tambah Bahan/Tugas Kulaih</h5>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_kuliah" action="modul/mod_kuliah/aksi_bahan_kuliah.php?mod=bahan_kuliah&act=input" method="POST" enctype="multipart/form-data">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>Program Studi</label></td>
					<td><select name='prodi' id='prodi' class="required">
						<option value=''>- Pilih Program Studi -</option>
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
						?></select>
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
					<td><label>Mata Kuliah</label></td>
					<td><select id='makul' name='makul' class='required'>
							<option value=''>- none -</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Judul</label></td>
					<td><input type="text" name="judul" class="required" size="40"></td>
				</tr>
				<tr valign="top">
					<td><label>Jenis</label></td>
					<td><select name="jenis" class="required">
							<option value="">- none -</option>
							<option value="B">Bahan Kuliah</option>
							<option value="T">Tugas Kuliah</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Status</label></td>
					<td><select name="status" class="required">
							<option value="">- none -</option>
							<option value="A">Aktif</option>
							<option value="B">Tidak Aktif</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>File</label></td>
					<td><input type="file" name="name_file" class="required"></td>
				</tr>
				<tr valign="top">
					<td><label>Keterangan</label></td>
					<td><textarea name="keterangan" class="ckeditor"></textarea></td>
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
	$data_bahan = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_bahan_kuliah WHERE bahan_id = ?")->execute($_GET["id"]));
?>
	<a href="javascript:history.go(-1)"><img src="../images/back.png"></a>
	<h5>Ubah Bahan/Tugas Kuliah</h5>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_kuliah" action="modul/mod_kuliah/aksi_bahan_kuliah.php?mod=bahan_kuliah&act=update" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $data_bahan['bahan_id']; ?>">
			<table class="form">
				<tr valign="top">
					<td><label>Judul</label></td>
					<td><input type="text" name="judul" class="required" value="<?php echo $data_bahan['judul']; ?>" size="40"></td>
				</tr>
				<tr valign="top">
					<td><label>Jenis</label></td>
					<td><select name="jenis" class="required">
							<option value="B" <?php if($data_bahan['jenis'] == 'B'){ echo "SELECTED"; } ?>>Bahan Kuliah</option>
							<option value="T" <?php if($data_bahan['jenis'] == 'T'){ echo "SELECTED"; } ?>>Tugas Kuliah</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Status</label></td>
					<td><select name="status" class="required">
							<option value="A" <?php if($data_bahan['status'] == 'A'){ echo "SELECTED"; } ?>>Aktif</option>
							<option value="B" <?php if($data_bahan['status'] == 'B'){ echo "SELECTED"; } ?>>Tidak Aktif</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>File Lama</label></td>
					<td><a href="modul/mod_kuliah/download.php?id=<?php echo $data_bahan['bahan_id']; ?>"><?php echo $data_bahan['filename']; ?></a></td>
				</tr>
				<tr valign="top">
					<td><label>File</label></td>
					<td><input type="file" name="name_file"></td>
				</tr>
				<tr valign="top">
					<td><label>Keterangan</label></td>
					<td><textarea name="keterangan" class="ckeditor"><?php echo $data_bahan['keterangan']; ?></textarea></td>
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