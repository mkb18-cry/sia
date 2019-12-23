<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Ruang berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Ruang berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Ruang berhasil dihapus.</p>
	</div>
<?php
}
?>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
		$('#frm_ruang').validate({
			rules:{
				nama_ruang: true,
				jenis: true,
				status: true
			},
			messages:{
				nama_ruang:{
					required: "Nama ruang Wajib Diisi."
				},
				jenis:{
					required: "Jenis ruang Wajib Diisi."
				},
				status:{
					required: "Status ruang wajib diisi."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h4>Master Data Ruang Kelas</h4><br>
	<div>
		<a href="?mod=ruang&act=add"><button type="button" class="btn btn-green">+ Tambah Ruang Kelas</button></a>
	</div>
	<br>		
	<table class="data display datatable" id="example">
	<thead>
		<tr>
			<th width='30'>No</th>
			<th width='100'>Kode</th>
			<th width='150'>Nama Ruang</th>
			<th width='110'>Jenis</th>
			<th width='100'>Status</th>
			<th width='200'>Kepala Ruang</th>
			<th align='left'>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$no = 1;
	$sql_ruang = $db->database_prepare("SELECT * FROM as_ruang LEFT JOIN msdos ON msdos.IDDOSMSDOS=as_ruang.head_id ORDER BY kode_ruang ASC")->execute();
	while ($data_ruang = $db->database_fetch_array($sql_ruang)){
		if ($data_ruang['aktif'] == 'A'){
			$status = "Aktif";
		}
		else{
			$status = "Tidak Aktif";
		}
		
		if ($data_ruang['jenis'] == 'A'){
			$jenis = "Kelas";
		}
		elseif ($data_ruang['jenis'] == 'B'){
			$jenis = "Laboratorium";
		}
		else{
			$jenis = "Auditorium";
		}
		
		echo "
		<tr>
			<td>$no</td>
			<td>$data_ruang[kode_ruang]</td>
			<td>$data_ruang[nama_ruang]</td>
			<td>$jenis</td>
			<td>$status</td>
			<td>$data_ruang[NMDOSMSDOS] $data_ruang[GELARMSDOS]</td>
			<td><a title='Ubah' href='?mod=ruang&act=edit&id=$data_ruang[ruang_id]'><img src='../images/edit.jpg' width='20'></a>";
			?>
				<a title="Hapus" href="modul/mod_ruang/aksi_ruang.php?mod=ruang&act=delete&id=<?php echo $data_ruang[ruang_id];?>" onclick="return confirm('Anda Yakin ingin menghapus ruang <?php echo $data_ruang[nama_ruang];?>?');"><img src='../images/delete.jpg' width='20'></a>
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
	$sql_urut = $db->database_prepare("SELECT kode_ruang FROM as_ruang ORDER BY ruang_id DESC LIMIT 1")->execute();
	$num_urut = $db->database_num_rows($sql_urut);
	
	$data_urut = $db->database_fetch_array($sql_urut);
	$awal = substr($data_urut['kode_ruang'],0-4);
	$next = $awal + 1;
	$jnim = strlen($next);
	
	if (!$data_urut['kode_ruang']){
		$no = "0001";
	}
	elseif($jnim == 1){
		$no = "000";
	} 
	elseif($jnim == 2){
		$no = "00";
	}
	elseif($jnim == 3){
		$no = "0";
	}
	elseif($jnim == 4){
		$no = "";
	}
	if ($num_urut == 0){
		$kr = "R".$no;
	}
	else{
		$kr = "R".$no.$next;
	}	
		
?>
	<p><a href="?mod=ruang"><img src="../images/back.png"></a></p>
	<h4>Tambah Ruang</h4>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_ruang" action="modul/mod_ruang/aksi_ruang.php?mod=ruang&act=input" method="POST">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>Kode Ruang <i>Kode ruang</i></label></td>
					<td><input type="text" name="kode_ruang" size="40" maxlength="10" value="<?php echo $kr; ?>" DISABLED>
						<input type="hidden" name="kode_ruang" size="40" maxlength="10" value="<?php echo $kr; ?>">
					</td>
				</tr>
				<tr valign="top">
					<td><label>Nama Ruang <font color="red">*</font> <i>Nama ruangan</i></label></td>
					<td><input type="text" name="nama_ruang" class="required" size="40" maxlength="40"></td>
				</tr>
				<tr valign="top">
					<td><label>Jenis Ruang <font color="red">*</font> <i>Jenis ruangan</label></td>
					<td><select name="jenis" class="required">
							<option value="">- none -</option>
							<option value="A">Kelas</option>
							<option value="B">Laboratorium</option>
							<option value="C">Auditorium</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Status <font color="red">*</font> <i>Status ruangan</label></td>
					<td><select name="status" class="required">
							<option value="">- none -</option>
							<option value="A">Aktif</option>
							<option value="B">Tidak Aktif</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Kepala Ruang <i>Kepala ruangan</i></label></td>
					<td><select name="head_id">
							<option value="">- none -</option>	
							<?php
							$sql_dosen = $db->database_prepare("SELECT * FROM msdos WHERE STDOSMSDOS = 'A' ORDER BY NODOSMSDOS ASC")->execute();
							while ($data_dosen = $db->database_fetch_array($sql_dosen)){
								echo "<option value=$data_dosen[IDDOSMSDOS]>$data_dosen[NODOSMSDOS] - $data_dosen[NMDOSMSDOS] $data_dosen[GELARMSDOS]</option>";
							} 
							?>	
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
	$data_ruang = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_ruang WHERE ruang_id = ?")->execute($_GET["id"]));
	
?>
	<p><a href="?mod=ruang"><img src="../images/back.png"></a></p>
	<h4>Ubah Ruang</h4>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_ruang" action="modul/mod_ruang/aksi_ruang.php?mod=ruang&act=update" method="POST">
			<input type="hidden" name="id" value=<?php echo $data_ruang['ruang_id']; ?>">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>Kode Ruang <i>Kode ruang</i></label></td>
					<td><input type="text" name="kode_ruang" size="40" maxlength="10" value="<?php echo $data_ruang['kode_ruang']; ?>" DISABLED></td>
				</tr>
				<tr valign="top">
					<td><label>Nama Ruang <font color="red">*</font> <i>Nama ruangan</i></label></td>
					<td><input type="text" name="nama_ruang" class="required" size="40" maxlength="40" value="<?php echo $data_ruang['nama_ruang']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Jenis Ruang <font color="red">*</font> <i>Jenis ruangan</label></td>
					<td><select name="jenis" class="required">
							<option value="A" <?php if($data_ruang['jenis'] == 'A'){ echo "SELECTED"; } ?>>Kelas</option>
							<option value="B" <?php if($data_ruang['jenis'] == 'B'){ echo "SELECTED"; } ?>>Laboratorium</option>
							<option value="C" <?php if($data_ruang['jenis'] == 'C'){ echo "SELECTED"; } ?>>Auditorium</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Status <font color="red">*</font> <i>Status ruangan</label></td>
					<td><select name="status" class="required">
							<option value="A" <?php if($data_ruang['aktif'] == 'A'){ echo "SELECTED"; } ?>>Aktif</option>
							<option value="B" <?php if($data_ruang['aktif'] == 'B'){ echo "SELECTED"; } ?>>Tidak Aktif</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Kepala Ruang <i>Kepala ruangan</i></label></td>
					<td><select name="head_id">
							<option value="">- none -</option>	
							<?php
							$sql_dosen = $db->database_prepare("SELECT * FROM msdos WHERE STDOSMSDOS = 'A' ORDER BY NODOSMSDOS ASC")->execute();
							while ($data_dosen = $db->database_fetch_array($sql_dosen)){
								if ($data_dosen['IDDOSMSDOS'] == $data_ruang['head_id']){
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