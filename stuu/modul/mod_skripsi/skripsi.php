<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data pendaftaran skripsi mahasiswa berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data skripsi mahasiswa berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data skripsi mahasiswa berhasil dihapus.</p>
	</div>
<?php
}
if ($_GET['code'] == 4){
?>
	<div class='message error'>
		<h5>Failed!</h5>
		<p>NIM / Nama mahasiswa tidak ditemukan, mohon cek kembali.</p>
	</div>
<?php
}
if ($_GET['code'] == 5){
?>
	<div class='message error'>
		<h5>Failed!</h5>
		<p>Data skripsi mahasiswa pernah didaftarkan sebelumnya.</p>
	</div>
<?php
}
?>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
<script type='text/javascript' src="../js/jquery.autocomplete.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.autocomplete.css" />
		
<script type='text/javascript'>
	$(document).ready(function() {
		$( "#datepicker1" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: 'c-60:c-0'
		});
		
		$("#nim").autocomplete("modul/mod_skripsi/getnim.php", {
			width: 260,
			matchContains: true,
			selectFirst: false
		});
		
		$('#frm_skripsi').validate({
			rules:{
				tanggal_daftar: true,
				nim: true,
				judul_skripsi: true,
				pembimbing1: true,
				status: true
			},
			messages:{
				tanggal_daftar:{
					required: "Tanggal daftar skripsi Wajib Diisi."
				},
				nim:{
					required: "Nim/Nama Mahasiswa Wajib Diisi."
				},
				judul_skripsi:{
					required: "Judul Skripsi Wajib Diisi."
				},
				pembimbing1:{
					required: "Pilih pembimbing 1 skripsi."
				},
				status:{
					required: "Pilih status skripsi."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<a href="?mod=skripsi&act=add"><button type="button" class="btn btn-green">+ Daftar Skripsi Mahasiswa</button></a>
	<div class='box round first fullpage'>
		<div class='block '>
			<form action="" method="GET">
			<input type="hidden" name="mod" value="skripsi">
			<input type="hidden" name="act" value="biodata">
			<table class='form'>
				<tr valign="top">
					<td width="200"><label>Program Studi</label></td>
					<td><select name="program_studi">
							<option value="">- none -</option>
							<?php
							$sql_fks = $db->database_prepare("SELECT * FROM msfks")->execute();
							while ($data_fks = $db->database_fetch_array($sql_fks)){
								$sql_prodi = $db->database_prepare("SELECT KDJENMSPST,IDPSTMSPST,NMPSTMSPST FROM mspst WHERE fakultas_id = ? AND STATUMSPST = 'A'")->execute($data_fks["fakultas_id"]);
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
									echo "<option value=$data_prodi[IDPSTMSPST]>$kd_jenjang_studi $data_fks[fakultas] - $data_prodi[NMPSTMSPST]</option>";
								}
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Tahun Angkatan</label></td>
					<td><select name="angkatan_id" class="required">
							<option value="">- none -</option>
							<?php
							$sql_angkatan = $db->database_prepare("SELECT * FROM as_angkatan WHERE aktif = 'A' ORDER BY angkatan_id DESC")->execute();
							while($data_angkatan = $db->database_fetch_array($sql_angkatan)){
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
				<tr valign='top'>
					<td></td>
					<td><button type='submit' class='btn btn-primary'>Buka Data</button></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
<?php

	break;
	
	case "biodata":

	$data_prodi = $db->database_fetch_array($db->database_prepare("SELECT KDJENMSPST,NMPSTMSPST FROM mspst WHERE IDPSTMSPST = ?")->execute($_GET["program_studi"]));
	if ($data_prodi['KDJENMSPST'] == 'A'){
		$kd_prodi = "S3";
	}
	elseif ($data_prodi['KDJENMSPST'] == 'B'){
		$kd_prodi = "S2";
	}
	elseif ($data_prodi['KDJENMSPST'] == 'C'){
		$kd_prodi = "S1";
	}
	elseif ($data_prodi['KDJENMSPST'] == 'D'){
		$kd_prodi = "D4";
	}
	elseif ($data_prodi['KDJENMSPST'] == 'E'){
		$kd_prodi = "D3";
	}
	elseif ($data_prodi['KDJENMSPST'] == 'F'){
		$kd_prodi = "D2";
	}
	elseif ($data_prodi['KDJENMSPST'] == 'G'){
		$kd_prodi = "D1";
	}
	elseif ($data_prodi['KDJENMSPST'] == 'H'){
		$kd_prodi = "Sp-1";
	}
	elseif ($data_prodi['KDJENMSPST'] == 'I'){
		$kd_prodi = "Sp-2";
	}
	else{
		$kd_prodi = "Profesi";
	}
?>

<h5>Data Pendataan Pengambilan Skripsi</h5><br>
<p><a href="?mod=skripsi"><img src="../images/back.png"></a></p>

	<table class="data display datatable" id="example">
		<thead>
			<tr>
				<th width="30">No</th>
				<th width="100">NPM/NIM</th>
				<th width="250">Nama Mahasiswa</th>
				<th width="50">JK</th>
				<th width="150">Tanggal Daftar</th>
				<th width="120">Status</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$no = 1;
		$sql_mhs = $db->database_prepare("SELECT B.id_skripsi, B.tanggal_daftar, B.status, A.id_mhs, A.NIM, A.nama_mahasiswa, A.jenis_kelamin, A.Kelas, A.email, A.status_mahasiswa
											FROM as_mahasiswa A LEFT JOIN as_skripsi B ON B.id_mhs = A.id_mhs
											WHERE A.kode_program_studi = ? AND A.angkatan_id = ? 
											ORDER BY A.kode_program_studi, A.NIM ASC")->execute($_GET["program_studi"],$_GET["angkatan_id"]);
		while ($data_mhs = $db->database_fetch_array($sql_mhs)){
			
			$tgl_daftar = tgl_indo($data_mhs['tanggal_daftar']);
			
			if ($data_mhs['status'] == 'A'){
				$status = "ACC";
			}
			elseif($data_mhs['status'] == 'B'){
				$status = "Not-ACC";
			}
			elseif($data_mhs['status'] == 'C'){
				$status = "Perlu Perbaikan";
			}
			else{
				$status = "";
			}
			
			echo "
			<tr>
				<td>$no</td>
				<td>$data_mhs[NIM]</td>
				<td>$data_mhs[nama_mahasiswa]</td>
				<td>$data_mhs[jenis_kelamin]</td>
				<td>$tgl_daftar</td>
				<td>$status</td>
				<td>";
				if ($data_mhs['id_skripsi'] != ''){
					echo "
						<a title='Lihat Detil' href='?mod=skripsi&act=detil&ids=$data_mhs[id_skripsi]&program_studi=$_GET[program_studi]&angkatan_id=$_GET[angkatan_id]'><img src='../images/view.png' width='20'></a>
						<a title = 'Ubah' href='?mod=skripsi&act=edit&ids=$data_mhs[id_skripsi]&program_studi=$_GET[program_studi]&angkatan_id=$_GET[angkatan_id]'><img src='../images/edit.jpg' width='20'></a>";
					?>
						<a title='Hapus' href="modul/mod_skripsi/aksi_skripsi.php?mod=skripsi&act=delete&ids=<?php echo $data_mhs[id_skripsi];?>&program_studi=<?php echo $_GET[program_studi]; ?>&angkatan_id=<?php echo $_GET[angkatan_id]; ?>" onclick="return confirm('Anda Yakin ingin menghapus data skripsi mahasiswa <?php echo $data_mhs[nama_mahasiswa];?>?');"><img src='../images/delete.jpg' width='20'></a>
					<?php
				}
				echo "</td>
			</tr>";
			$no++;
		} 
		?>
		</tbody>
	</table>
	<?php
	break;
	
	case "detil":
	$data_skripsi = $db->database_fetch_array($db->database_prepare("SELECT A.judul_skripsi, A.tanggal_daftar, B.NIM, B.nama_mahasiswa, A.status, A.pembimbing1, A.pembimbing2 FROM as_skripsi A INNER JOIN as_mahasiswa B ON B.id_mhs=A.id_mhs WHERE A.id_skripsi = ?")->execute($_GET["ids"]));
	$pembimbing1 = $db->database_fetch_array($db->database_prepare("SELECT NODOSMSDOS, NMDOSMSDOS, GELARMSDOS FROM msdos WHERE IDDOSMSDOS = ?")->execute($data_skripsi['pembimbing1']));
	$pembimbing2 = $db->database_fetch_array($db->database_prepare("SELECT NODOSMSDOS, NMDOSMSDOS, GELARMSDOS FROM msdos WHERE IDDOSMSDOS = ?")->execute($data_skripsi['pembimbing2']));
	$tgl_daftar = tgl_indo($data_skripsi['tanggal_daftar']);
	if ($data_skripsi['status'] == 'A'){
		$status = "ACC";
	} 
	elseif ($data_skripsi['status'] == 'B'){
		$status = "Non-ACC";
	}
	else{
		$status = "Perlu Perbaikan";
	}
	echo "<a href=javascript:history.go(-1)><img src='../images/back.png'></a>";	
	echo "<h5>Detil Pengambilan Skripsi</h5>";
	echo "<div class='box round first fullpage'>
				<div class='block '>
					<table class='form'>
						<tr valign='top''>
							<td width='200'><label>NIM</label></td>
							<td><b>$data_skripsi[NIM]</b></td>
						</tr>
						<tr valign='top''>
							<td><label>Nama Mahasiswa/i</label></td>
							<td><b>$data_skripsi[nama_mahasiswa] / $data_skripsi[jenis_kelamin]</b></td>
						</tr>
						<tr valign='top''>
							<td><label>Tanggal Daftar Skripsi</label></td>
							<td><b>$tgl_daftar</b></td>
						</tr>
						<tr valign='top''>
							<td><label>Judul Skripsi</label></td>
							<td><b>$data_skripsi[judul_skripsi]</b></td>
						</tr>
						<tr valign='top''>
							<td><label>Pembimbing 1</label></td>
							<td><b>$pembimbing1[NODOSMSDOS] - $pembimbing1[NMDOSMSDOS] $pembimbing1[GELARMSDOS]</b></td>
						</tr>
						<tr valign='top''>
							<td><label>Pembimbing 2</label></td>
							<td><b>$pembimbing2[NODOSMSDOS] - $pembimbing2[NMDOSMSDOS] $pembimbing2[GELARMSDOS]</b></td>
						</tr>
						<tr valign='top''>
							<td><label>Status Pengajuan Skripsi</label></td>
							<td><b>$status</b></td>
						</tr>
					</table>
				</div>
			</div>";
	break;
	
	case "card":
	echo "<p>&nbsp;</p>";
	echo "<a href=javascript:history.go(-1)><img src='../images/back.png'></a>";
	echo "<h4>Preview Kartu Tanda Mahasiswa (KTM)</h4>";
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT A.NIM, A.nama_mahasiswa, A.foto, B.NMPSTMSPST FROM as_mahasiswa A INNER JOIN mspst B ON A.kode_program_studi=B.IDPSTMSPST WHERE A.id_mhs = ?")->execute($_GET["id"]));
	if ($data_mhs['foto'] == '' || $data_mhs['foto'] == NULL){
		echo "Pembuatan KTM gagal, foto belum tersedia untuk mahasiswa ini.";
		exit();
	}	
	else{
		$background = imagecreatefromjpeg('../images/ktm.jpg');
		
		$color1	= imagecolorallocate( $background, 255, 255, 255 );
		
		$font	= '../fungsi/fonts/MyriadPro-Regular.ttf';
		
		imagettftext($background, 25, 0, 340, 530, $color1, $font, $data_mhs['nama_mahasiswa']);
		imagettftext($background, 25, 0, 340, 570, $color1, $font, $data_mhs['NIM']);
		imagettftext($background, 25, 0, 340, 610, $color1, $font, $data_mhs['NMPSTMSPST']);
		
		$foto = imagecreatefromjpeg('foto/mahasiswa/thumb/small_'.$data_mhs['foto']);
		
		$sizejpeg = getimagesize('foto/mahasiswa/thumb/small_'.$data_mhs['foto']);
		$jpegw = $sizejpeg[0];
		$jpegh = $sizejpeg[1];
		$placementX = 60;
		$placementY = 305;
		
		imagecopy($background, $foto, $placementX, $placementY, 0, 0, $jpegw, $jpegh);
		
		$save = imagejpeg($background, "foto/ktm/ktm_".$data_mhs['NIM'].".jpg");
		
		echo "<img src='foto/ktm/ktm_$data_mhs[NIM].jpg'> <br><br>
			<a href='modul/mod_mhs/ktm.php?file=ktm_$data_mhs[NIM].jpg'><b>Download KTM</b></a>
		";
		
		imagedestroy($foto);
		imagedestroy($background);
	}
	break;
	
	case "addprodi":
	?>
	<p>&nbsp;</p>
	<h4>Pilih Program Studi</h4>
	<div class="well">
		<form id="frm_addprodi" action="" method="GET">
			<input type="hidden" name="mod" value="mhs">
			<input type="hidden" name="act" value="add">
			<label>Pilih Program Studi <font color="red">*</font></label>
				<select name="prodi" class="required">
					<option value=""></option>
					<?php
					$sql_prodi = $db->database_prepare("SELECT * FROM mspst WHERE STATUMSPST = 'A' ORDER BY KDJENMSPST, NMPSTMSPST ASC")->execute();
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
						elseif ($data_prodi['KDJENMSPST'] == 'J'){
							$kd_jenjang_studi = "Profesi";
						}
						echo "<option value=$data_prodi[IDPSTMSPST]>$kd_jenjang_studi - $data_prodi[NMPSTMSPST]</option>";
					}
					?>
				</select>		
		<br><br>	
		<div>
			<button type="submit" class="btn btn-primary"><i class="icon-save"></i> Lanjutkan</button>
		</div>
		</form>
	</div>
	<?php
	break;
	
	case "upload":
	echo "<p>&nbsp;</p>
		<a href='javascript:history.go(-1)'><img src='../images/back.png'></a>
		<h4>Upload Data Mahasiswa</h4>
		<form method='POST' action='modul/mod_mhs/aksi_mahasiswa.php?mod=mhs&act=upload' enctype='multipart/form-data' id='upload'>
		<div class='well'>
		Format Upload : <a href='modul/mod_mhs/format_upload.xlsx'>Download</a>
		<p><br>
		<label>Upload File</label>
		<input type='file' name='file' class='required'>
		<div>
			<button type='submit' class='btn btn-primary'><i class='icon-save'></i> Upload</button>
		</div>
		</p>
		</div>
		</div>";
	break;
	
	case "add":
	$date = date('Y-m-d');
?>
	<p><a href="?mod=skripsi"><img src="../images/back.png"></a></p>
	<h5>Daftar Skripsi Mahasiswa</h5>
	<div class='box round first fullpage'>
		<div class='block '>
			<form id="frm_skripsi" action="modul/mod_skripsi/aksi_skripsi.php?mod=skripsi&act=input" method="POST">
			<input type='hidden' name='mod' value='bagi_kelas'>
			<input type='hidden' name='act' value='data_mhs'>
			<table class='form'>
				<tr valign="top">
					<td width="200"><label>Tanggal Daftar</label></td>
					<td><input type="text" name="tanggal_daftar" class="required" id="datepicker1" value="<?php echo $date; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>NIM - Nama Mahasiswa <font color="red">*</font> <i>NIM - Nama Mahasiswa</i></label></td>
					<td><input type="text" class="required" name="nim" size="40" id="nim"><br>
						NIM - Nama Mahasiswa bersifat Autocomplete, klik nim/nama sesuai dengan data yang tampil setelah Anda masukkan keyword, ikuti aturan yang ada.
					</td>
				</tr>
				<tr valign="top">
					<td><label>Judul Skripsi <font color="red">*</font> <i>Judul skripsi</i></label></td>
					<td><textarea name="judul_skripsi" class="required" cols="40" rows="5"></textarea></td>
				</tr>
				<tr valign="top">
					<td><label>Pembimbing 1</label></td>
					<td><select name="pembimbing1" class="required">
							<option value="">- none -</option>
							<?php
							$sql_dosen1 = $db->database_prepare("SELECT * FROM msdos WHERE STDOSMSDOS = 'A' ORDER BY NMDOSMSDOS ASC")->execute();
							while ($data_dosen1 = $db->database_fetch_array($sql_dosen1)){
								echo "<option value=$data_dosen1[IDDOSMSDOS]>$data_dosen1[NODOSMSDOS] - $data_dosen1[NMDOSMSDOS] $data_dosen1[GELARMSDOS]</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Pembimbing 2</label></td>
					<td><select name="pembimbing2">
							<option value="">- none -</option>
							<?php
							$sql_dosen2 = $db->database_prepare("SELECT * FROM msdos WHERE STDOSMSDOS = 'A' ORDER BY NMDOSMSDOS ASC")->execute();
							while ($data_dosen2 = $db->database_fetch_array($sql_dosen2)){
								echo "<option value=$data_dosen2[IDDOSMSDOS]>$data_dosen2[NODOSMSDOS] - $data_dosen2[NMDOSMSDOS] $data_dosen2[GELARMSDOS]</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Status</label></td>
					<td><select name="status" class="required">
							<option value="">- none -</option>
							<option value="A">ACC</option>
							<option value="B">Not-ACC</option>
							<option value="C">Perlu Perbaikan</option>
						</select>
					</td>
				</tr>
				<tr valign='top'>
					<td></td>
					<td><button type='submit' class='btn btn-primary'>Simpan</button></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	<?php
	break;
	
	case "edit":
	$data_skripsi = $db->database_fetch_array($db->database_prepare("SELECT B.NIM, B.nama_mahasiswa, A.id_skripsi, A.tanggal_daftar, A.judul_skripsi, A.pembimbing1, A.pembimbing2, A.status FROM as_skripsi A INNER JOIN as_mahasiswa B ON B.id_mhs = A.id_mhs WHERE A.id_skripsi = ?")->execute($_GET["ids"]));
?>	
	<p><a href="javascript:history.go(-1)"><img src="../images/back.png"></a></p>
	<h5>Ubah Skripsi Mahasiswa</h5>
	<div class='box round first fullpage'>
		<div class='block '>
			<form id="frm_skripsi" action="modul/mod_skripsi/aksi_skripsi.php?mod=skripsi&act=update" method="POST">
			<input type="hidden" name="id" value="<?php echo $data_skripsi['id_skripsi']; ?>">
			<input type="hidden" name="program_studi" value="<?php echo $_GET['program_studi']; ?>">
			<input type="hidden" name="angkatan_id" value="<?php echo $_GET['angkatan_id']; ?>">
			<input type='hidden' name='mod' value='bagi_kelas'>
			<input type='hidden' name='act' value='data_mhs'>
			<table class='form'>
				<tr valign="top">
					<td width="200"><label>Tanggal Daftar</label></td>
					<td><input type="text" name="tanggal_daftar" class="required" id="datepicker1" value="<?php echo $data_skripsi['tanggal_daftar']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>NIM - Nama Mahasiswa <font color="red">*</font> <i>NIM - Nama Mahasiswa</i></label></td>
					<td><b><?php echo $data_skripsi['NIM']; ?> - <?php echo $data_skripsi['nama_mahasiswa']; ?></b></td>
				</tr>
				<tr valign="top">
					<td><label>Judul Skripsi <font color="red">*</font> <i>Judul skripsi</i></label></td>
					<td><textarea name="judul_skripsi" class="required" cols="40" rows="5"><?php echo $data_skripsi['judul_skripsi']; ?></textarea></td>
				</tr>
				<tr valign="top">
					<td><label>Pembimbing 1</label></td>
					<td><select name="pembimbing1" class="required">
							<?php
							$sql_dosen1 = $db->database_prepare("SELECT * FROM msdos WHERE STDOSMSDOS = 'A' ORDER BY NMDOSMSDOS ASC")->execute();
							while ($data_dosen1 = $db->database_fetch_array($sql_dosen1)){
								if ($data_skripsi['pembimbing1'] == $data_dosen1['IDDOSMSDOS']){
									echo "<option value=$data_dosen1[IDDOSMSDOS] SELECTED>$data_dosen1[NODOSMSDOS] - $data_dosen1[NMDOSMSDOS] $data_dosen1[GELARMSDOS]</option>";
								}
								else{
									echo "<option value=$data_dosen1[IDDOSMSDOS]>$data_dosen1[NODOSMSDOS] - $data_dosen1[NMDOSMSDOS] $data_dosen1[GELARMSDOS]</option>";
								}
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Pembimbing 2</label></td>
					<td><select name="pembimbing2">
							<option value="">- none -</option>
							<?php
							$sql_dosen2 = $db->database_prepare("SELECT * FROM msdos WHERE STDOSMSDOS = 'A' ORDER BY NMDOSMSDOS ASC")->execute();
							while ($data_dosen2 = $db->database_fetch_array($sql_dosen2)){
								if ($data_skripsi['pembimbing2'] == $data_dosen2['IDDOSMSDOS']){
									echo "<option value=$data_dosen2[IDDOSMSDOS] SELECTED>$data_dosen2[NODOSMSDOS] - $data_dosen2[NMDOSMSDOS] $data_dosen2[GELARMSDOS]</option>";
								}
								else{
									echo "<option value=$data_dosen2[IDDOSMSDOS]>$data_dosen2[NODOSMSDOS] - $data_dosen2[NMDOSMSDOS] $data_dosen2[GELARMSDOS]</option>";
								}
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Status</label></td>
					<td><select name="status" class="required">
							<option value="A" <?php if ($data_skripsi['status'] == 'A'){ echo "SELECTED"; } ?>>ACC</option>
							<option value="B" <?php if ($data_skripsi['status'] == 'B'){ echo "SELECTED"; } ?>>Not-ACC</option>
							<option value="C" <?php if ($data_skripsi['status'] == 'C'){ echo "SELECTED"; } ?>>Perlu Perbaikan</option>
						</select>
					</td>
				</tr>
				<tr valign='top'>
					<td></td>
					<td><button type='submit' class='btn btn-primary'>Simpan Perubahan</button></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
<?php
break;
}
?>