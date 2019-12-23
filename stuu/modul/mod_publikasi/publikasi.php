<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Publikasi baru berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Publikasi berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Publikasi berhasil dihapus.</p>
	</div>
<?php
}
?>

<script type='text/javascript' src='../js/jquery.validate.js'></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.autocomplete.css" />
<script type="text/javascript" src="../js/jquery.autocomplete.js"></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
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
		
		$('#frm_publikasi').validate({
			rules:{
				jenis_penelitian: true,
				pengarang: true,
				hasil_penelitian: true,
				media_publikasi: true,
				penelitian_dilaksanakan: true,
				jenis_pembiayaan: true,
				periode_penelitian:true,
				judul: true,
				kata_kunci: true,
				waktu_pelaksanaan: true,
				status_validasi: true
			},
			messages:{
				jenis_penelitian:{
					required: "Jenis penelitian wajib diisi."
				},
				pengarang:{
					required: "Pengarang wajib diisi."
				},
				hasil_penelitian:{
					required: "Hasil penelitian wajib diisi."
				},
				media_publikasi:{
					required: "Media publikasi wajib diisi."
				},
				penelitian_dilaksanakan:{
					required: "Penelitian dilaksanakan secara wajib diisi."
				},
				jenis_pembiayaan:{
					required: "Jenis pembiayaan wajib diisi."
				},
				periode_penelitian:{
					required: "Periode penelitian wajib diisi."
				},
				judul:{
					required: "Judul penelitian wajib diisi."
				},
				kata_kunci:{
					required: "Kata kunci wajib diisi."
				},
				waktu_pelaksanaan:{
					required: "Waktu pelaksanaan penelitian wajib diisi."
				},
				status_validasi:{
					required: "Status validasi dari DIKTI wajib diisi."
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
			<input type="hidden" name="mod" value="publikasi">
			<input type="hidden" name="act" value="form">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>NID Dosen</label></td>
					<td><input type="text" name="nid" size="40" maxlength="15" class="required"></td>
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
	
	case "form":
	$sql_dosen = $db->database_prepare("SELECT * FROM msdos WHERE NODOSMSDOS = ?")->execute($_GET['nid']);
	$nums = $db->database_num_rows($sql_dosen);
	if ($nums == 0){
		echo "<p>&nbsp;</p><div class='well'>NID/NIP Dosen tidak ditemukan. <br><a href='javascript:history.go(-1)'>Back</a></div>";
	}
	else{
		$data_dosen = $db->database_fetch_array($sql_dosen);
		
		echo "<a href='index.php?mod=publikasi'><img src='../images/back.png'></a>
			<h5>Publikasi Dosen</h5>
			<div class='box round first fullpage'>
			<div class='block '>
				<table class='form'>
					<tr valign='top'>
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
				<a href='index.php?mod=publikasi&act=add&nid=$_GET[nid]&id_dos=$data_dosen[IDDOSMSDOS]'><button type='button' class='btn btn-green'>+ Publikasi Dosen</button></a>
			</div><br>
			<table class='data display datatable' id='example'>
				<thead>
					<tr>
						<th width='30'>No</th>
						<th width='120'>Judul</th>
						<th width='150'>Jenis Penelitian</th>
						<th width='180'>Media Publikasi</th>
						<th width='180'>Pengarang</th>
						<th width='180'>Pelaksanaan</th>
						<th>Aksi</th>
					</tr>
				</thead><tbody>";
		$i = 1;	
		$sql_publikasi = $db->database_prepare("SELECT * FROM as_publikasi_dosen  
											WHERE dosen_id=? ORDER BY publikasi_id ASC")->execute($data_dosen['IDDOSMSDOS']);
		while ($data_publikasi = $db->database_fetch_array($sql_publikasi)){
			if ($data_publikasi['media_publikasi'] == 'A'){
				$media = "Majalah Populer/Koran";
			}
			elseif ($data_publikasi['media_publikasi'] == 'B'){
				$media = "Seminar Nasional";
			}
			elseif ($data_publikasi['media_publikasi'] == 'C'){
				$media = "Seminar Internasional";
			}
			elseif ($data_publikasi['media_publikasi'] == 'D'){
				$media = "Prosiding (ISBN)";
			}
			elseif ($data_publikasi['media_publikasi'] == 'E'){
				$media = "Jurnal Nasional Belum Akreditasi";
			}
			elseif ($data_publikasi['media_publikasi'] == 'F'){
				$media = "Jurnal Nasional Terakreditasi";
			}
			else{
				$media = "Jurnal Internasional";
			}
			
			if ($data_publikasi['jenis_penelitian'] == 'A'){
				$hasil_penelitian = "Hasil Penelitian";
			}
			else{
				$hasil_penelitian = "Non-Penelitian";
			}
			
			if ($data_publikasi['kode_pengarang'] == 'A'){
				$pengarang = "Penulis Anggota";
			}
			elseif ($data_publikasi['kode_pengarang'] == 'B'){
				$pengarang = "Penulis Utama";
			}
			else{
				$pengarang = "Penulis Mandiri";
			}
			
			if ($data_publikasi['penelitian_dilaksanakan_secara'] == 'M'){
				$pelaksanaan = "Mandiri";
			}
			else{
				$pelaksanaan = "Kelompok";
			}
			
			echo "<tr>
					<td>$i</td>
					<td>$data_publikasi[judul_penelitian]</td>
					<td>$hasil_penelitian</td>
					<td>$media</td>
					<td>$pengarang</td>
					<td>$pelaksanaan</td>
					<td><a title='Ubah' href='?mod=publikasi&act=edit&id=$data_publikasi[publikasi_id]&nid=$data_dosen[NODOSMSDOS]'><img src='../images/edit.jpg' width='20'></a>";
					?>
						<a title='Hapus' href="modul/mod_publikasi/aksi_publikasi.php?mod=publikasi&act=delete&id=<?php echo $data_publikasi[publikasi_id];?>&nid=<?php echo $data_dosen[NODOSMSDOS]; ?>" onclick="return confirm('Anda Yakin ingin menghapus publikasi #<?php echo $data_publikasi[judul_penelitian];?>?');"><img src='../images/delete.jpg' width='20'></a>
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
	echo "<a href='index.php?mod=publikasi&act=form&nid=$_GET[nid]'><img src='../images/back.png'></a>
			<form method='POST' action='modul/mod_publikasi/aksi_publikasi.php?mod=publikasi&act=input' id='frm_publikasi'>
			<h5>Tambah Publikasi Dosen</h5>";
			?>
			<form id="frm_user" action="modul/mod_user/aksi_user.php?mod=user&act=input" method="POST">
			<div class="box round first fullpage">
				<div class="block ">
					<table class="form">
						<tr valign="top">
							<td width="200"><label>NID</label></td>
							<td><?php echo $data_dosen['NODOSMSDOS']; ?> <input type='hidden' name='id_dosen' value='<?php echo $data_dosen['IDDOSMSDOS']; ?>'><input type='hidden' name='no_dosen' value='<?php echo $data_dosen['NODOSMSDOS']; ?>'></b></td>
						</tr>
						<tr valign="top">
							<td><label>Nama Dosen</label></td>
							<td><b><?php echo $data_dosen['NMDOSMSDOS']." ".$data_dosen['GELARMSDOS']; ?></b></td>
						</tr>
						<tr valign="top">
							<td><label>Jenis Penelitian <font color="red">*</font> <i>Jenis penelitian</i></label></td>
							<td><select name="jenis_penelitian" class="required">
									<option value="">- none -</option>
									<option value="A">Hasil Penelitian</option>
									<option value="B">Non-Penelitian</option>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<td><label>Pengarang <font color="red">*</font> <i>Pengarang</i></label></td>
							<td><select name="pengarang" class="required">
									<option value="">- none -</option>
									<option value="A">Penulis Anggota</option>
									<option value="B">Penulis Utama</option>
									<option value="C">Penulis Mandiri</option>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<td><label>Hasil Penelitian <font color="red">*</font> <i>Hasil akhir penelitian</i></label></td>
							<td><select name="hasil_penelitian" class="required">
									<option value="">- none -</option>
									<option value="1">Paper/Makalah</option>
									<option value="2">Buku</option>
									<option value="3">HKI</option>
									<option value="4">HKI Komersialisasi</option>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<td><label>Media Publikasi <font color="red">*</font> <i>Media publikasi</i></label></td>
							<td><select name="media_publikasi" class="required">
									<option value="">- none -</option>
									<option value="A">Majalah Populer/Koran</option>
									<option value="B">Seminar Nasional</option>
									<option value="C">Seminar Internasional</option>
									<option value="D">Prosiding (ISBN)</option>
									<option value="E">Jurnal Nasional Belum Akreditasi</option>
									<option value="F">Jurnal Nasional Terakreditasi</option>
									<option value="G">Jurnal Internasional</option>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<td><label>Penelitian Dilaksanakan Secara <font color="red">*</font></label></td>
							<td><select name="penelitian_dilaksanakan" class="required">
									<option value="">- none -</option>
									<option value="M">Mandiri</option>
									<option value="K">Kelompok</option>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<td><label>Jenis Pembiayaan <font color="red">*</font> <i>Jenis pembiayaan yang digunakan untuk penelitian</i></label></td>
							<td><select name="jenis_pembiayaan" class="required">
									<option value="">- none -</option>
									<option value="A">Biaya Sendiri</option>
									<option value="B">Biaya Instansi Sendiri</option>
									<option value="C">Lembaga Swasta Kerjasama</option>
									<option value="D">Lembaga Swasta Kompetisi</option>
									<option value="E">Lembaga Pemerintah Kerjasama</option>
									<option value="F">Lembaga Pemerintah Kompetisi</option>
									<option value="G">Lembaga Internasional</option>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<td><label>Periode Penelitian <font color="red">*</font> <i>YYYYMM</i></label></td>
							<td><input name="periode_penelitian" type="text" size="40" maxlength="6" class="required"/></td>
						</tr>
						<tr valign="top">
							<td><label>Judul Penelitian <font color="red">*</font> <i>Judul penelitian</i></label></td>
							<td><input type="text" class="required" name="judul" size="40" maxlength="100"></td>
						</tr>
						<tr valign="top">
							<td><label>Kata Kunci <font color="red">*</font> <i>Kata kunci penelitian (5 kata kunci dimana masing-masing dipisahkan dengan koma)</i></label></td>
							<td><input type="text" class="required" name="kata_kunci" size="40" maxlength="100"></td>
						</tr>
						<tr valign="top">
							<td><label>Waktu Pelaksanaan Penelitian <font color="red">*</font> <i>Waktu yang dibutuhkan dalam menyelesaikan penelitian (dalam tahun)</i></label></td>
							<td><input type="text" name="waktu_pelaksanaan" size="40" maxlength="2" class="required"></td>
						</tr>
						<tr valign="top">
							<td><label>Lokasi Penelitian </label></td>
							<td><input type="text" name="lokasi_penelitian" size="40" maxlength="50"></td>
						</tr>
						<tr valign="top">
							<td><label>Status Validasi <font color="red">*</font> <i>Status validasi dari DIKTI</i></label></td>
							<td><select name="status_validasi" class="required">
									<option value="">- none -</option>
									<option value="1">Belum diverifikasi</option>
									<option value="2">Sudah diverifikasi namun masih terdapat data yang invalid</option>
									<option value="3">Sudah diverifikasi dan data sudah valid</option>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<td><label>Abstrak <font color="red">*</font> <i>Abstrak hasil penelitian</i></label></td>
							<td><textarea name="abstrak" class="ckeditor"></textarea></td>
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
	$data_dosen = $db->database_fetch_array($db->database_prepare("SELECT * FROM msdos WHERE NODOSMSDOS = ?")->execute($_GET["nid"]));
	$data_publikasi = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_publikasi_dosen WHERE publikasi_id=?")->execute($_GET["id"]));
	echo "<a href='index.php?mod=publikasi&act=form&nid=$_GET[nid]'><img src='../images/back.png'></a>
			<h5>Ubah Publikasi Dosen</h5>
			
			<form method='POST' action='modul/mod_publikasi/aksi_publikasi.php?mod=publikasi&act=update' id='frm_publikasi'>";
			?>
			<div class="box round first fullpage">
				<div class="block ">
					<table class="form">
						<tr valign="top">
							<td width="200"><label>NID</label></td>
							<td><b><?php echo $data_dosen['NODOSMSDOS']; ?> <input type='hidden' name='id_dosen' value='<?php echo $data_dosen['IDDOSMSDOS']; ?>'><input type='hidden' name='no_dosen' value='<?php echo $data_dosen['NODOSMSDOS']; ?>'><input type='hidden' name='id' value='<?php echo $_GET[id]; ?>'></b></td>
						</tr>
						<tr valign="top">
							<td><label>Nama Dosen</label></td>
							<td><b><?php echo $data_dosen['NMDOSMSDOS']." ".$data_dosen['GELARMSDOS']; ?></b></td>
						</tr>
						<tr valign="top">
							<td><label>Jenis Penelitian <font color="red">*</font> <i>Jenis penelitian</i></label></td>
							<td><select name="jenis_penelitian" class="required">
									<option value="A" <?php if ($data_publikasi['jenis_penelitian'] == 'A'){ echo "SELECTED"; } ?>>Hasil Penelitian</option>
									<option value="B" <?php if ($data_publikasi['jenis_penelitian'] == 'B'){ echo "SELECTED"; } ?>>Non-Penelitian</option>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<td><label>Pengarang <font color="red">*</font> <i>Pengarang</i></label></td>
							<td><select name="pengarang" class="required">
									<option value="A" <?php if ($data_publikasi['kode_pengarang'] == 'A'){ echo "SELECTED"; } ?>>Penulis Anggota</option>
									<option value="B" <?php if ($data_publikasi['kode_pengarang'] == 'B'){ echo "SELECTED"; } ?>>Penulis Utama</option>
									<option value="C" <?php if ($data_publikasi['kode_pengarang'] == 'C'){ echo "SELECTED"; } ?>>Penulis Mandiri</option>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<td><label>Hasil Penelitian <font color="red">*</font> <i>Hasil akhir penelitian</i></label></td>
							<td><select name="hasil_penelitian" class="required">
									<option value="1" <?php if ($data_publikasi['hasil_penelitian'] == '1'){ echo "SELECTED"; } ?>>Paper/Makalah</option>
									<option value="2" <?php if ($data_publikasi['hasil_penelitian'] == '2'){ echo "SELECTED"; } ?>>Buku</option>
									<option value="3" <?php if ($data_publikasi['hasil_penelitian'] == '3'){ echo "SELECTED"; } ?>>HKI</option>
									<option value="4" <?php if ($data_publikasi['hasil_penelitian'] == '4'){ echo "SELECTED"; } ?>>HKI Komersialisasi</option>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<td><label>Media Publikasi <font color="red">*</font> <i>Media publikasi</i></label></td>
							<td><select name="media_publikasi" class="required">
									<option value="A" <?php if ($data_publikasi['media_publikasi'] == 'A'){ echo "SELECTED"; } ?>>Majalah Populer/Koran</option>
									<option value="B" <?php if ($data_publikasi['media_publikasi'] == 'B'){ echo "SELECTED"; } ?>>Seminar Nasional</option>
									<option value="C" <?php if ($data_publikasi['media_publikasi'] == 'C'){ echo "SELECTED"; } ?>>Seminar Internasional</option>
									<option value="D" <?php if ($data_publikasi['media_publikasi'] == 'D'){ echo "SELECTED"; } ?>>Prosiding (ISBN)</option>
									<option value="E" <?php if ($data_publikasi['media_publikasi'] == 'E'){ echo "SELECTED"; } ?>>Jurnal Nasional Belum Akreditasi</option>
									<option value="F" <?php if ($data_publikasi['media_publikasi'] == 'F'){ echo "SELECTED"; } ?>>Jurnal Nasional Terakreditasi</option>
									<option value="G" <?php if ($data_publikasi['media_publikasi'] == 'G'){ echo "SELECTED"; } ?>>Jurnal Internasional</option>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<td><label>Penelitian Dilaksanakan Secara <font color="red">*</font></label></td>
							<td><select name="penelitian_dilaksanakan" class="required">
									<option value="M" <?php if ($data_publikasi['penelitian_dilaksanakan_secara'] == 'M'){ echo "SELECTED"; } ?>>Mandiri</option>
									<option value="K" <?php if ($data_publikasi['penelitian_dilaksanakan_secara'] == 'K'){ echo "SELECTED"; } ?>>Kelompok</option>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<td><label>Jenis Pembiayaan <font color="red">*</font> <i>Jenis pembiayaan yang digunakan untuk penelitian</i></label></td>
							<td><select name="jenis_pembiayaan" class="required">
									<option value="B" <?php if ($data_publikasi['jenis_pembiayaan'] == 'B'){ echo "SELECTED"; } ?>>Biaya Instansi Sendiri</option>
									<option value="A" <?php if ($data_publikasi['jenis_pembiayaan'] == 'A'){ echo "SELECTED"; } ?>>Biaya Sendiri</option>
									<option value="C" <?php if ($data_publikasi['jenis_pembiayaan'] == 'C'){ echo "SELECTED"; } ?>>Lembaga Swasta Kerjasama</option>
									<option value="D" <?php if ($data_publikasi['jenis_pembiayaan'] == 'D'){ echo "SELECTED"; } ?>>Lembaga Swasta Kompetisi</option>
									<option value="E" <?php if ($data_publikasi['jenis_pembiayaan'] == 'E'){ echo "SELECTED"; } ?>>Lembaga Pemerintah Kerjasama</option>
									<option value="F" <?php if ($data_publikasi['jenis_pembiayaan'] == 'F'){ echo "SELECTED"; } ?>>Lembaga Pemerintah Kompetisi</option>
									<option value="G" <?php if ($data_publikasi['jenis_pembiayaan'] == 'G'){ echo "SELECTED"; } ?>>Lembaga Internasional</option>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<td><label>Periode Penelitian <font color="red">*</font> <i>YYYYMM</i></label></td>
							<td><input name="periode_penelitian" type="text" size="40" maxlength="6" class="required" value="<?php echo $data_publikasi['periode_penelitian']; ?>"></td>
						</tr>
						<tr valign="top">
							<td><label>Judul Penelitian <font color="red">*</font> <i>Judul penelitian</i></label></td>
							<td><input type="text" class="required" name="judul" size="40" maxlength="100" value="<?php echo $data_publikasi['judul_penelitian']; ?>"></td>
						</tr>
						<tr valign="top">
							<td><label>Kata Kunci <font color="red">*</font> <i>Kata kunci penelitian (5 kata kunci dimana masing-masing dipisahkan dengan koma)</i></label></td>
							<td><input type="text" class="required" name="kata_kunci" size="40" maxlength="100" value="<?php echo $data_publikasi['kata_kunci']; ?>"></td>
						</tr>
						<tr valign="top">
							<td><label>Waktu Pelaksanaan Penelitian <font color="red">*</font> <i>Waktu yang dibutuhkan dalam menyelesaikan penelitian (dalam tahun)</i></label></td>
							<td><input type="text" name="waktu_pelaksanaan" size="40" maxlength="2" class="required" value="<?php echo $data_publikasi['waktu_pelaksanaan_penelitian']; ?>"></td>
						</tr>
						<tr valign="top">
							<td><label>Lokasi Penelitian </label></td>
							<td><input type="text" name="lokasi_penelitian" size="40" maxlength="50" value="<?php echo $data_publikasi['lokasi_penelitian']; ?>"></td>
						</tr>
						<tr valign="top">
							<td><label>Status Validasi <font color="red">*</font> <i>Status validasi dari DIKTI</i></label></td>
							<td><select name="status_validasi" class="required">
									<option value="1" <?php if ($data_publikasi['status_validasi'] == '1'){ echo "SELECTED"; } ?>>Belum diverifikasi</option>
									<option value="2" <?php if ($data_publikasi['status_validasi'] == '2'){ echo "SELECTED"; } ?>>Sudah diverifikasi namun masih terdapat data yang invalid</option>
									<option value="3" <?php if ($data_publikasi['status_validasi'] == '3'){ echo "SELECTED"; } ?>>Sudah diverifikasi dan data sudah valid</option>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<td><label>Abstrak <font color="red">*</font> <i>Abstrak hasil penelitian</i></label></td>
							<td><textarea name="abstrak" class="ckeditor"><?php echo $data_publikasi['abstrak']; ?></textarea></td>
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