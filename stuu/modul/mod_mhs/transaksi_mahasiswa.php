<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Transaksi Mahasiswa berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Transaksi Mahasiswa berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Transaksi Mahasiswa berhasil dihapus.</p>
	</div>
<?php
}

if ($_GET['code'] == 5){
?>
	<div class='message error'>
		<h5>Failed!</h5>
		<p>Transaksi Gagal, mahasiswa sudah pernah melakukan transaksi sebelumnya, silahkan ubah data transaksi mahasiswa melalui daftar transaksi mahasiswa dibawah.</p>
	</div>
<?php
}
?>

<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
		$( "#datepicker1" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: 'c-65:c-0'
		});
		
		$( "#datepicker2" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: '2013:c-0'
		});
		
		$( "#datepicker3" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: '2013:c-0'
		});
		
		$( "#datepicker4" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: '2013:c-0'
		});
		
		$('#frm_mhs').validate({
			rules:{
				nim: true,
				transaksi: true
			},
			messages:{
				nim:{
					required: "NIM Wajib diisi."
				},
				transaksi:{
					required: "Pilih transaksi mahasiswa."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h4>Transaksi Mahasiswa</h4>
	<div>
		<a title="Tambah transaksi mahasiswa" href="?mod=trx_mhs&act=add"><button type="button" class="btn btn-green">+ Tambah Transaksi Mahasiswa</button></a>
	</div><br>
	<table class="data display datatable" id="example">
		<thead>
			<tr>
				<th width="30">No</th>
				<th width="100">NIM</th>
				<th width="250">Nama Mahasiswa</th>
				<th width="50">JK</th>
				<th width="120">Status Trx</th>
				<th width="110">Periode Awal</th>
				<th width="110">Periode Akhir</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 1;
			$sql_mhs = $db->database_prepare("SELECT * FROM as_transaksi_mhs INNER JOIN as_mahasiswa ON as_mahasiswa.id_mhs = as_transaksi_mhs.id_mhs
												WHERE status_mahasiswa != 'A' GROUP BY as_transaksi_mhs.id_mhs DESC")->execute();
			while ($data_mhs = $db->database_fetch_array($sql_mhs)){
				if ($data_mhs['status_transaksi'] == 'A'){
					$status = "Aktif";
				}
				elseif ($data_mhs['status_transaksi'] == 'C'){
					$status = "Cuti";
				}
				elseif ($data_mhs['status_transaksi'] == 'D'){
					$status = "Drop-out";
				}
				elseif ($data_mhs['status_transaksi'] == 'L'){
					$status = "Lulus";
				}
				elseif ($data_mhs['status_transaksi'] == 'K'){
					$status = "Keluar";
				}
				else{
					$status = "Non-aktif";
				}
				
				$periode_awal = tgl_indo($data_mhs['periode_awal']);
				$periode_akhir = tgl_indo($data_mhs['periode_akhir']);
				echo "	<tr>
							<td>$i</td>
							<td>$data_mhs[NIM]</td>
							<td>$data_mhs[nama_mahasiswa]</td>
							<td>$data_mhs[jenis_kelamin]</td>
							<td>$status</td>
							<td>$periode_awal</td>
							<td>$periode_akhir</td>
							<td><a title='Ubah' href='?mod=trx_mhs&act=edit&id=$data_mhs[trx_id]'><img src='../images/edit.jpg' width='20'></a> ";
							?>
							<a title="Batalkan" href="modul/mod_mhs/aksi_transaksi_mahasiswa.php?mod=trx_mhs&act=delete&id=<?php echo $data_mhs[trx_id];?>" onclick="return confirm('Anda Yakin ingin membatalkan transaksi mahasiswa #<?php echo $data_mhs[trx_id];?>?');"><img src='../images/delete.jpg' width='20'></a>
							<?php
							echo "</td>
						</tr>";
				$i++;
			}
			?>
		</tbody>
	</table>
	
			</tr>
		</thead>
	</table>
<?php

	break;
	
	case "add":
?>
	<p><a href="?mod=trx_mhs"><img src="../images/back.png"></a></p>
	<h5>Tambah Transaksi</h5>
	<div class='box round first fullpage'>
		<div class='block '>
			<form id="frm_mhs" action="modul/mod_mhs/aksi_transaksi_mahasiswa.php?mod=trx_mhs&act=input" method="POST">
			<table class='form'>
				<tr valign='top'>
					<td width="200"><label>NIM</label></td>
					<td><input type="text" name="nim" class="required" size="40" style="margin-bottom: 10px;">
						<?php
						if ($_GET['code'] == 4){
						?>
							<div class='message error'>
								<p>NIM tidak ditemukan.</p>
							</div>
						<?php
						}
						?>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Transaksi</label></td>
					<td><select name="transaksi" class="required">
							<option value="">- none -</option>
							<option value="A">Aktif</option>
							<option value="C">Cuti</option>
							<option value="D">Drop-out</option>
							<option value="L">Lulus</option>
							<option value="K">Keluar</option>
							<option value="N">Non-aktif</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Periode Awal</label></td>
					<td><input type="text" name="periode_awal" id="datepicker1" size="40"></td>
				</tr>
				<tr valign="top">
					<td><label>Periode Akhir</label></td>
					<td><input type="text" name="periode_akhir" id="datepicker2" size="40"></td>
				</tr>
				<tr valign="top">
					<td><label>Keterangan</label></td>
					<td><textarea name="keterangan" class="ckeditor"></textarea></td>
				</tr>
			</table>
			
			<h5>Khusus hanya untuk Transaksi "LULUS"</h5>
			<table class='form'>
				<tr valign='top'>
					<td width="200"><label>NILUN <i>Nomor Induk Lulusan Nasional</i></label></td>
					<td><input type="text" name="nilun" size="40" maxlength="40"></td>
				</tr>
				<tr valign='top'>
					<td><label>Semester Lulus <font color="red">*</font> <i>Semester mahasiswa lulus, misalnya Genap atau Ganjil</i></label></td>
					<td><select name="semester_lulus">
							<option value="">- none -</option>
							<option value="A">Genap</option>
							<option value="B">Ganjil</option>
						</select>
					</td>
				</tr>
				<tr valign='top'>
					<td><label>Tahun Lulus <i>Tahun mahasiswa lulus</i></label></td>
					<td><input type="text" name="tahun_lulus" size="40" maxlength="4"></td>
				</tr>
				<tr valign='top'>
					<td><label>Tanggal Lulus Mahasiswa</label></td>
					<td><input type="text" name="tgl_lulus" size="40" maxlength="10" id="datepicker3"></td>
				</tr>
				<tr valign='top'>
					<td><label>Nomor Ijazah</label></td>
					<td><input type="text" name="no_seri_ijazah" size="40" maxlength="40"></td>
				</tr>
				<tr valign='top'>
					<td><label>Nomor SK Yudisium</label></td>
					<td><input type="text" name="no_sk_yudisium" size="40" maxlength="30"></td>
				</tr>
				<tr valign='top'>
					<td><label>Tanggal SK Yudisium</label></td>
					<td><input type="text" name="tgl_yudisium" size="40" maxlength="10" id="datepicker4"></td>
				</tr>
				<tr valign='top'>
					<td><label>Awal Bimbingan</label></td>
					<td><input type="text" name="awal_bimbingan" size="40" maxlength="6"> <br><i>Misalnya 052010 untuk Mei 2010, 062009 untuk Juni 2009</i></td>
				</tr>
				<tr valign='top'>
					<td><label>Akhir Bimbingan</label></td>
					<td><input type="text" name="akhir_bimbingan" size="40" maxlength="6"> <br><i>Misalnya 052010 untuk Mei 2010, 062009 untuk Juni 2009</i></td>
				</tr>
				<tr valign='top'>
					<td><label>Judul Skripsi / Tugas Akhir</label></td>
					<td><textarea name="judul_skripsi" cols="40" rows="3"></textarea></td>
				</tr>
				<tr valign='top'>
					<td><label>Jalur Skripsi / Tugas Akhir</label></td>
					<td><select name="jalur_skripsi">
							<option value="">- none -</option>
							<option value="1">Tugas Akhir/Skripsi</option>
							<option value="2">Student Project</option>
							<option value="3">Tesis</option>
							<option value="4">Disertasi</option>
						</select>
					</td>
				</tr>
				<tr valign='top'>
					<td><label>Penyusunan Skripsi</label></td>
					<td><select name="penyusunan_skripsi">
							<option value="">- none -</option>
							<option value="I">Individu</option>
							<option value="K">Kelompok</option>
						</select>
					</td>
				</tr>
				<tr valign='top'>
					<td><label>Dosen Pembimbing 1</label></td>
					<td><select name="nidn_promotor1">
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
				<tr valign='top'>
					<td><label>Dosen Pembimbing 2</label></td>
					<td><select name="nidn_promotor2">
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
				<tr valign='top'>
					<td><label>Dosen Pembimbing 3</label></td>
					<td><select name="nidn_promotor3">
							<option value="">- none -</option>
							<?php
							$sql_dosen3 = $db->database_prepare("SELECT * FROM msdos WHERE STDOSMSDOS = 'A' ORDER BY NMDOSMSDOS ASC")->execute();
							while ($data_dosen3 = $db->database_fetch_array($sql_dosen3)){
								echo "<option value=$data_dosen3[IDDOSMSDOS]>$data_dosen3[NODOSMSDOS] - $data_dosen3[NMDOSMSDOS] $data_dosen3[GELARMSDOS]</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign='top'>
					<td><label>Dosen Pembimbing 4</label></td>
					<td><select name="nidn_promotor4">
							<option value="">- none -</option>
							<?php
							$sql_dosen4 = $db->database_prepare("SELECT * FROM msdos WHERE STDOSMSDOS = 'A' ORDER BY NMDOSMSDOS ASC")->execute();
							while ($data_dosen4 = $db->database_fetch_array($sql_dosen4)){
								echo "<option value=$data_dosen4[IDDOSMSDOS]>$data_dosen4[NODOSMSDOS] - $data_dosen4[NMDOSMSDOS] $data_dosen4[GELARMSDOS]</option>";
							}
							?>
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
	$data_trx = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_transaksi_mhs INNER JOIN as_mahasiswa ON as_mahasiswa.id_mhs=as_transaksi_mhs.id_mhs WHERE trx_id = ?")->execute($_GET["id"]));
?>	
	<p><a href="?mod=trx_mhs"><img src="../images/back.png"></a></p>
	<h5>Ubah Transaksi</h5>
	<div class='box round first fullpage'>
		<div class='block '>
			<form id="frm_mhs" action="modul/mod_mhs/aksi_transaksi_mahasiswa.php?mod=trx_mhs&act=update" method="POST">
			<table class='form'>
				<tr valign='top'>
					<td width="200"><label>NIM</label></td>
					<td><b><?php echo $data_trx['NIM']; ?> - <?php echo $data_trx['nama_mahasiswa']; ?></b><br><br>
						<input type="hidden" name="id" value="<?php echo $data_trx['trx_id']; ?>">
						<input type="hidden" name="id_mhs" value="<?php echo $data_trx['id_mhs']; ?>">
					</td>
				</tr>
				<tr valign="top">
					<td><label>Transaksi</label></td>
					<td><select name="transaksi" class="required">
							<option value="A" <?php if ($data_trx['status_transaksi'] == 'A'){ echo "SELECTED"; } ?>>Aktif</option>
							<option value="C" <?php if ($data_trx['status_transaksi'] == 'C'){ echo "SELECTED"; } ?>>Cuti</option>
							<option value="D" <?php if ($data_trx['status_transaksi'] == 'D'){ echo "SELECTED"; } ?>>Drop-out</option>
							<option value="L" <?php if ($data_trx['status_transaksi'] == 'L'){ echo "SELECTED"; } ?>>Lulus</option>
							<option value="K" <?php if ($data_trx['status_transaksi'] == 'K'){ echo "SELECTED"; } ?>>Keluar</option>
							<option value="N" <?php if ($data_trx['status_transaksi'] == 'N'){ echo "SELECTED"; } ?>>Non-aktif</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Periode Awal</label></td>
					<td><input type="text" name="periode_awal" id="datepicker1" value="<?php echo $data_trx['periode_awal']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Periode Akhir</label></td>
					<td><input type="text" name="periode_akhir" id="datepicker2" value="<?php echo $data_trx['periode_akhir']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Keterangan</label></td>
					<td><textarea name="keterangan" class="ckeditor"><?php echo $data_trx['keterangan']; ?></textarea></td>
				</tr>
			</table>
			
			<h5>Khusus hanya untuk Transaksi "LULUS"</h5>
			<table class='form'>
				<tr valign='top'>
					<td width="200"><label>NILUN <i>Nomor Induk Lulusan Nasional</i></label></td>
					<td><input type="text" name="nilun" size="40" maxlength="40" value="<?php echo $data_trx['nilun']; ?>"></td>
				</tr>
				<tr valign='top'>
					<td><label>Semester Lulus <font color="red">*</font> <i>Semester mahasiswa lulus, misalnya Genap atau Ganjil</i></label></td>
					<td><select name="semester_lulus">
							<option value="">- none -</option>
							<option value="A" <?php if ($data_trx['semester_lulus'] == 'A'){ echo "SELECTED"; } ?>>Genap</option>
							<option value="B" <?php if ($data_trx['semester_lulus'] == 'B'){ echo "SELECTED"; } ?>>Ganjil</option>
						</select>
					</td>
				</tr>
				<tr valign='top'>
					<td><label>Tahun Lulus <i>Tahun mahasiswa lulus</i></label></td>
					<td><input type="text" name="tahun_lulus" size="40" maxlength="4" value="<?php echo $data_trx['tahun_lulus']; ?>"></td>
				</tr>
				<tr valign='top'>
					<td><label>Tanggal Lulus Mahasiswa</label></td>
					<td><input type="text" name="tgl_lulus" size="40" maxlength="10" id="datepicker3" value="<?php echo $data_trx['tanggal_lulus']; ?>"></td>
				</tr>
				<tr valign='top'>
					<td><label>Nomor Ijazah</label></td>
					<td><input type="text" name="no_seri_ijazah" size="40" maxlength="40" value="<?php echo $data_trx['nomor_seri_ijazah']; ?>"></td>
				</tr>
				<tr valign='top'>
					<td><label>Nomor SK Yudisium</label></td>
					<td><input type="text" name="no_sk_yudisium" size="40" maxlength="30" value="<?php echo $data_trx['nomor_sk_yudisium']; ?>"></td>
				</tr>
				<tr valign='top'>
					<td><label>Tanggal SK Yudisium</label></td>
					<td><input type="text" name="tgl_yudisium" size="40" maxlength="10" id="datepicker4" value="<?php echo $data_trx['tanggal_sk_yudisium']; ?>"></td>
				</tr>
				<tr valign='top'>
					<td><label>Awal Bimbingan</label></td>
					<td><input type="text" name="awal_bimbingan" size="40" maxlength="6" value="<?php echo $data_trx['awal_bimbingan']; ?>"> <br><i>Misalnya 052010 untuk Mei 2010, 062009 untuk Juni 2009</i></td>
				</tr>
				<tr valign='top'>
					<td><label>Akhir Bimbingan</label></td>
					<td><input type="text" name="akhir_bimbingan" size="40" maxlength="6" value="<?php echo $data_trx['akhir_bimbingan']; ?>"> <br><i>Misalnya 052010 untuk Mei 2010, 062009 untuk Juni 2009</i></td>
				</tr>
				<tr valign='top'>
					<td><label>Judul Skripsi / Tugas Akhir</label></td>
					<td><textarea name="judul_skripsi" cols="40" rows="3"><?php echo $data_trx['judul_skripsi']; ?></textarea></td>
				</tr>
				<tr valign='top'>
					<td><label>Jalur Skripsi / Tugas Akhir</label></td>
					<td><select name="jalur_skripsi">
							<option value="">- none -</option>
							<option value="1" <?php if ($data_trx['jalur_skripsi'] == '1'){ echo "SELECTED"; } ?>>Tugas Akhir/Skripsi</option>
							<option value="2" <?php if ($data_trx['jalur_skripsi'] == '2'){ echo "SELECTED"; } ?>>Student Project</option>
							<option value="3" <?php if ($data_trx['jalur_skripsi'] == '3'){ echo "SELECTED"; } ?>>Tesis</option>
							<option value="4" <?php if ($data_trx['jalur_skripsi'] == '4'){ echo "SELECTED"; } ?>>Disertasi</option>
						</select>
					</td>
				</tr>
				<tr valign='top'>
					<td><label>Penyusunan Skripsi</label></td>
					<td><select name="penyusunan_skripsi">
							<option value="">- none -</option>
							<option value="I" <?php if ($data_trx['penyusunan_skripsi'] == 'I'){ echo "SELECTED"; } ?>>Individu</option>
							<option value="K" <?php if ($data_trx['penyusunan_skripsi'] == 'K'){ echo "SELECTED"; } ?>>Kelompok</option>
						</select>
					</td>
				</tr>
				<tr valign='top'>
					<td><label>Dosen Pembimbing 1</label></td>
					<td><select name="nidn_promotor1">
							<option value="">- none -</option>
							<?php
							$sql_dosen1 = $db->database_prepare("SELECT * FROM msdos WHERE STDOSMSDOS = 'A' ORDER BY NMDOSMSDOS ASC")->execute();
							while ($data_dosen1 = $db->database_fetch_array($sql_dosen1)){
								if ($data_trx['NIDN_kopromotor1'] == $data_dosen1['IDDOSMSDOS']){
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
				<tr valign='top'>
					<td><label>Dosen Pembimbing 2</label></td>
					<td><select name="nidn_promotor2">
							<option value="">- none -</option>
							<?php
							$sql_dosen2 = $db->database_prepare("SELECT * FROM msdos WHERE STDOSMSDOS = 'A' ORDER BY NMDOSMSDOS ASC")->execute();
							while ($data_dosen2 = $db->database_fetch_array($sql_dosen2)){
								if ($data_trx['NIDN_kopromotor2'] == $data_dosen2['IDDOSMSDOS']){
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
				<tr valign='top'>
					<td><label>Dosen Pembimbing 3</label></td>
					<td><select name="nidn_promotor3">
							<option value="">- none -</option>
							<?php
							$sql_dosen3 = $db->database_prepare("SELECT * FROM msdos WHERE STDOSMSDOS = 'A' ORDER BY NMDOSMSDOS ASC")->execute();
							while ($data_dosen3 = $db->database_fetch_array($sql_dosen3)){
								if ($data_trx['NIDN_kopromotor3'] == $data_dosen3['IDDOSMSDOS']){
									echo "<option value=$data_dosen3[IDDOSMSDOS] SELECTED>$data_dosen3[NODOSMSDOS] - $data_dosen3[NMDOSMSDOS] $data_dosen3[GELARMSDOS]</option>";
								}
								else{
									echo "<option value=$data_dosen3[IDDOSMSDOS]>$data_dosen3[NODOSMSDOS] - $data_dosen3[NMDOSMSDOS] $data_dosen3[GELARMSDOS]</option>";
								}
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign='top'>
					<td><label>Dosen Pembimbing 4</label></td>
					<td><select name="nidn_promotor4">
							<option value="">- none -</option>
							<?php
							$sql_dosen4 = $db->database_prepare("SELECT * FROM msdos WHERE STDOSMSDOS = 'A' ORDER BY NMDOSMSDOS ASC")->execute();
							while ($data_dosen4 = $db->database_fetch_array($sql_dosen4)){
								if ($data_trx['NIDN_kopromotor4'] == $data_dosen4['IDDOSMSDOS']){
									echo "<option value=$data_dosen4[IDDOSMSDOS] SELECTED>$data_dosen4[NODOSMSDOS] - $data_dosen4[NMDOSMSDOS] $data_dosen4[GELARMSDOS]</option>";
								}
								else{
									echo "<option value=$data_dosen4[IDDOSMSDOS]>$data_dosen4[NODOSMSDOS] - $data_dosen4[NMDOSMSDOS] $data_dosen4[GELARMSDOS]</option>";
								}
							}
							?>
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