<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Program Studi Baru berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Program Studi berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Program Studi berhasil dihapus.</p>
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
			dateFormat: "yy-mm-dd"
		});
		
		$( "#datepicker2" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
		});
		
		$( "#datepicker3" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
		});
		
		$( "#datepicker4" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
		});
		
		$( "#datepicker5" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
		});
		
		$('#frm_prodi').validate({
			rules:{
				kdpstmspst: true,
				kdptimspst: true,
				kdjenmspst: true,
				fakultas_id: true,
				nmpstmspst: true,
				nomskmspst: true,
				sksttmspst: true,
				smawlmspst: true,
				statumspst: true
			},
			messages:{
				kdpstmspst:{
					required: "Kode Program Studi Wajib Diisi."
				},
				kdptimspst:{
					required: "Kode Perguruan Tinggi Wajib Diisi."
				},
				kdjenmspst:{
					required: "Kode Jenjang Pendidikan Wajib Diisi."
				},
				fakultas_id:{
					required: "Fakultas Wajib Diisi."
				},
				nmpstmspst:{
					required: "Nama Program Studi Wajib Diisi."
				},
				nomskmspst:{
					required: "Nomor SK DIKTI Wajib Diisi."
				},
				sksttmspst:{
					required: "Jumlah SKS Program Studi Wajib Diisi."
				},
				smawlmspst:{
					required: "Semester Awal Program Studi Wajib Diisi."
				},
				statumspst:{
					required: "Status Program Studi Wajib Diisi."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h4>Master Data Program Studi</h4><br>
	<div>
		<a href="?mod=prodi&act=add"><button type="button" class="btn btn-green">+ Tambah Program Studi</button></a>
	</div>
	<br>		
	<table class="data display datatable" id="example">
	<thead>
		<tr>
			<th width='30'>No</th>
			<!--<th width='60'>Kode PS</th>-->
			<th width='80'>ID Prodi</th>
			<th width='110'>Jenjang Studi</th>
			<th width='100'>Fakultas</th>
			<th width='80'>Akreditasi</th>
			<th width='180'>Program Studi</th>
			<!--<th width='200'>Jurusan</th>-->
			<th width='190'>Ketua Program Studi</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$no = 1;
	$sql_prodi = $db->database_prepare("SELECT C.NMDOSMSDOS, C.GELARMSDOS, A.nama_jurusan, A.IDPSTMSPST, A.KDPSTMSPST, A.KDJENMSPST, B.fakultas, A.KDSTAMSPST, A.NMPSTMSPST, A.NOKPSMSPST
									FROM mspst A INNER JOIN msfks B ON A.fakultas_id=B.fakultas_id
									LEFT JOIN msdos C ON C.IDDOSMSDOS=A.NOKPSMSPST")->execute();
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
		
		if($data_prodi['KDSTAMSPST'] == 'A'){
			$kd_status = "Berakreditas A";
		}
		elseif($data_prodi['KDSTAMSPST'] == 'B'){
			$kd_status = "Berakreditas B";
		}
		elseif($data_prodi['KDSTAMSPST'] == 'C'){
			$kd_status = "Berakreditas C";
		}
		elseif($data_prodi['KDSTAMSPST'] == 'D'){
			$kd_status = "Berakreditas D";
		}
		elseif($data_prodi['KDSTAMSPST'] == 'U'){
			$kd_status = "Unggul";
		}
		else{
			$kd_status = "Belajar";
		}
		//<td>$data_prodi[nama_jurusan]</td>
		//<td>$data_prodi[KDPSTMSPST]</td>
		echo "
		<tr>
			<td>$no</td>
			<td align=center>$data_prodi[IDPSTMSPST]</td>
			<td align=center>$kd_jenjang_studi</td>
			<td>$data_prodi[fakultas]</td>
			<td>$kd_status</td>
			<td>$data_prodi[NMPSTMSPST]</td>
			<td>$data_prodi[NMDOSMSDOS] $data_prodi[GELARMSDOS]</td>
			<td><a title='Ubah' href='?mod=prodi&act=edit&id=$data_prodi[IDPSTMSPST]'><img src='../images/edit.jpg' width='20'></a> ";
			?>
				<a title='Hapus' href="modul/mod_prodi/aksi_prodi.php?mod=prodi&act=delete&id=<?php echo $data_prodi[IDPSTMSPST];?>" onclick="return confirm('Anda Yakin ingin menghapus program studi <?php echo $data_prodi[NMPSTMSPST];?>?');"><img src='../images/delete.jpg' width='20'></a>
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
	<a href="index.php?mod=prodi"><img src="../images/back.png"></a>
	<h4>Tambah Program Studi</h4>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_prodi" action="modul/mod_prodi/aksi_prodi.php?mod=prodi&act=input" method="POST">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>Kode Jenjang Pendidikan <font color="red">*)</font></label></td>
					<td>
						<select name="kdjenmspst" class="required">
							<option value="">- none -</option>
							<option value="A">S3</option>
							<option value="B">S2</option>
							<option value="C">S1</option>
							<option value="D">D4</option>
							<option value="E">D3</option>
							<option value="F">D2</option>
							<option value="G">D1</option>
							<option value="H">Sp-1</option>
							<option value="I">Sp-2</option>
							<option value="J">Profesi</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Fakultas <font color="red">*)</font></label></td>
					<td><select name="fakultas_id" class="required">
							<option value="">- none -</option>
							<?php
							$sql_fakultas = $db->database_prepare("SELECT * FROM msfks WHERE aktif = 'A'")->execute();
							while ($data_fakultas = $db->database_fetch_array($sql_fakultas)){
								echo "<option value=$data_fakultas[fakultas_id]>$data_fakultas[fakultas]</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Nama Program Studi <font color="red">*)</font></label></td>
					<td><input type="text" class="required" name="nmpstmspst" size="40" maxlength="40"></td>
				</tr>
				<tr valign="top">
					<td><label>Nama Jurusan</label></td>
					<td><input type="text" name="nama_jurusan" size="40" maxlength="50"></td>
				</tr>
				<tr valign="top">
					<td><label>Nomor SK DIKTI <!--<font color="red">*)</font>--></label></td>
					<td><input type="text" name="nomskmspst" size="40" maxlength="40"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal SK DIKTI <!--<font color="red">*)</font>--></label></td>
					<td><input type="text" name="tgl_sk_dikti" size="40" maxlength="10" id="datepicker1"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Berlakunya SK DIKTI <!--<font color="red">*)</font>--></label></td>
					<td><input type="text" name="tgl_sk_laku" size="40" maxlength="10" id="datepicker2"></td>
				</tr>
				<tr valign="top">
					<td><label>Jumlah SKS Lulus Program Studi <font color="red">*)</font></label></td>
					<td><input type="text" class="required" name="sksttmspst" size="40" maxlength="3"></td>
				</tr>
				<tr valign="top">
					<td><label>Status Program Studi</label></td>
					<td>
						<select name="statumspst" class="required">
							<option value="">- none -</option>
							<option value="A">Aktif</option>
							<option value="H">Hapus</option>
							<option value="N">Non-Aktif</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>E-Mail Program Studi</label></td>
					<td><input type="text" class="input-xlarge" name="emailmspst" maxlength="40"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Awal Pendirian Program Studi <!--<font color="red">*)</font>--></label></td>
					<td><input type="text" name="tgl_awal" size="40" maxlength="10" id="datepicker3"></td>
				</tr>
				<tr valign="top">
					<td><label>Laporan Semester Awal <!--<font color="red">*)</font>--></label></td>
					<td><input type="text" name="smawlmspst" size="40" maxlength="5"></td>
				</tr>
				<tr valign="top">
					<td><label>Mulai Semester (Wajib diisi bila Status Program Studi Hapus/Non-Aktif)</label></td>
					<td><input type="text" name="mlsemmspst" size="40" maxlength="5"></td>
				</tr>
				
				
				<tr valign="top">
					<td><label>Nomor SK Akreditasi BAN-PT</label></td>
					<td><input type="text" class="input-xlarge" name="nombamspst" maxlength="40"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal SK Akreditasi BAN-PT</label></td>
					<td><input type="text" name="tgl_akreditasi" size="40" maxlength="10" id="datepicker4"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Berlaku SK Akreditasi BAN-PT</label></td>
					<td><input type="text" name="tgl_laku" size="40" maxlength="10" id="datepicker5"></td>
				</tr>
				<tr valign="top">
					<td><label>Status Akreditasi</label></td>
					<td>
						<select name="kdstamspst">
							<option value="0">- none -</option>
							<option value="A">Berakreditasi "A"</option>
							<option value="B">Berakreditasi "B"</option>
							<option value="C">Berakreditasi "C"</option>
							<option value="D">Berakreditasi "D"</option>
							<option value="U">Unggul</option>
							<option value="L">Belajar</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Frekuensi Pemuktahiran Kurikulum</label></td>
					<td><select name="kdfremspst">
							<option value="0">- none -</option>
							<option value="A">Setiap 1 Tahun</option>
							<option value="B">Setiap 2 Tahun</option>
							<option value="C">Setiap 3 Tahun</option>
							<option value="D">Setiap 4 Tahun</option>
							<option value="E">Sesuai Ketentuan Pemerintah</option>
							<option value="F">Sesuai Kebutuhan</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Pelaksanaan Pemuktahiran Kurikulum</label></td>
					<td><select name="kdpelmspst">
							<option value="0">- none -</option>
							<option value="A">Oleh P.S. Sendiri</option>
							<option value="B">Bersama Tim Dalam Perguruan Tinggi</option>
							<option value="C">Orientasi Perguruan Tinggi Lain</option>
							<option value="D">Orientasi Kebutuhan Pasar</option>
							<option value="E">Bersama Stakeholder</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Ketua Program Studi</label></td>
					<td><select name="nokpsmspst">
							<option value="">- none -</option>
							<?php
							$sql_dosen = $db->database_prepare("SELECT * FROM msdos WHERE STDOSMSDOS = 'A' ORDER BY NMDOSMSDOS ASC")->execute();
							while ($data_dosen = $db->database_fetch_array($sql_dosen)){
								echo "<option value='$data_dosen[IDDOSMSDOS]'>$data_dosen[NODOSMSDOS] - $data_dosen[NMDOSMSDOS] $data_dosen[GELARMSDOS]</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Nomor HP Ketua Program Studi</label></td>
					<td><input type="text" class="input-xlarge" name="telpsmspst" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>Nomor Telepon Program Studi</label></td>
					<td><input type="text" class="input-xlarge" name="telpomspst" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>Faksimil Program Studi</label></td>
					<td><input type="text" class="input-xlarge" name="faksimspst" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>Nama Operator</label></td>
					<td><input type="text" class="input-xlarge" name="nmoprmspst" maxlength="40"></td>
				</tr>
				<tr valign="top">
					<td><label>Nomor HP Operator</label></td>
					<td><input type="text" class="input-xlarge" name="telprmspst" maxlength="20"></td>
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
	$data_prodi = $db->database_fetch_array($db->database_prepare("SELECT * FROM mspst INNER JOIN msfks ON mspst.fakultas_id=msfks.fakultas_id WHERE IDPSTMSPST = ?")->execute($_GET["id"]));
?>
	<p>&nbsp;</p>
	<a href="javascript:history.go(-1)"><img src="../images/back.png"></a>
	<h4>Ubah Program Studi</h4>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_prodi" action="modul/mod_prodi/aksi_prodi.php?mod=prodi&act=update" method="POST">
			<input type="hidden" name="id" value="<?php echo $data_prodi['IDPSTMSPST']; ?>">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>Kode Jenjang Pendidikan <font color="red">*)</font></label></td>
					<td>
						<select name="kdjenmspst" class="required">
							<option value="A" <?php if($data_prodi['KDJENMSPST'] == 'A'){ echo "SELECTED"; } ?>>S3</option>
							<option value="B" <?php if($data_prodi['KDJENMSPST'] == 'B'){ echo "SELECTED"; } ?>>S2</option>
							<option value="C" <?php if($data_prodi['KDJENMSPST'] == 'C'){ echo "SELECTED"; } ?>>S1</option>
							<option value="D" <?php if($data_prodi['KDJENMSPST'] == 'D'){ echo "SELECTED"; } ?>>D4</option>
							<option value="E" <?php if($data_prodi['KDJENMSPST'] == 'E'){ echo "SELECTED"; } ?>>D3</option>
							<option value="F" <?php if($data_prodi['KDJENMSPST'] == 'F'){ echo "SELECTED"; } ?>>D2</option>
							<option value="G" <?php if($data_prodi['KDJENMSPST'] == 'G'){ echo "SELECTED"; } ?>>D1</option>
							<option value="H" <?php if($data_prodi['KDJENMSPST'] == 'H'){ echo "SELECTED"; } ?>>Sp-1</option>
							<option value="I" <?php if($data_prodi['KDJENMSPST'] == 'I'){ echo "SELECTED"; } ?>>Sp-2</option>
							<option value="J" <?php if($data_prodi['KDJENMSPST'] == 'J'){ echo "SELECTED"; } ?>>Profesi</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Fakultas <font color="red">*)</font></label></td>
					<td><select name="fakultas_id" class="required">
							<?php
							$sql_fakultas = $db->database_prepare("SELECT * FROM msfks WHERE aktif = 'A'")->execute();
							while ($data_fakultas = $db->database_fetch_array($sql_fakultas)){
								if ($data_prodi['fakultas_id'] == $data_fakultas['fakultas_id']){
									echo "<option value=$data_fakultas[fakultas_id] SELECTED>$data_fakultas[fakultas]</option>";
								}
								else{
									echo "<option value=$data_fakultas[fakultas_id]>$data_fakultas[fakultas]</option>";
								}
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Nama Program Studi <font color="red">*)</font></label></td>
					<td><input type="text" class="required" name="nmpstmspst" size="40" maxlength="40" value="<?php echo $data_prodi['NMPSTMSPST']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Nama Jurusan</label></td>
					<td><input type="text" name="nama_jurusan" size="40" maxlength="50" value="<?php echo $data_prodi['nama_jurusan']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Nomor SK DIKTI <!--<font color="red">*)</font>--></label></td>
					<td><input type="text" name="nomskmspst" maxlength="40" size="40" value="<?php echo $data_prodi['NOMSKMSPST']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal SK DIKTI <!--<font color="red">*)</font>--></label></td>
					<td><input type="text" name="tgl_sk_dikti" size="40" maxlength="10" id="datepicker1" value="<?php echo $data_prodi['TGLSKMSPST']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Berlakunya SK DIKTI <!--<font color="red">*)</font>--></label></td>
					<td><input type="text" name="tgl_sk_laku" size="40" maxlength="10" id="datepicker2" value="<?php echo $data_prodi['TGLAKMSPST']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Jumlah SKS Lulus Program Studi <font color="red">*)</font></label></td>
					<td><input type="text" class="required" name="sksttmspst" maxlength="3" size="40" value="<?php echo $data_prodi['SKSTTMSPST']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Status Program Studi</label></td>
					<td>
						<select name="statumspst" class="required">
							<option value="A" <?php if($data_prodi['STATUMSPST'] == 'A'){ echo "SELECTED"; } ?>>Aktif</option>
							<option value="H" <?php if($data_prodi['STATUMSPST'] == 'H'){ echo "SELECTED"; } ?>>Hapus</option>
							<option value="N" <?php if($data_prodi['STATUMSPST'] == 'N'){ echo "SELECTED"; } ?>>Non-Aktif</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>E-Mail Program Studi</label></td>
					<td><input type="text" class="input-xlarge" name="emailmspst" maxlength="40" value="<?php echo $data_prodi['EMAILMSPST']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Awal Pendirian Program Studi <!--<font color="red">*)</font>--></label></td>
					<td><input type="text" name="tgl_awal" size="40" maxlength="10" id="datepicker3" value="<?php echo $data_prodi['TGAWLMSPST']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Laporan Semester Awal <!--<font color="red">*)</font>--></label></td>
					<td><input type="text" name="smawlmspst" size="40" maxlength="5" value="<?php echo $data_prodi['SMAWLMSPST']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Mulai Semester (Wajib diisi bila Status Program Studi Hapus/Non-Aktif)</label></td>
					<td><input type="text" name="mlsemmspst" size="40" maxlength="5" value="<?php echo $data_prodi['MLSEMMSPST']; ?>"></td>
				</tr>
				
				
				<tr valign="top">
					<td><label>Nomor SK Akreditasi BAN-PT</label></td>
					<td><input type="text" class="input-xlarge" name="nombamspst" maxlength="40" value="<?php echo $data_prodi['NOMBAMSPST']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal SK Akreditasi BAN-PT</label></td>
					<td><input type="text" name="tgl_akreditasi" size="40" maxlength="10" id="datepicker4" value="<?php echo $data_prodi['TGLBAMSPST']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Berlaku SK Akreditasi BAN-PT</label></td>
					<td><input type="text" name="tgl_laku" size="40" maxlength="10" id="datepicker5" value="<?php echo $data_prodi['TGLABMSPST']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Status Akreditasi</label></td>
					<td>
						<select name="kdstamspst">
							<option value="0">- none -</option>
							<option value="A" <?php if($data_prodi['KDSTAMSPST'] == 'A'){ echo "SELECTED"; } ?>>Berakreditasi "A"</option>
							<option value="B" <?php if($data_prodi['KDSTAMSPST'] == 'B'){ echo "SELECTED"; } ?>>Berakreditasi "B"</option>
							<option value="C" <?php if($data_prodi['KDSTAMSPST'] == 'C'){ echo "SELECTED"; } ?>>Berakreditasi "C"</option>
							<option value="D" <?php if($data_prodi['KDSTAMSPST'] == 'D'){ echo "SELECTED"; } ?>>Berakreditasi "D"</option>
							<option value="U" <?php if($data_prodi['KDSTAMSPST'] == 'U'){ echo "SELECTED"; } ?>>Unggul</option>
							<option value="L" <?php if($data_prodi['KDSTAMSPST'] == 'L'){ echo "SELECTED"; } ?>>Belajar</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Frekuensi Pemuktahiran Kurikulum</label></td>
					<td><select name="kdfremspst">
							<option value="0">- none -</option>
							<option value="A" <?php if($data_prodi['KDFREMSPST'] == 'A'){ echo "SELECTED"; } ?>>Setiap 1 Tahun</option>
							<option value="B" <?php if($data_prodi['KDFREMSPST'] == 'B'){ echo "SELECTED"; } ?>>Setiap 2 Tahun</option>
							<option value="C" <?php if($data_prodi['KDFREMSPST'] == 'C'){ echo "SELECTED"; } ?>>Setiap 3 Tahun</option>
							<option value="D" <?php if($data_prodi['KDFREMSPST'] == 'D'){ echo "SELECTED"; } ?>>Setiap 4 Tahun</option>
							<option value="E" <?php if($data_prodi['KDFREMSPST'] == 'E'){ echo "SELECTED"; } ?>>Sesuai Ketentuan Pemerintah</option>
							<option value="F" <?php if($data_prodi['KDFREMSPST'] == 'F'){ echo "SELECTED"; } ?>>Sesuai Kebutuhan</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Pelaksanaan Pemuktahiran Kurikulum</label></td>
					<td><select name="kdpelmspst">
							<option value="0">- none -</option>
							<option value="A" <?php if($data_prodi['KDPELMSPST'] == 'A'){ echo "SELECTED"; } ?>>Oleh P.S. Sendiri</option>
							<option value="B" <?php if($data_prodi['KDPELMSPST'] == 'B'){ echo "SELECTED"; } ?>>Bersama Tim Dalam Perguruan Tinggi</option>
							<option value="C" <?php if($data_prodi['KDPELMSPST'] == 'C'){ echo "SELECTED"; } ?>>Orientasi Perguruan Tinggi Lain</option>
							<option value="D" <?php if($data_prodi['KDPELMSPST'] == 'D'){ echo "SELECTED"; } ?>>Orientasi Kebutuhan Pasar</option>
							<option value="E" <?php if($data_prodi['KDPELMSPST'] == 'E'){ echo "SELECTED"; } ?>>Bersama Stakeholder</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Ketua Program Studi</label></td>
					<td><select name="nokpsmspst">
							<option value="">- none -</option>
							<?php
							$sql_dosen = $db->database_prepare("SELECT * FROM msdos WHERE STDOSMSDOS = 'A' ORDER BY NMDOSMSDOS ASC")->execute();
							while ($data_dosen = $db->database_fetch_array($sql_dosen)){
								if ($data_prodi['NOKPSMSPST'] == $data_dosen['IDDOSMSDOS']){
									echo "<option value='$data_dosen[IDDOSMSDOS]' SELECTED>$data_dosen[NODOSMSDOS] - $data_dosen[NMDOSMSDOS] $data_dosen[GELARMSDOS]</option>";
								}
								else{
									echo "<option value='$data_dosen[IDDOSMSDOS]'>$data_dosen[NODOSMSDOS] - $data_dosen[NMDOSMSDOS] $data_dosen[GELARMSDOS]</option>";
								}
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Nomor HP Ketua Program Studi</label></td>
					<td><input type="text" class="input-xlarge" maxlength="20" name="telpsmspst" value="<?php echo $data_prodi['TELPSMSPST']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Nomor Telepon Program Studi</label></td>
					<td><input type="text" class="input-xlarge" maxlength="20" name="telpomspst" value="<?php echo $data_prodi['TELPOMSPST']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Faksimil Program Studi</label></td>
					<td><input type="text" class="input-xlarge" maxlength="20" name="faksimspst" value="<?php echo $data_prodi['FAKSIMSPST']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Nama Operator</label></td>
					<td><input type="text" class="input-xlarge" maxlength="40" name="nmoprmspst" value="<?php echo $data_prodi['NMOPRMSPST']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Nomor HP Operator</label></td>
					<td><input type="text" class="input-xlarge" maxlength="20" name="telprmspst" value="<?php echo $data_prodi['TELPRMSPST']; ?>"></td>
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