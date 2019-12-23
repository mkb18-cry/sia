<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Tahun Angkatan Baru berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Tahun Angkatan berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Tahun Angkatan berhasil dihapus.</p>
	</div>
<?php
}
?>

<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
		$('#frm_angkatan').validate({
			rules:{
				semester: true,
				tahun_angkatan: true,
				aktif: true
			},
			messages:{
				semester:{
					required: "Semester Wajib Diisi."
				},
				tahun_angkatan:{
					required: "Tahun Angkatan Wajib Diisi."
				},
				aktif:{
					required: "Status Angkatan Wajib Diisi."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h4>Master Data Tahun Angkatan</h4><br>
	<div>
		<a href="?mod=angkatan&act=add"><button type="button" class="btn btn-green">+ Tambah Tahun Angkatan</button></a>
	</div>
		<br>		
	<table class="data display datatable" id="example">
	<thead>
		<tr>
			<th width='30'>No</th>
			<th width='100'>ID Angkatan</th>
			<th width='150'>Tahun Angkatan</th>
			<th width='150'>Semester</th>
			<th width='100'>Status</th>
			<th align='left'>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$no = 1;
	$sql_angkatan = $db->database_prepare("SELECT * FROM as_angkatan ORDER BY tahun_angkatan,aktif ASC")->execute();
	while ($data_angkatan = $db->database_fetch_array($sql_angkatan)){
		if ($data_angkatan['aktif'] == 'A'){
			$status_angkatan = "Aktif";
		}
		else{
			$status_angkatan = "Non-Aktif";
		}
		
		if ($data_angkatan['semester_angkatan'] == 'A'){
			$semester = "Genap";
		}
		else{
			$semester = "Ganjil";
		}
		
		echo "
		<tr>
			<td>$no</td>
			<td>$data_angkatan[angkatan_id]</td>
			<td>$data_angkatan[tahun_angkatan]</td>
			<td>$semester</td>
			<td>$status_angkatan</td>
			<td><a title='Ubah' href='?mod=angkatan&act=edit&id=$data_angkatan[angkatan_id]'><img src='../images/edit.jpg' width='20'></a> ";
			?>
				<a title="Hapus" href="modul/mod_angkatan/aksi_angkatan.php?mod=angkatan&act=delete&id=<?php echo $data_angkatan[angkatan_id];?>" onclick="return confirm('Anda Yakin ingin menghapus Angkatan <?php echo $semester." ".$data_angkatan[tahun_angkatan];?>?');"><img src='../images/delete.jpg' width='20'></a>
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
	<a href="?mod=angkatan"><img src="../images/back.png"></a>
	<h4>Tambah Tahun Angkatan</h4>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_angkatan" action="modul/mod_angkatan/aksi_angkatan.php?mod=angkatan&act=input" method="POST">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>Semester <font color="red">*</font></label></td>
					<td><select name="semester" class="required">
							<option value="">- none -</option>
							<option value="A">Genap</option>
							<option value="B">Ganjil</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td width="200"><label>Tahun Angkatan <font color="red">*</font></label></td>
					<td><input type="text" name="tahun_angkatan" class="required" size="40" maxlength="4"> <br>Misalnya 2013, 2014, 2015</td>
				</tr>
				<tr valign="top">
					<td width="200"><label>Status <font color="red">*</font></label></td>
					<td><select name="aktif" class="required">
							<option value="">- none -</option>
							<option value="A">Aktif</option>
							<option value="N">Non-Aktif</option>
						</select>
					</td>
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
	$data_angkatan = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_angkatan WHERE angkatan_id = ?")->execute($_GET["id"]));
	
	if ($data_angkatan['aktif'] == 'A'){
		$statusA = "SELECTED";
	}
	elseif($data_angkatan['aktif'] == 'N'){
		$statusN = "SELECTED";
	}
	else{
		$statusA = "";
		$statusN = "";
	}
	
	if ($data_angkatan['semester_angkatan'] == 'A'){
		$semesterA = "SELECTED";
	}
	elseif($data_angkatan['semester_angkatan'] == 'B'){
		$semesterB = "SELECTED";
	}
	else{
		$semesterA = "";
		$semesterB = "";
	}
?>
	<a href="?mod=angkatan"><img src="../images/back.png"></a>
	<h4>Ubah Tahun Angkatan</h4>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_angkatan" action="modul/mod_angkatan/aksi_angkatan.php?mod=angkatan&act=update" method="POST">
			<input type="hidden" name="id" value="<?php echo $data_angkatan['angkatan_id']; ?>">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>Semester <font color="red">*</font></label></td>
					<td><select name="semester" class="required">
							<option value="A" <?php echo $semesterA; ?>>Genap</option>
							<option value="B" <?php echo $semesterB; ?>>Ganjil</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td width="200"><label>Tahun Angkatan <font color="red">*</font></label></td>
					<td><input type="text" name="tahun_angkatan" class="required" size="40" maxlength="4" value="<?php echo $data_angkatan['tahun_angkatan']; ?>"> <br>Misalnya 2013, 2014, 2015</td>
				</tr>
				<tr valign="top">
					<td width="200"><label>Status <font color="red">*</font></label></td>
					<td><select name="aktif" class="required">
							<option value="A" <?php echo $statusA; ?>>Aktif</option>
							<option value="N" <?php echo $statusN; ?>>Non-Aktif</option>
						</select>
					</td>
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