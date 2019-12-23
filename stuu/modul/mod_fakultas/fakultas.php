<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Fakultas Baru berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Fakultas berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Fakultas berhasil dihapus.</p>
	</div>
<?php
}
?>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
		$('#frm_fakultas').validate({
			rules:{
				fakultas: true,
				aktif: true
			},
			messages:{
				fakultas:{
					required: "Nama Fakultas Wajib Diisi."
				},
				aktif:{
					required: "Status Fakultas Wajib Diisi."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h4>Master Data Fakultas</h4><br>
	<div>
		<a href="?mod=fakultas&act=add"><button type="button" class="btn btn-green">+ Tambah Fakultas</button></a>
	</div>
		<br>		
	<table class="data display datatable" id="example">
	<thead>
		<tr>
			<th width='30'>No</th>
			<th width='150'>Fakultas</th>
			<th width='100'>Status</th>
			<th align='left'>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$no = 1;
	$sql_fakultas = $db->database_prepare("SELECT * FROM msfks ORDER BY fakultas ASC")->execute();
	while ($data_fakultas = $db->database_fetch_array($sql_fakultas)){
		if ($data_fakultas['aktif'] == 'A'){
			$status_fakultas = "Aktif";
		}
		else{
			$status_fakultas = "Non-Aktif";
		}
		echo "
		<tr>
			<td>$no</td>
			<td>$data_fakultas[fakultas]</td>
			<td>$status_fakultas</td>
			<td><a title='Ubah' href='?mod=fakultas&act=edit&id=$data_fakultas[fakultas_id]'><img src='../images/edit.jpg' width='20'></a>";
			?>
				<a title='Hapus' href="modul/mod_fakultas/aksi_fakultas.php?mod=fakultas&act=delete&id=<?php echo $data_fakultas[fakultas_id];?>" onclick="return confirm('Anda Yakin ingin menghapus fakultas <?php echo $data_fakultas[fakultas];?>?');"><img src='../images/delete.jpg' width='20'></a>
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
	<p><a href="?mod=fakultas"><img src="../images/back.png"></a></p>
	<h4>Tambah Fakultas</h4>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_fakultas" action="modul/mod_fakultas/aksi_fakultas.php?mod=fakultas&act=input" method="POST">
			<table class="form">
				<tr valign="top">
					<td width="110"><label>Nama Fakultas *)</label></td>
					<td><input type="text" name="fakultas" class="required" size="40"></td>
				</tr>
				<tr valign="top">
					<td><label>Status *)</label></td>
					<td><select name="aktif" class="required">
							<option value="">- none -</option>
							<option value="A">Aktif</option>
							<option value="N">Non-Aktif</option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><button type="submit" class="btn btn-primary"><i class="icon-save"></i> Simpan</button></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	<?php
	break;
	
	case "edit":
	$data_fakultas = $db->database_fetch_array($db->database_prepare("SELECT * FROM msfks WHERE fakultas_id = ?")->execute($_GET["id"]));
	
	if ($data_fakultas['aktif'] == 'A'){
		$statusA = "SELECTED";
	}
	elseif($data_fakultas['aktif'] == 'N'){
		$statusN = "SELECTED";
	}
	else{
		$statusA = "";
		$statusN = "";
	}
?>
	<p><a href="?mod=fakultas"><img src="../images/back.png"></a></p>
	<h4>Ubah Fakultas</h4>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_fakultas" action="modul/mod_fakultas/aksi_fakultas.php?mod=fakultas&act=update" method="POST">
			<input type="hidden" name="id" value="<?php echo $data_fakultas['fakultas_id']; ?>">
			<table class="form">
				<tr valign="top">
					<td width="110"><label>Nama Fakultas *)</label></td>
					<td><input type="text" name="fakultas" class="required" size="40" value="<?php echo $data_fakultas['fakultas']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Status *)</label></td>
					<td><select name="aktif" class="required">
							<option value="A" <?php echo $statusA; ?>>Aktif</option>
							<option value="N" <?php echo $statusN; ?>>Non-Aktif</option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><button type="submit" class="btn btn-primary"><i class="icon-save"></i> Simpan Perubahan</button></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	<?php
	break;
}
?>