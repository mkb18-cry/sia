<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Baru berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data berhasil dihapus.</p>
	</div>
<?php
}
?>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
		$('#frm_pemimpin').validate({
			rules:{
				tahun: true,
				kode_pt: true,
				ketua_yayasan: true,
				sekretaris_yayasan: true,
				bendahara_yayasan: true,
				rektor: true,
				pembantu1: true,
				pembantu2: true,
				pembantu3: true
			},
			messages:{
				tahun:{
					required: "Tahun akademik wajib diisi."
				},
				kode_pt:{
					required: "Kode perguruan tinggi wajib diisi."
				},
				ketua_yayasan:{
					required: "Ketua yayasan wajib diisi."
				},
				sekretaris_yayasan:{
					required: "Sekretaris yayasan wajib diisi."
				},
				bendahara_yayasan:{
					required: "Bendahara yayasan wajib diisi."
				},
				rektor:{
					required: "Rektor wajib diisi."
				},
				pembantu1:{
					required: "Pembantu rektor I wajib diisi."
				},
				pembantu2:{
					required: "Pembantu rektor II wajib diisi."
				},
				pembantu3:{
					required: "Pembantu rektor III wajib diisi."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h5>Nama Pemimpin dan Tenaga Non Akademik</h5><br>
	<a href="?mod=pemimpin&act=add"><button type="button" class="btn btn-green">+ Tambah Data</button></a><br><br>		
	<table class="data display datatable" id="example">
	<thead>
		<tr>
			<th width='30'>No</th>
			<th width='50'>Tahun</th>
			<th width='70'>Kode PT</th>
			<th width='120'>Ketua Yayasan</th>
			<th width='100'>Sekretaris</th>
			<th width='100'>Bendahara</th>
			<th width='100'>Rektor</th>
			<th width='100'>Pembantu I</th>
			<th width='100'>Pembantu II</th>
			<th width='100'>Pembantu III</th>
			<th width='50'>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$no = 1;
	$sql_pimpinan = $db->database_prepare("SELECT * FROM as_pimpinan ORDER BY pimpinan_id DESC")->execute();
	while ($data_pimpinan = $db->database_fetch_array($sql_pimpinan)){
		
		echo "
		<tr>
			<td>$no</td>
			<td>$data_pimpinan[tahun]</td>
			<td>$data_pimpinan[kode_pt]</td>
			<td>$data_pimpinan[ketua_yayasan]</td>
			<td>$data_pimpinan[sekretaris_yayasan]</td>
			<td>$data_pimpinan[bendahara_yayasan]</td>
			<td>$data_pimpinan[rektor]</td>
			<td>$data_pimpinan[pembantu1]</td>
			<td>$data_pimpinan[pembantu2]</td>
			<td>$data_pimpinan[pembantu3]</td>
			<td><a title='Ubah' href='?mod=pemimpin&act=edit&id=$data_pimpinan[pimpinan_id]'><img src='../images/edit.jpg' width='20'></a>";
			?>
				<a title='Hapus' href="modul/mod_pimpinan/aksi_pimpinan.php?mod=pemimpin&act=delete&id=<?php echo $data_pimpinan[pimpinan_id];?>" onclick="return confirm('Anda Yakin ingin menghapus pimpinan #<?php echo $data_pimpinan[tahun];?>?');"><img src='../images/delete.jpg' width='20'></a>
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
	<p><a href="?mod=pemimpin"><img src="../images/back.png"></a></p>
	<h5>Tambah Nama Pemimpin dan Tenaga Non Akademik</h5>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_pemimpin" action="modul/mod_pimpinan/aksi_pimpinan.php?mod=pemimpin&act=input" method="POST">
			<table class="form">
				<tr valign="top">
					<td width="150"><label>Tahun </label></td>
					<td><input type="text" name="tahun" class="required" size="40" maxlength="5"> <i>Tahun dan Semester, misalnya 20131 (Th. 2013, SMS 1), 20132 (Th. 2013, SMS 2)</i></td>
				</tr>
				<tr valign="top">
					<td><label>Kode Perguruan Tinggi *)</label></td>
					<td><input type="text" name="kode_pt" class="required" size="40" maxlength="6"></td>
				</tr>
				<tr valign="top">
					<td><label>Ketua Yayasan</label></td>
					<td><input type="text" name="ketua_yayasan" class="required" size="40" maxlength="100"></td>
				</tr>
				<tr valign="top">
					<td><label>Sekretaris Yayasan</label></td>
					<td><input type="text" name="sekretaris_yayasan" class="required" size="40" maxlength="100"></td>
				</tr>
				<tr valign="top">
					<td><label>Bendahara Yayasan</label></td>
					<td><input type="text" name="bendahara_yayasan" class="required" size="40" maxlength="100"></td>
				</tr>
				<tr valign="top">
					<td><label>Rektor</label></td>
					<td><input type="text" name="rektor" class="required" size="40" maxlength="100"></td>
				</tr>
				<tr valign="top">
					<td><label>Pembantu Rektor I</label></td>
					<td><input type="text" name="pembantu1" class="required" size="40" maxlength="100"></td>
				</tr>
				<tr valign="top">
					<td><label>Pembantu Rektor II</label></td>
					<td><input type="text" name="pembantu2" class="required" size="40" maxlength="100"></td>
				</tr>
				<tr valign="top">
					<td><label>Pembantu Rektor III</label></td>
					<td><input type="text" name="pembantu3" class="required" size="40" maxlength="100"></td>
				</tr>
				<tr>
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
	$data_pimpinan = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_pimpinan WHERE pimpinan_id = ?")->execute($_GET["id"]));
	?>
	<p><a href="?mod=pemimpin"><img src="../images/back.png"></a></p>
	<h5>Ubah Nama Pemimpin dan Tenaga Non Akademik</h5>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_pemimpin" action="modul/mod_pimpinan/aksi_pimpinan.php?mod=pemimpin&act=update" method="POST">
			<input type="hidden" name="id" value="<?php echo $data_pimpinan['pimpinan_id']; ?>">
			<table class="form">
				<tr valign="top">
					<td width="150"><label>Tahun </label></td>
					<td><input type="text" name="tahun" class="required" size="40" maxlength="5" value="<?php echo $data_pimpinan['tahun']; ?>"> <i>Tahun dan Semester, misalnya 20131 (Th. 2013, SMS 1), 20132 (Th. 2013, SMS 2)</i></td>
				</tr>
				<tr valign="top">
					<td><label>Kode Perguruan Tinggi *)</label></td>
					<td><input type="text" name="kode_pt" class="required" size="40" maxlength="6" value="<?php echo $data_pimpinan['kode_pt']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Ketua Yayasan</label></td>
					<td><input type="text" name="ketua_yayasan" class="required" size="40" maxlength="100" value="<?php echo $data_pimpinan['ketua_yayasan']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Sekretaris Yayasan</label></td>
					<td><input type="text" name="sekretaris_yayasan" class="required" size="40" maxlength="100" value="<?php echo $data_pimpinan['sekretaris_yayasan']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Bendahara Yayasan</label></td>
					<td><input type="text" name="bendahara_yayasan" class="required" size="40" maxlength="100" value="<?php echo $data_pimpinan['bendahara_yayasan']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Rektor</label></td>
					<td><input type="text" name="rektor" class="required" size="40" maxlength="100" value="<?php echo $data_pimpinan['rektor']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Pembantu Rektor I</label></td>
					<td><input type="text" name="pembantu1" class="required" size="40" maxlength="100" value="<?php echo $data_pimpinan['pembantu1']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Pembantu Rektor II</label></td>
					<td><input type="text" name="pembantu2" class="required" size="40" maxlength="100" value="<?php echo $data_pimpinan['pembantu2']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Pembantu Rektor III</label></td>
					<td><input type="text" name="pembantu3" class="required" size="40" maxlength="100" value="<?php echo $data_pimpinan['pembantu3']; ?>"></td>
				</tr>
				<tr>
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