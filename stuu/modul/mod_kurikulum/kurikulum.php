<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Kurikulum Baru berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Kurikulum berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Kurikulum berhasil dihapus.</p>
	</div>
<?php
}
?>

<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
		$('#frm_kurikulum').validate({
			rules:{
				kurikulum: true,
				aktif: true,
				tgl_mulai_efektif: true,
				tgl_akhir_efektif: true
			},
			messages:{
				kurikulum:{
					required: "Nama kurikulum wajib diisi."
				},
				aktif:{
					required: "Status kurikulum wajib diisi."
				},
				tgl_mulai_efektif:{
					required: "Tanggal mulai efektif wajib diisi."
				},
				tgl_akhir_efektif:{
					required: "Tanggal akhir efektif wajib diisi."
				}
			}
		});
		
		$( "#datepicker1" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
		});
		
		$( "#datepicker2" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h4>Master Data Kurikulum</h4><br>
	<div>
		<a href="?mod=kurikulum&act=add"><button type="button" class="btn btn-green">+ Tambah Kurikulum</button></a>
	</div>
	<br>		
	<table class="data display datatable" id="example">
	<thead>
		<tr>
			<th width='30'>No</th>
			<th width='200'>Kurikulum</th>
			<th width='180'>Tanggal Mulai Efektif</th>
			<th width='180'>Tanggal Akhir Efektif</th>
			<th width='100'>Status</th>
			<th align='left'>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$no = 1;
	$sql_kurikulum = $db->database_prepare("SELECT * FROM as_kurikulum ORDER BY kurikulum_id,aktif ASC")->execute();
	while ($data_kurikulum = $db->database_fetch_array($sql_kurikulum)){
		if ($data_kurikulum['aktif'] == 'A'){
			$status_kurikulum = "Aktif";
		}
		else{
			$status_kurikulum = "Non-Aktif";
		}
		
		$tgl_mulai = tgl_indo($data_kurikulum['tgl_mulai_efektif']);
		$tgl_akhir = tgl_indo($data_kurikulum['tgl_akhir_efektif']);
		echo "
		<tr>
			<td>$no</td>
			<td>$data_kurikulum[kurikulum]</td>
			<td>$tgl_mulai</td>
			<td>$tgl_akhir</td>
			<td>$status_kurikulum</td>
			<td><a title='Ubah' href='?mod=kurikulum&act=edit&id=$data_kurikulum[kurikulum_id]'><img src='../images/edit.jpg' width='20'></a> ";
			?>
				<a title='Hapus' href="modul/mod_kurikulum/aksi_kurikulum.php?mod=kurikulum&act=delete&id=<?php echo $data_kurikulum[kurikulum_id];?>" onclick="return confirm('Anda Yakin ingin menghapus kurikulum <?php echo $data_kurikulum[kurikulum];?>?');"><img src='../images/delete.jpg' width='20'></a>
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
	<p><a href="?mod=kurikulum"><img src="../images/back.png"></a></p>
	<h4>Tambah Kurikulum</h4>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_kurikulum" action="modul/mod_kurikulum/aksi_kurikulum.php?mod=kurikulum&act=input" method="POST">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>Nama Kurikulum <font color="red">*</font></label></td>
					<td><input type="text" name="kurikulum" class="required" size="40" maxlength="50"></td>
				</tr>
				<tr valign="top">
					<td><label>Status <font color="red">*</font></label></td>
					<td><select name="aktif" class="required">
							<option value="">- none -</option>
							<option value="A">Aktif</option>
							<option value="N">Non-Aktif</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Mulai Efektif <font color="red">*</font></label></td>
					<td><input type="text" name="tgl_mulai_efektif" size="40" maxlength="10" id="datepicker1" class="required"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Akhir Efektif <font color="red">*</font></label></td>
					<td><input type="text" name="tgl_akhir_efektif" size="40" maxlength="10" id="datepicker2" class="required"></td>
				</tr>
				<tr valign="top">
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
	$data_kurikulum = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_kurikulum WHERE kurikulum_id = ?")->execute($_GET["id"]));
	
	if ($data_kurikulum['aktif'] == 'A'){
		$statusA = "SELECTED";
	}
	elseif($data_kurikulum['aktif'] == 'N'){
		$statusN = "SELECTED";
	}
	else{
		$statusA = "";
		$statusN = "";
	}
?>
	<p><a href="?mod=kurikulum"><img src="../images/back.png"></a></p>
	<h4>Ubah Fakultas</h4>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_kurikulum" action="modul/mod_kurikulum/aksi_kurikulum.php?mod=kurikulum&act=update" method="POST">
			<input type="hidden" name="id" value="<?php echo $data_kurikulum['kurikulum_id']; ?>">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>Nama Kurikulum <font color="red">*</font></label></td>
					<td><input type="text" name="kurikulum" class="required" size="40" maxlength="50" value="<?php echo $data_kurikulum['kurikulum']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Status <font color="red">*</font></label></td>
					<td><select name="aktif" class="required">
							<option value="A" <?php echo $statusA; ?>>Aktif</option>
							<option value="N" <?php echo $statusN; ?>>Non-Aktif</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Mulai Efektif <font color="red">*</font></label></td>
					<td><input type="text" name="tgl_mulai_efektif" size="40" maxlength="10" id="datepicker1" class="required" value="<?php echo $data_kurikulum['tgl_mulai_efektif']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Akhir Efektif <font color="red">*</font></label></td>
					<td><input type="text" name="tgl_akhir_efektif" size="40" maxlength="10" id="datepicker2" class="required" value="<?php echo $data_kurikulum['tgl_akhir_efektif']; ?>"></td>
				</tr>
				<tr valign="top">
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