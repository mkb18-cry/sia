<?php
if ($_GET['act'] == 'add' || $_GET['act'] == 'edit'){
?>
	<script type="text/javascript" src="../js/ajaxupload.3.5.js" ></script>
	<link rel="stylesheet" type="text/css" href="../css/Ajaxfile-upload.css" />
	<script type="text/javascript" >
		$(function(){
			var btnUpload=$('#me');
			var mestatus=$('#mestatus');
			var files=$('#files');
			new AjaxUpload(btnUpload, {
				action: 'modul/mod_dosen/upload_dosen.php',
				name: 'uploadfile',
				onSubmit: function(file, ext){
					 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
	                    // extension is not allowed 
						mestatus.text('Only JPG, PNG or GIF files are allowed');
						return false;
					}
					mestatus.html('<img src="ajax-loader.gif" height="16" width="16">');
				},
				onComplete: function(file, response){
					//On completion clear the status
					mestatus.text('');
					//On completion clear the status
					files.html('');
					//Add uploaded file to list
					if(response==="success"){
						$('<li></li>').appendTo('#files').html('<img src="foto/dosen/st_asfa_'+file+'" alt="" width="120" /><br />').addClass('success');
						$('<li></li>').appendTo('#dosen').html('<input type="hidden" name="filename" value="st_asfa_'+file+'">').addClass('nameupload');
						
					} else{
						$('<li></li>').appendTo('#files').text(file).addClass('error');
					}
				}
			});
			
		});
	</script>
<?php
}
?>

<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Dosen Baru berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Dosen berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Dosen berhasil dihapus.</p>
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
			yearRange: 'c-90:2014'
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
			yearRange: 'c-90:2014'
		});
		
		$('#frm_dosen').validate({
			rules:{
				nodosmsdos: true,
				kdpstmsdos: true,
				kdptimsdos: true,
				kdjenmsdos: true,
				nmdosmsdos: true,
				gelarmsdos: true,
				kdjekmsdos: true,
				tplhrmsdos: true,
				tglhrmsdos: true,
				stdosmsdos: true,
				mulai_masuk_dosen: true
			},
			messages:{
				nodosmsdos:{
					required: "No Dosen/NIDN Wajib Diisi."
				},
				kdpstmsdos:{
					required: "Program Studi Wajib Diisi."
				},
				kdptimsdos:{
					required: "Kode Perguruan Tinggi Wajib Diisi."
				},
				kdjenmsdos:{
					required: "Kode Jenjang Pendidikan Wajib Diisi."
				},
				nmdosmsdos:{
					required: "Nama Dosen Wajib Diisi."
				},
				gelarmsdos:{
					required: "Gelar Akademik Dosen Wajib Diisi."
				},
				kdjekmsdos:{
					required: "Jenis Kelamin Wajib Diisi."
				},
				tplhrmsdos:{
					required: "Tempat Lahir Wajib Diisi."
				},
				tglhrmsdos:{
					required: "Tanggal Lahir Wajib Diisi."
				},
				stdosmsdos:{
					required: "Status Dosen Wajib Diisi."
				},
				mulai_masuk_dosen:{
					required: "Mulai Masuk Dosen Wajib Diisi."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h4>Data Dosen</h4><br>
	<div>
		<a href="?mod=dosen&act=add"><button type="button" class="btn btn-green">+ Tambah Dosen</button></a>
	</div><br>
	<table class="data display datatable" id="example">
	<thead>
		<tr>
			<th width="30">No</th>
			<th width="100">NIP/NID</th>
			<!--<th>NIP PNS</th>
			<th>NIP</th>-->
			<th width="100">No KTP</th>
			<th width="220">Nama Dosen</th>
			<th width="120">Gelar Akademik</th>
			<th width="30">JK</th>
			<th width="220">Email</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$no = 1;
	$sql_dosen = $db->database_prepare("SELECT A.email, A.NODOSMSDOS, A.NOKTPMSDOS, A.NMDOSMSDOS, A.GELARMSDOS, A.KDJEKMSDOS, A.NIPNSMSDOS, A.IDDOSMSDOS
									FROM msdos A ORDER BY A.NODOSMSDOS ASC")->execute();
	while ($data_dosen = $db->database_fetch_array($sql_dosen)){
		//<td>$data_dosen[NIPNSMSDOS]</td>
			//<td>$data_dosen[NIP]</td>
		echo "
		<tr>
			<td>$no</td>
			<td>$data_dosen[NODOSMSDOS]</td>
			<td>$data_dosen[NOKTPMSDOS]</td>
			<td>$data_dosen[NMDOSMSDOS]</td>
			<td>$data_dosen[GELARMSDOS]</td>
			<td>$data_dosen[KDJEKMSDOS]</td>
			<td>$data_dosen[email]</td>
			<td><a title='Ubah' href='?mod=dosen&act=edit&id=$data_dosen[IDDOSMSDOS]'><img src='../images/edit.jpg' width='20'></a>";
			?>
				<a title='Hapus' href="modul/mod_dosen/aksi_dosen.php?mod=dosen&act=delete&id=<?php echo $data_dosen[IDDOSMSDOS];?>" onclick="return confirm('Anda Yakin ingin menghapus dosen <?php echo $data_dosen[NMDOSMSDOS]." ".$data_dosen[GELARMSDOS];?>?');"><img src='../images/delete.jpg' width='20'></a>
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
	$tahun = date("Y");
	$month = date('m');
	$sql_urut = $db->database_prepare("SELECT NODOSMSDOS FROM msdos ORDER BY NODOSMSDOS DESC LIMIT 1")->execute();
	$num_urut = $db->database_num_rows($sql_urut);
	
	$data_urut = $db->database_fetch_array($sql_urut);
	$awal = substr($data_urut['NODOSMSDOS'],0-4);
	$next = $awal + 1;
	$jnim = strlen($next);
	
	if (!$data_urut['NODOSMSDOS']){
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
		$npm = $tahun.$month.$no;
	}
	else{
		$npm = $tahun.$month.$no.$next;
	}
?>
	<p><a href="?mod=dosen"><img src="../images/back.png"></a></p>
	<h5>Tambah Dosen</h5>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_dosen" action="modul/mod_dosen/aksi_dosen.php?mod=dosen&act=input" method="POST" enctype="multipart/form-data">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>Nomor Induk Dosen (NID) / NIP</label></td>
					<td><input type="text" name="nodosmsdos" size="40" maxlength="10" value="<?php echo $npm; ?>" DISABLED>
						<input type="hidden" name="nodosmsdos" size="40" maxlength="10" value="<?php echo $npm; ?>">
					</td>
				</tr>
				<tr valign="top">
					<td><label>Nama Dosen <font color="red">*</font> <i>Nama dosen</i></label></td>
					<td><input type="text" class="required" name="nmdosmsdos" size="40" maxlength="30"></td>
				</tr>
				<tr valign="top">
					<td><label>Gelar Akademik Tertinggi <font color="red">*</font></label></td>
					<td><input type="text" class="required" name="gelarmsdos" size="40" maxlength="10"></td>
				</tr>
				<tr valign="top">
					<td><label>Tempat Lahir <!--<font color="red">*</font>--></label></td>
					<td><input type="text" name="tplhrmsdos" size="40" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Lahir <!--<font color="red">*</font>--></label></td>
					<td><input type="text" name="tgl_lahir" size="40" maxlength="10" id="datepicker1"></td>
				</tr>
				<tr valign="top">
					<td><label>Jenis Kelamin <font color="red">*</font></label></td>
					<td><select name="kdjekmsdos" class="required">
							<option value="">- none -</option>
							<option value="L">Laki-Laki</option>
							<option value="P">Perempuan</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Jabatan Akademik</label></td>
					<td><select name="kdjanmsdos">
							<option value="">- none -</option>
							<option value="A">Tenaga Pengajar</option>
							<option value="B">Asisten Ahli</option>
							<option value="C">Lektor</option>
							<option value="D">Lektor Kepala</option>
							<option value="E">Guru Besar</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Pendidikan Tertinggi</label></td>
					<td><select name="kdpdamsdos">
							<option value="">- none -</option>
							<option value="A">S3</option>
							<option value="B">S2</option>
							<option value="C">S1</option>
							<option value="D">Sp-1</option>
							<option value="E">Sp-2</option>
							<option value="F">D4</option>
							<option value="G">D3</option>
							<option value="H">D2</option>
							<option value="I">D1</option>
							<option value="J">Profesi</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Status Ikatan Kerja Dosen di PTS</label></td>
					<td><select name="kdstamsdos">
							<option value="">- none -</option>
							<option value="A">Dosen Tetap</option>
							<option value="B">Dosen PNS DPK</option>
							<option value="C">Dosen PNS PTN</option>
							<option value="D">Honorer Non PNS PTN</option>
							<option value="E">Kontrak/Tetap Kontrak</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Status Aktivitas Dosen</label></td>
					<td><select name="stdosmsdos" class="required">
							<option value="">- none -</option>
							<option value="A">Aktif Mengajar</option>
							<option value="C">Cuti</option>
							<option value="K">Keluar/Pensiun</option>
							<option value="S">Studi Lanjut</option>
							<option value="T">Tugas di Instansi Lain</option>
							<option value="M">Almarhum</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Mulai Masuk Dosen</label></td>
					<td><input type="text" name="tgl_masuk" size="40" maxlength="10" id="datepicker2"></td>
				</tr>
				<tr valign="top">
					<td><label>Mulai Semester Mengajar</label></td>
					<td><input type="text" name="mlsemmsdos" size="40" maxlength="5"></td>
				</tr>
				<tr valign="top">
					<td><label>NIP PNS (Hanya untuk PNS)</label></td>
					<td><input type="text" name="nipnsmsdos" size="40" maxlength="9"></td>
				</tr>
				<!--<label>NIP Dosen</label>
						<input type="text" name="nip" size="40" maxlength="30">-->
				<tr valign="top">
					<td><label>Akta dan Ijin Mengajar</label></td>
					<td><select name="akta_ijin">
							<option value="">- none -</option>
							<option value="1">Ada</option>
							<option value="2">Tidak Ada</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Foto</label></td>
					<td><div id="me" class="styleall" style="cursor:pointer;">
							<label>
								<button class="btn btn-primary">Browse</button>
							</label>
						</div>
						<span id="mestatus" ></span>
						<div id="dosen">
							<li class="nameupload"></li>
						</div>
						<div id="files">
			              <li class="success">
			              </li>
			            </div>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Nomor KTP</label></td>
					<td><input type="text" name="noktpmsdos" size="40" maxlength="25"></td>
				</tr>
				<tr valign="top">
					<td><label>Alamat</label></td>
					<td><textarea name="alamat" cols="40" rows="3"></textarea></td>
				</tr>
				<tr valign="top">
					<td><label>Kota</label></td>
					<td><input type="text" name="kota" size="40" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>Propinsi</label></td>
					<td><input type="text" name="propinsi" size="40" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>Kode Pos</label></td>
					<td><input type="text" name="kode_pos" size="40" maxlength="5"></td>
				</tr>
				<tr valign="top">
					<td><label>Kewarganegaraan</label></td>
					<td><select name="negara">
							<option value="">- none -</option>
							<option value="A">WNI</option>
							<option value="B">WNA</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Nomor Sertifikasi Dosen</label></td>
					<td><input type="text" name="nomor_sertifikasi" size="40" maxlength="11"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Keluar Sertifikasi Dosen</label></td>
					<td><input type="text" name="tgl_sertifikasi" size="40" maxlength="10" id="datepicker3"></td>
				</tr>
				<tr valign="top">
					<td><label>Nomor Asesor</label></td>
					<td><input type="text" name="nira" maxlength="30"></td>
				</tr>
				<tr valign="top">
					<td><label>Telepon</label></td>
					<td><input type="text" name="telepon" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>Hp</label></td>
					<td><input type="text" name="hp" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>Email</label></td>
					<td><input type="text" name="email" maxlength="40"></td>
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
	
	case "edit":
	$data_dosen = $db->database_fetch_array($db->database_prepare("SELECT * FROM msdos WHERE IDDOSMSDOS = ?")->execute($_GET["id"]));
?>	
	<p><a href="?mod=dosen"><img src="../images/back.png"></a></p>
	<h5>Ubah Data Dosen</h5>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_dosen" action="modul/mod_dosen/aksi_dosen.php?mod=dosen&act=update" method="POST">
			<input type="hidden" name="id" value="<?php echo $data_dosen['IDDOSMSDOS']; ?>">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>Nomor Induk Dosen (NID) / NIP</label></td>
					<td><input type="text" name="nodosmsdos" size="40" class="required" maxlength="10" value="<?php echo $data_dosen['NODOSMSDOS']; ?>" DISABLED></td>
				</tr>
				<tr valign="top">
					<td><label>Nama Dosen <font color="red">*</font> <i>Nama dosen</i></label></td>
					<td><input type="text" class="required" name="nmdosmsdos" size="40" maxlength="30" value="<?php echo $data_dosen['NMDOSMSDOS']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Gelar Akademik Tertinggi <font color="red">*</font></label></td>
					<td><input type="text" class="required" name="gelarmsdos" size="40" maxlength="10" value="<?php echo $data_dosen['GELARMSDOS']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Tempat Lahir <!--<font color="red">*</font>--></label></td>
					<td><input type="text" name="tplhrmsdos" size="40" maxlength="20" value="<?php echo $data_dosen['TPLHRMSDOS']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Lahir <!--<font color="red">*</font>--></label></td>
					<td><input type="text" name="tgl_lahir" size="40" maxlength="10" id="datepicker1" value="<?php echo $data_dosen['TGLHRMSDOS']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Jenis Kelamin <font color="red">*</font></label></td>
					<td><select name="kdjekmsdos" class="required">
							<option value="L" <?php if($data_dosen['KDJEKMSDOS'] == 'L'){ echo "SELECTED"; } ?>>Laki-Laki</option>
							<option value="P" <?php if($data_dosen['KDJEKMSDOS'] == 'P'){ echo "SELECTED"; } ?>>Perempuan</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Jabatan Akademik</label></td>
					<td><select name="kdjanmsdos">
							<option value="">- none -</option>
							<option value="A" <?php if($data_dosen['KDJANMSDOS'] == 'A'){ echo "SELECTED"; } ?>>Tenaga Pengajar</option>
							<option value="B" <?php if($data_dosen['KDJANMSDOS'] == 'B'){ echo "SELECTED"; } ?>>Asisten Ahli</option>
							<option value="C" <?php if($data_dosen['KDJANMSDOS'] == 'C'){ echo "SELECTED"; } ?>>Lektor</option>
							<option value="D" <?php if($data_dosen['KDJANMSDOS'] == 'D'){ echo "SELECTED"; } ?>>Lektor Kepala</option>
							<option value="E" <?php if($data_dosen['KDJANMSDOS'] == 'E'){ echo "SELECTED"; } ?>>Guru Besar</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Pendidikan Tertinggi</label></td>
					<td><select name="kdpdamsdos">
							<option value="">- none -</option>
							<option value="A" <?php if($data_dosen['KDPDAMSDOS'] == 'A'){ echo "SELECTED"; } ?>>S3</option>
							<option value="B" <?php if($data_dosen['KDPDAMSDOS'] == 'B'){ echo "SELECTED"; } ?>>S2</option>
							<option value="C" <?php if($data_dosen['KDPDAMSDOS'] == 'C'){ echo "SELECTED"; } ?>>S1</option>
							<option value="D" <?php if($data_dosen['KDPDAMSDOS'] == 'D'){ echo "SELECTED"; } ?>>Sp-1</option>
							<option value="E" <?php if($data_dosen['KDPDAMSDOS'] == 'E'){ echo "SELECTED"; } ?>>Sp-2</option>
							<option value="F" <?php if($data_dosen['KDPDAMSDOS'] == 'F'){ echo "SELECTED"; } ?>>D4</option>
							<option value="G" <?php if($data_dosen['KDPDAMSDOS'] == 'G'){ echo "SELECTED"; } ?>>D3</option>
							<option value="H" <?php if($data_dosen['KDPDAMSDOS'] == 'H'){ echo "SELECTED"; } ?>>D2</option>
							<option value="I" <?php if($data_dosen['KDPDAMSDOS'] == 'I'){ echo "SELECTED"; } ?>>D1</option>
							<option value="J" <?php if($data_dosen['KDPDAMSDOS'] == 'J'){ echo "SELECTED"; } ?>>Profesi</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Status Ikatan Kerja Dosen di PTS</label></td>
					<td><select name="kdstamsdos">
							<option value="">- none -</option>
							<option value="A" <?php if($data_dosen['KDSTAMSDOS'] == 'A'){ echo "SELECTED"; } ?>>Dosen Tetap</option>
							<option value="B" <?php if($data_dosen['KDSTAMSDOS'] == 'B'){ echo "SELECTED"; } ?>>Dosen PNS DPK</option>
							<option value="C" <?php if($data_dosen['KDSTAMSDOS'] == 'C'){ echo "SELECTED"; } ?>>Dosen PNS PTN</option>
							<option value="D" <?php if($data_dosen['KDSTAMSDOS'] == 'D'){ echo "SELECTED"; } ?>>Honorer Non PNS PTN</option>
							<option value="E" <?php if($data_dosen['KDSTAMSDOS'] == 'E'){ echo "SELECTED"; } ?>>Kontrak/Tetap Kontrak</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Status Aktivitas Dosen</label></td>
					<td><select name="stdosmsdos" class="required">
							<option value="A" <?php if($data_dosen['STDOSMSDOS'] == 'A'){ echo "SELECTED"; } ?>>Aktif Mengajar</option>
							<option value="C" <?php if($data_dosen['STDOSMSDOS'] == 'C'){ echo "SELECTED"; } ?>>Cuti</option>
							<option value="K" <?php if($data_dosen['STDOSMSDOS'] == 'K'){ echo "SELECTED"; } ?>>Keluar/Pensiun</option>
							<option value="S" <?php if($data_dosen['STDOSMSDOS'] == 'S'){ echo "SELECTED"; } ?>>Studi Lanjut</option>
							<option value="T" <?php if($data_dosen['STDOSMSDOS'] == 'T'){ echo "SELECTED"; } ?>>Tugas di Instansi Lain</option>
							<option value="M" <?php if($data_dosen['STDOSMSDOS'] == 'M'){ echo "SELECTED"; } ?>>Almarhum</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Mulai Masuk Dosen</label></td>
					<td><input type="text" name="tgl_masuk" size="40" maxlength="10" id="datepicker2" value="<?php echo $data_dosen['mulai_masuk_dosen']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Mulai Semester Mengajar</label></td>
					<td><input type="text" name="mlsemmsdos" size="40" maxlength="5" value="<?php echo $data_dosen['MLSEMMSDOS']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>NIP PNS (Hanya untuk PNS)</label></td>
					<td><input type="text" name="nipnsmsdos" size="40" maxlength="9" value="<?php echo $data_dosen['NIPNSMSDOS']; ?>"></td>
				</tr>
				<!--<label>NIP Dosen</label>
						<input type="text" name="nip" size="40" maxlength="30" value="<?php echo $data_dosen['NIP']; ?>">-->
				<tr valign="top">
					<td><label>Akta dan Ijin Mengajar</label></td>
					<td><select name="akta_ijin">
							<option value="">- none -</option>
							<option value="1" <?php if($data_dosen['akta_dan_ijin_mengajar'] == 1){ echo "SELECTED"; } ?>>Ada</option>
							<option value="2" <?php if($data_dosen['akta_dan_ijin_mengajar'] == 2){ echo "SELECTED"; } ?>>Tidak Ada</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Foto</label></td>
					<td><div id="me" class="styleall" style="cursor:pointer;">
							<label>
								<button class="btn btn-primary">Browse</button>
							</label>
						</div>
						<span id="mestatus" ></span>
						<div id="dosen">
							<li class="nameupload"></li>
						</div>
						<div id="files">
			              <li class="success">
			              	<?php if ($data_dosen['foto'] != ''){ ?>
			              		<img src="foto/dosen/<?php echo $data_dosen['foto']; ?>" width="120">
			              	<?php } ?>
			              </li>
				            </div>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Nomor KTP</label></td>
					<td><input type="text" name="noktpmsdos" size="40" maxlength="25" value="<?php echo $data_dosen['NOKTPMSDOS']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Alamat</label></td>
					<td><textarea name="alamat" cols="40" rows="3"><?php echo $data_dosen['Alamat']; ?></textarea></td>
				</tr>
				<tr valign="top">
					<td><label>Kota</label></td>
					<td><input type="text" name="kota" size="40" maxlength="20" value="<?php echo $data_dosen['kota']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Propinsi</label></td>
					<td><input type="text" name="propinsi" size="40" maxlength="20" value="<?php echo $data_dosen['propinsi']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Kode Pos</label></td>
					<td><input type="text" name="kode_pos" size="40" maxlength="5" value="<?php echo $data_dosen['kode_pos']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Kewarganegaraan</label></td>
					<td><select name="negara">
							<option value="">- none -</option>
							<option value="A" <?php if($data_dosen['negara'] == 'A'){ echo "SELECTED"; } ?>>WNI</option>
							<option value="B" <?php if($data_dosen['negara'] == 'B'){ echo "SELECTED"; } ?>>WNA</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Nomor Sertifikasi Dosen</label></td>
					<td><input type="text" name="nomor_sertifikasi" size="40" maxlength="11" value="<?php echo $data_dosen['no_sertifikasi_dosen']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Keluar Sertifikasi Dosen</label></td>
					<td><input type="text" name="tgl_sertifikasi" size="40" maxlength="10" id="datepicker3" value="<?php echo $data_dosen['tanggal_keluar_sertifikasi_dosen']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Nomor Asesor</label></td>
					<td><input type="text" name="nira" maxlength="30" value="<?php echo $data_dosen['NIRA']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Telepon</label></td>
					<td><input type="text" name="telepon" maxlength="20" value="<?php echo $data_dosen['Telepon']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Hp</label></td>
					<td><input type="text" name="hp" maxlength="20" value="<?php echo $data_dosen['Hp']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Email</label></td>
					<td><input type="text" name="email" maxlength="40" value="<?php echo $data_dosen['email']; ?>"></td>
				</tr>
				<tr valign="top">
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