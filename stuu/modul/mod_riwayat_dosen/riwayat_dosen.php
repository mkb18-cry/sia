<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Riwayat baru berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Riwayat berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Riwayat berhasil dihapus.</p>
	</div>
<?php
}
?>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.autocomplete.css" />
<script type="text/javascript" src="../js/jquery.autocomplete.js"></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
		$("#tag").autocomplete("modul/mod_riwayat_dosen/autocomplete.php", {
			selectFirst: true
		});
		
		$("#tag2").autocomplete("modul/mod_riwayat_dosen/autocomplete2.php", {
			selectFirst: true
		});
		
		$( "#datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: 'c-65:c-0'
		});
		
		$('#frm_form').validate({
			rules:{
				nid: true
			},
			messages:{
				nid:{
					required: "Masukkan Nomor Induk Dosen terlebih dahulu."
				}
			}
		});
		
		$('#frm_riwayat').validate({
			rules:{
				kode_pt: true,
				kode_prodi: true,
				gelar_akademik: true,
				tanggal_lulus: true,
				sks_lulus: true,
				ipk: true
			},
			messages:{
				kode_pt:{
					required: "Perguruan tinggi wajib diisi."
				},
				kode_prodi:{
					required: "Program studi wajib diisi."
				},
				gelar_akademik:{
					required: "Gelar Akademik wajib diisi."
				},
				tanggal_lulus:{
					required: "Tanggal lulus wajib diisi."
				},
				sks_lulus:{
					required: "SKS lulus wajib diisi."
				},
				ipk:{
					required: "IPK akhir wajib diisi."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h5>Masukkan NID/NIP Dosen</h5>
	<div class="box round first fullpage">
		<div class="block ">
			<form action="" method="GET" id="frm_form">
			<input type="hidden" name="mod" value="riwayat_pendidikan_dosen">
			<input type="hidden" name="act" value="form">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>NID Dosen</label></td>
					<td><input type="text" name="nid" size="40" maxlength="15" class="required"></td>
				</tr>
				<tr valign="top">
					<td></td>
					<td><button type="submit" class="btn btn-primary">Buka Data</button></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
<?php

	break;
	
	case "form":
	$sql_dosen = $db->database_prepare("SELECT * FROM msdos WHERE NODOSMSDOS = ?")->execute($_GET['nid']);
	$nums = $db->database_num_rows($sql_dosen);
	if ($nums == 0){
		echo "<p>&nbsp;</p><div class='well'>NID/NIP Dosen tidak ditemukan. <br><a href='javascript:history.go(-1)'>Back</a></div>";
	}
	else{
		$data_dosen = $db->database_fetch_array($sql_dosen);
		
		echo "<a href='index.php?mod=riwayat_pendidikan_dosen'><img src='../images/back.png'></a>
			<h5>Riwayat Pendidikan Dosen</h5>
			<div class='box round first fullpage'>
			<div class='block '>
				<table class='form'>
					<tr>
						<td width='100'>NID</td>
						<td width='5'>:</td>
						<td><b>$data_dosen[NODOSMSDOS] <input type='hidden' name='id_dosen' value='$data_dosen[IDDOSMSDOS]'></b></td>
					</tr>
					<tr>
						<td>Nama Dosen</td>
						<td>:</td>
						<td><b>$data_dosen[NMDOSMSDOS] $data_dosen[GELARMSDOS]</b></td>
					</tr>
				</table>
			</div></div>";
		
		echo "<div>
			<a href='index.php?mod=riwayat_pendidikan_dosen&act=add&nid=$_GET[nid]&id_dos=$data_dosen[IDDOSMSDOS]'><button type='button' class='btn btn-green'>+ Riwayat Pendidikan</button></a>
		</div><br>
			<table class='data display datatable' id='example'>
				<thead>
					<tr>
						<th width='30'>No</th>
						<th width='200'>Nama Perguruan Tinggi</th>
						<th width='150'>Program Studi</th>
						<th width='120'>Gelar Akademik</th>
						<th width='120'>Tanggal Ijazah</th>
						<th width='80'>SKS Lulus</th>
						<th width='100'>IPK Akhir</th>
						<th>Aksi</th>
					</tr>
				</thead><tbody>";
		$i = 1;	
		$sql_riwayat = $db->database_prepare("SELECT * FROM as_riwayat_pendidikan_dosen A INNER JOIN as_kode_perguruan_tinggi B ON B.kode_perguruan_tinggi = A.kode_perguruan_tinggi 
											INNER JOIN as_kode_program_studi C ON C.kode_program_studi=A.kode_program_studi 
											WHERE dosen_id=? ORDER BY riwayat_id ASC")->execute($data_dosen['IDDOSMSDOS']);
		while ($data_riwayat = $db->database_fetch_array($sql_riwayat)){
			if ($data_riwayat['kode_jenjang_studi'] == 'A'){
				$kd_jenjang_studi = "S3";
			}
			elseif ($data_riwayat['kode_jenjang_studi'] == 'B'){
				$kd_jenjang_studi = "S2";
			}
			elseif ($data_riwayat['kode_jenjang_studi'] == 'C'){
				$kd_jenjang_studi = "S1";
			}
			elseif ($data_riwayat['kode_jenjang_studi'] == 'D'){
				$kd_jenjang_studi = "D4";
			}
			elseif ($data_riwayat['kode_jenjang_studi'] == 'E'){
				$kd_jenjang_studi = "D3";
			}
			elseif ($data_riwayat['kode_jenjang_studi'] == 'F'){
				$kd_jenjang_studi = "D2";
			}
			elseif ($data_riwayat['kode_jenjang_studi'] == 'G'){
				$kd_jenjang_studi = "D1";
			}
			elseif ($data_riwayat['kode_jenjang_studi'] == 'H'){
				$kd_jenjang_studi = "Sp-1";
			}
			elseif ($data_riwayat['kode_jenjang_studi'] == 'I'){
				$kd_jenjang_studi = "Sp-2";
			}
			else{
				$kd_jenjang_studi = "Profesi";
			}
			
			$tgl = tgl_indo($data_riwayat['tanggal_ijazah']);
			echo "<tr valign=top>
					<td>$i</td>
					<td>$data_riwayat[nama_perguruan_tinggi]</td>
					<td>$kd_jenjang_studi $data_riwayat[nama_program_studi]</td>
					<td>$data_riwayat[gelar_akademik]</td>
					<td>$tgl</td>
					<td>$data_riwayat[sks_lulus]</td>
					<td>$data_riwayat[ipk_akhir]</td>
					<td><a title='Ubah' href='?mod=riwayat_pendidikan_dosen&act=edit&id=$data_riwayat[riwayat_id]&nid=$data_dosen[NODOSMSDOS]'><img src='../images/edit.jpg' width='20'></a>";
					?>
						<a title="Hapus" href="modul/mod_riwayat_dosen/aksi_riwayat_dosen.php?mod=riwayat_pendidikan_dosen&act=delete&id=<?php echo $data_riwayat[riwayat_id];?>&nid=<?php echo $data_dosen[NODOSMSDOS]; ?>" onclick="return confirm('Anda Yakin ingin menghapus riwayat pendidikan #<?php echo $data_riwayat[nama_perguruan_tinggi];?>?');"><img src='../images/delete.jpg' width='20'></a>
					<?php
					echo "</td>
				</tr>";
			$i++;
		}
		echo "</tbody></table>";
	}
	break;
	
	case "add":
	$data_dosen = $db->database_fetch_array($db->database_prepare("SELECT * FROM msdos WHERE NODOSMSDOS = ? AND IDDOSMSDOS = ?")->execute($_GET["nid"],$_GET["id_dos"]));
	echo "<a href='index.php?mod=riwayat_pendidikan_dosen&act=form&nid=$_GET[nid]'><img src='../images/back.png'></a>
			<h5>Tambah Riwayat Pendidikan Dosen</h5>
			<form method='POST' action='modul/mod_riwayat_dosen/aksi_riwayat_dosen.php?mod=riwayat_dosen&act=input' id='frm_riwayat'>
			<div class='box round first fullpage'>
			<div class='block '>
				<table class='form'>
					<tr valign='top'>
						<td width='200'><label>NIP</label></td>
						<td><b>$data_dosen[NODOSMSDOS] <input type='hidden' name='id_dosen' value='$data_dosen[IDDOSMSDOS]'><input type='hidden' name='no_dosen' value='$data_dosen[NODOSMSDOS]'></b></td>
					</tr>
					<tr valign='top'>
						<td><label>Nama Dosen</label></td>
						<td><b>$data_dosen[NMDOSMSDOS] $data_dosen[GELARMSDOS]</b></td>
					</tr>";
					?>
					<tr valign='top'>
						<td width='200'><label>Nama Perguruan Tinggi <font color="red">*</font> <i>Nama perguruan tinggi</i></label></td>
						<td><input name="kode_pt" type="text" id="tag" size="40" class="required"/></td>
					</tr>
					<tr valign='top'>
						<td><label>Program Studi <font color="red">*</font> <i>Nama program studi</i></label></td>
						<td><input name="kode_prodi" type="text" id="tag2" size="40" class="required"/></td>
					</tr>
					<tr valign='top'>
						<td><label>Gelar Akademik <font color="red">*</font> <i>Gelar akademik</i></label></td>
						<td><input type="text" class="required" name="gelar_akademik" size="40" maxlength="30"></td>
					</tr>
					<tr valign='top'>
						<td><label>Tanggal Lulus <font color="red">*</font> <i>Tanggal lulus</i></label></td>
						<td><input type="text" class="required" name="tanggal_lulus" size="40" maxlength="10" id="datepicker"></td>
					</tr>
					<tr valign='top'>
						<td><label>SKS Lulus <i>SKS lulus</i></label></td>
						<td><input type="text" name="sks_lulus" size="40" maxlength="11" class="required"></td>
					</tr>
					<tr valign='top'>
						<td><label>IPK Akhir <i>IPK Akhir</i></label></td>
						<td><input type="text" name="ipk" size="40" maxlength="5" class="required"></td>
					</tr>
					<tr valign="top">
						<td></td>
						<td><button type="submit" class="btn btn-primary">Simpan</button></td>
					</tr>
				</table>
			</div>
		</div>
		</form>
	<?php
	break;
	
	case "edit":
	$data_dosen = $db->database_fetch_array($db->database_prepare("SELECT * FROM msdos WHERE NODOSMSDOS= ?")->execute($_GET["nid"]));
	$data_riwayat = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_riwayat_pendidikan_dosen A INNER JOIN as_kode_perguruan_tinggi B ON B.kode_perguruan_tinggi = A.kode_perguruan_tinggi
											INNER JOIN as_kode_program_studi C ON C.kode_program_studi = A.kode_program_studi
											WHERE A.riwayat_id = ?")->execute($_GET["id"]));
	echo "
		<a href='index.php?mod=riwayat_pendidikan_dosen&act=form&nid=$_GET[nid]'><img src='../images/back.png'></a>
		<h5>Ubah Riwayat Pendidikan Dosen</h5>
			<form method='POST' action='modul/mod_riwayat_dosen/aksi_riwayat_dosen.php?mod=riwayat_dosen&act=update' id='frm_riwayat'>
			<div class='box round first fullpage'>
			<div class='block '>
				<table class='form'>
					<tr valign='top'>
						<td width='200'><label>NIP</label></td>
						<td><b>$data_dosen[NODOSMSDOS] <input type='hidden' name='id_dosen' value='$data_dosen[IDDOSMSDOS]'><input type='hidden' name='no_dosen' value='$data_dosen[NODOSMSDOS]'></b></td>
					</tr>
					<tr valign='top'>
						<td><label>Nama Dosen</label></td>
						<td><b>$data_dosen[NMDOSMSDOS] $data_dosen[GELARMSDOS]</b></td>
					</tr>";
					?>
					<tr valign='top'>
						<td width='200'><label>Nama Perguruan Tinggi <font color="red">*</font> <i>Nama perguruan tinggi</i></label></td>
						<td><input name="kode_pt" type="text" id="tag" size="40" class="required" value="<?php echo $data_riwayat['nama_perguruan_tinggi']." ".$data_riwayat['kota']." : ".$data_riwayat['kode_perguruan_tinggi']; ?>"></td>
					</tr>
					<tr valign='top'>
						<td><label>Program Studi <font color="red">*</font> <i>Nama program studi</i></label></td>
						<td><input name="kode_prodi" type="text" id="tag2" size="40" class="required" value="<?php echo $data_riwayat['jenjang_studi']." : ".$data_riwayat['nama_program_studi']." : ".$data_riwayat['kode_program_studi']; ?>"></td>
					</tr>
					<tr valign='top'>
						<td><label>Gelar Akademik <font color="red">*</font> <i>Gelar akademik</i></label></td>
						<td><input type="text" class="required" name="gelar_akademik" size="40" maxlength="30" value="<?php echo $data_riwayat['gelar_akademik']; ?>"></td>
					</tr>
					<tr valign='top'>
						<td><label>Tanggal Lulus <font color="red">*</font> <i>Tanggal lulus</i></label></td>
						<td><input type="text" class="required" name="tanggal_lulus" size="40" maxlength="10" id="datepicker" value="<?php echo $data_riwayat['tanggal_ijazah']; ?>"></td>
					</tr>
					<tr valign='top'>
						<td><label>SKS Lulus <i>SKS lulus</i></label></td>
						<td><input type="text" name="sks_lulus" size="40" maxlength="11" class="required" value="<?php echo $data_riwayat['sks_lulus']; ?>"></td>
					</tr>
					<tr valign='top'>
						<td><label>IPK Akhir <i>IPK Akhir</i></label></td>
						<td><input type="text" name="ipk" size="40" maxlength="5" class="required" value="<?php echo $data_riwayat['ipk_akhir']; ?>">
							<input type="hidden" name="id" size="40" maxlength="5" value="<?php echo $data_riwayat['riwayat_id']; ?>">
						</td>
					</tr>
					<tr valign="top">
						<td></td>
						<td><button type="submit" class="btn btn-primary">Simpan Perubahan</button></td>
					</tr>
				</table>
			</div>
		</div>
		</form>
	<?php
	break;
}
?>