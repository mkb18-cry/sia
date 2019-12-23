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
				action: 'modul/mod_mhs/upload_mahasiswa.php',
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
						$('<li></li>').appendTo('#files').html('<img src="foto/mahasiswa/st_asfa_'+file+'" alt="" width="120" /><br />').addClass('success');
						$('<li></li>').appendTo('#mahasiswa').html('<input type="hidden" name="filename" value="st_asfa_'+file+'">').addClass('nameupload');
						
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
		<p>Data Mahasiswa Baru berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Mahasiswa berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Mahasiswa berhasil dihapus.</p>
	</div>
<?php
}

if ($_GET['code'] == 4){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Mahasiswa berhasil di Upload.</p>
	</div>
<?php
}

if ($_GET['code'] == 5){
?>
	<div class='message error'>
		<h5>Success!</h5>
		<p>Data Mahasiswa gagal di Upload.</p>
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
			yearRange: 'c-60:c-0'
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
		
		$('#frm_mahasiswa').validate({
			rules:{
				nama_mahasiswa: true,
				agama: true,
				email: true,
				inisial: true,
				jenis_kelamin: true,
				kelas: true,
				kurikulum_id: true,
				angkatan_id: true,
				tempat_lahir: true,
				semester_masuk: true,
				tahun_masuk: true,
				jenis_kelamin: true,
				status_mahasiswa: true,
				status_awal_mahasiswa: true
			},
			messages:{
				nama_mahasiswa:{
					required: "Nama Mahasiswa Wajib Diisi."
				},
				agama:{
					required: "Agama Wajib Diisi."
				},
				email:{
					required: "Email Wajib Diisi."
				},
				inisial:{
					required: "Inisial Nama Wajib Diisi."
				},
				jenis_kelamin:{
					required: "Jenis Kelamin Wajib Diisi."
				},
				kelas:{
					required: "Program Kuliah Wajib Diisi."
				},
				semester_masuk:{
					required: "Semester Masuk Mahasiswa Wajib Diisi."
				},
				tahun_masuk:{
					required: "Tahun Masuk Mahasiswa Wajib Diisi."
				},
				kurikulum_id:{
					required: "Kurikulum Wajib Diisi."
				},
				angkatan_id:{
					required: "Angkatan Mahasiswa Wajib Diisi."
				},
				tempat_lahir:{
					required: "Tempat Lahir Wajib Diisi."
				},
				jenis_kelamin:{
					required: "Jenis kelamin Wajib Diisi."
				},
				status_mahasiswa:{
					required: "Status mahasiswa."
				},
				status_awal_mahasiswa:{
					required: "Status awal mahasiswa."
				}
			}
		});
		
		$('#frm_addprodi').validate({
			rules:{
				prodi: true
			},
			messages:{
				prodi:{
					required: "Pilih Program Studi terlebih dahulu."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<a href="?mod=mhs&act=addprodi"><button type="button" class="btn btn-green">+ Tambah Mahasiswa</button></a>
	<a href="?mod=mhs&act=upload"><button type="button" class="btn btn-green">+ Tambah Mahasiswa (Upload)</button></a>
	
	<p>&nbsp;</p>
	<h4>Cari Mahasiswa</h4>
	<div class="box round first fullpage">
		<div class="block ">
			<form action="" method="GET">
			<input type="hidden" name="mod" value="mhs">
			<input type="hidden" name="act" value="biodata">
			<table class="form">
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
				<tr>
					<td><label>NIM Mahasiswa</label></td>
					<td><input type="text" name="nim" size="40" maxlength="15"></td>
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
	
	case "biodata":
	if ($_GET["program_studi"] == "" && $_GET["nim"] == ""){
	?>
	<h4>Data Semua Mahasiswa - Semua Program Studi</h4>
	<p><a href="?mod=mhs"><img src="../images/back.png"></a></p>
	
		<table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>No</th>
					<th>Program Studi</th>
					<th>NPM/NIM</th>
					<th>Nama Mahasiswa</th>
					<th>Jenis Kelamin</th>
					<th>Kelas</th>
					<th>Status</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$no = 1;
			$sql_mhs = $db->database_prepare("SELECT B.KDJENMSPST, B.NMPSTMSPST, A.id_mhs, A.NIM, A.nama_mahasiswa, A.jenis_kelamin, A.Kelas, A.email, A.status_mahasiswa
												FROM as_mahasiswa A LEFT JOIN mspst B ON A.kode_program_studi = B.IDPSTMSPST
												ORDER BY A.kode_program_studi, A.NIM ASC")->execute();
			while ($data_mhs = $db->database_fetch_array($sql_mhs)){
				if ($data_mhs['KDJENMSPST'] == 'A'){
					$kd_jenjang_studi = "S3";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'B'){
					$kd_jenjang_studi = "S2";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'C'){
					$kd_jenjang_studi = "S1";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'D'){
					$kd_jenjang_studi = "D4";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'E'){
					$kd_jenjang_studi = "D3";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'F'){
					$kd_jenjang_studi = "D2";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'G'){
					$kd_jenjang_studi = "D1";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'H'){
					$kd_jenjang_studi = "Sp-1";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'I'){
					$kd_jenjang_studi = "Sp-2";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'J'){
					$kd_jenjang_studi = "Profesi";
				}
				
				if ($data_mhs['Kelas'] == 'R'){
					$kelas = "Reguler";
				}
				else{
					$kelas = "Non-Reguler";
				}
				
				if ($data_mhs['status_mahasiswa'] == 'A'){
					$status = "Aktif";
				}
				elseif ($data_mhs['status_mahasiswa'] == 'C'){
					$status = "Cuti";
				}
				elseif ($data_mhs['status_mahasiswa'] == 'D'){
					$status = "Drop-out";
				}
				elseif ($data_mhs['status_mahasiswa'] == 'L'){
					$status = "Lulus";
				}
				elseif ($data_mhs['status_mahasiswa'] == 'K'){
					$status = "Keluar";
				}
				elseif ($data_mhs['status_mahasiswa'] == 'N'){
					$status = "Non-Aktif";
				}
				
				echo "
				<tr>
					<td>$no</td>
					<td>$kd_jenjang_studi - $data_mhs[NMPSTMSPST]</td>
					<td>$data_mhs[NIM]</td>
					<td>$data_mhs[nama_mahasiswa]</td>
					<td>$data_mhs[jenis_kelamin]</td>
					<td>$kelas</td>
					<td>$status</td>
					<td><a title='Cetak Kartu Mahasiswa' href='?mod=mhs&act=card&id=$data_mhs[id_mhs]&program_studi=$_GET[program_studi]&nim=$_GET[nim]'><img src='../images/id_card.png' width='20'></a>
						<a title = 'Ubah Data Mahasiswa' href='?mod=mhs&act=edit&id=$data_mhs[id_mhs]&program_studi=$_GET[program_studi]&nim=$_GET[nim]'><img src='../images/edit.jpg' width='20'></a>";
					?>
						<a title='Hapus Data Mahasiswa' href="modul/mod_mhs/aksi_mahasiswa.php?mod=mhs&act=delete&id=<?php echo $data_mhs[id_mhs];?>&program_studi=<?php echo $_GET[program_studi]; ?>&nim=<?php echo $_GET[nim]; ?>" onclick="return confirm('Anda Yakin ingin menghapus mahasiswa <?php echo $data_mhs[nama_mahasiswa];?>?');"><img src='../images/delete.jpg' width='20'></a>
					<?php
					echo "</td>
				</tr>";
				$no++;
			} 
			?>
			</tbody>
		</table>
	<?php
	}

	elseif ($_GET["program_studi"] != "" && $_GET["nim"] == ""){
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
	<h4>Data Semua Mahasiswa<br>
		<?php echo $kd_prodi." - ".$data_prodi['NMPSTMSPST']; ?></h4><br>
	<p><a href="?mod=mhs"><img src="../images/back.png"></a></p>
	
		<table class="data display datatable" id="example">
			<thead>
				<tr>
					<th width="30">No</th>
					<th width="180">Program Studi</th>
					<th width="100">NPM/NIM</th>
					<th width="250">Nama Mahasiswa</th>
					<th width="40">JK</th>
					<th width="110">Kelas</th>
					<th width="90">Status</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$no = 1;
			$sql_mhs = $db->database_prepare("SELECT B.KDJENMSPST, B.NMPSTMSPST, A.id_mhs, A.NIM, A.nama_mahasiswa, A.jenis_kelamin, A.Kelas, A.email, A.status_mahasiswa
												FROM as_mahasiswa A LEFT JOIN mspst B ON A.kode_program_studi = B.IDPSTMSPST
												WHERE A.kode_program_studi = ?
												ORDER BY A.kode_program_studi, A.NIM ASC")->execute($_GET["program_studi"]);
			while ($data_mhs = $db->database_fetch_array($sql_mhs)){
				if ($data_mhs['KDJENMSPST'] == 'A'){
					$kd_jenjang_studi = "S3";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'B'){
					$kd_jenjang_studi = "S2";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'C'){
					$kd_jenjang_studi = "S1";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'D'){
					$kd_jenjang_studi = "D4";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'E'){
					$kd_jenjang_studi = "D3";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'F'){
					$kd_jenjang_studi = "D2";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'G'){
					$kd_jenjang_studi = "D1";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'H'){
					$kd_jenjang_studi = "Sp-1";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'I'){
					$kd_jenjang_studi = "Sp-2";
				}
				else{
					$kd_jenjang_studi = "Profesi";
				}
				
				if ($data_mhs['Kelas'] == 'R'){
					$kelas = "Reguler";
				}
				else{
					$kelas = "Non-Reguler";
				}
				
				if ($data_mhs['status_mahasiswa'] == 'A'){
					$status = "Aktif";
				}
				elseif ($data_mhs['status_mahasiswa'] == 'C'){
					$status = "Cuti";
				}
				elseif ($data_mhs['status_mahasiswa'] == 'D'){
					$status = "Drop-out";
				}
				elseif ($data_mhs['status_mahasiswa'] == 'L'){
					$status = "Lulus";
				}
				elseif ($data_mhs['status_mahasiswa'] == 'K'){
					$status = "Keluar";
				}
				else{
					$status = "Non-Aktif";
				}
				
				echo "
				<tr>
					<td>$no</td>
					<td>$kd_jenjang_studi - $data_mhs[NMPSTMSPST]</td>
					<td>$data_mhs[NIM]</td>
					<td>$data_mhs[nama_mahasiswa]</td>
					<td>$data_mhs[jenis_kelamin]</td>
					<td>$kelas</td>
					<td>$status</td>
					<td><a title='Cetak KTM' href='?mod=mhs&act=card&id=$data_mhs[id_mhs]&program_studi=$_GET[program_studi]&nim=$_GET[nim]'><img src='../images/id_card.png' width='20'></a>
						<a title = 'Ubah' href='?mod=mhs&act=edit&id=$data_mhs[id_mhs]&program_studi=$_GET[program_studi]&nim=$_GET[nim]'><img src='../images/edit.jpg' width='20'></a>";
					?>
						<a title='Hapus' href="modul/mod_mhs/aksi_mahasiswa.php?mod=mhs&act=delete&id=<?php echo $data_mhs[id_mhs];?>&program_studi=<?php echo $_GET[program_studi]; ?>&nim=<?php echo $_GET[nim]; ?>" onclick="return confirm('Anda Yakin ingin menghapus mahasiswa <?php echo $data_mhs[nama_mahasiswa];?>?');"><img src='../images/delete.jpg' width='20'></a>
					<?php
					echo "</td>
				</tr>";
				$no++;
			} 
			?>
			</tbody>
		</table>
	<?php
	}

	else{
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
	
	<h4>Data Mahasiswa</h4><br>
	<p><a href="?mod=mhs"><img src="../images/back.png"></a></p>
	
		<table class="data display datatable" id="example">
			<thead>
				<tr>
					<th width="30">No</th>
					<th width="180">Program Studi</th>
					<th width="100">NPM/NIM</th>
					<th width="250">Nama Mahasiswa</th>
					<th width="40">JK</th>
					<th width="110">Kelas</th>
					<th width="90">Status</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$no = 1;
			$sql_mhs = $db->database_prepare("SELECT B.KDJENMSPST, B.NMPSTMSPST, A.id_mhs, A.NIM, A.nama_mahasiswa, A.jenis_kelamin, A.Kelas, A.email, A.status_mahasiswa
												FROM as_mahasiswa A LEFT JOIN mspst B ON A.kode_program_studi = B.IDPSTMSPST
												WHERE A.kode_program_studi = ? AND A.nim = ? 
												ORDER BY A.kode_program_studi, A.NIM ASC")->execute($_GET["program_studi"],$_GET["nim"]);
			while ($data_mhs = $db->database_fetch_array($sql_mhs)){
				if ($data_mhs['KDJENMSPST'] == 'A'){
					$kd_jenjang_studi = "S3";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'B'){
					$kd_jenjang_studi = "S2";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'C'){
					$kd_jenjang_studi = "S1";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'D'){
					$kd_jenjang_studi = "D4";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'E'){
					$kd_jenjang_studi = "D3";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'F'){
					$kd_jenjang_studi = "D2";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'G'){
					$kd_jenjang_studi = "D1";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'H'){
					$kd_jenjang_studi = "Sp-1";
				}
				elseif ($data_mhs['KDJENMSPST'] == 'I'){
					$kd_jenjang_studi = "Sp-2";
				}
				else{
					$kd_jenjang_studi = "Profesi";
				}
				
				if ($data_mhs['Kelas'] == 'R'){
					$kelas = "Reguler";
				}
				else{
					$kelas = "Non-Reguler";
				}
				
				if ($data_mhs['status_mahasiswa'] == 'A'){
					$status = "Aktif";
				}
				elseif ($data_mhs['status_mahasiswa'] == 'C'){
					$status = "Cuti";
				}
				elseif ($data_mhs['status_mahasiswa'] == 'D'){
					$status = "Drop-out";
				}
				elseif ($data_mhs['status_mahasiswa'] == 'L'){
					$status = "Lulus";
				}
				elseif ($data_mhs['status_mahasiswa'] == 'K'){
					$status = "Keluar";
				}
				else{
					$status = "Non-Aktif";
				}
				
				echo "
				<tr>
					<td>$no</td>
					<td>$kd_jenjang_studi - $data_mhs[NMPSTMSPST]</td>
					<td>$data_mhs[NIM]</td>
					<td>$data_mhs[nama_mahasiswa]</td>
					<td>$data_mhs[jenis_kelamin]</td>
					<td>$kelas</td>
					<td>$status</td>
					<td><a title='Cetak KTM' href='?mod=mhs&act=card&id=$data_mhs[id_mhs]&program_studi=$_GET[program_studi]&nim=$_GET[nim]'><img src='../images/id_card.png' width='20'></a>
						<a title = 'Ubah' href='?mod=mhs&act=edit&id=$data_mhs[id_mhs]&program_studi=$_GET[program_studi]&nim=$_GET[nim]'><img src='../images/edit.jpg' width='20'></a>";
					?>
						<a title='Hapus' href="modul/mod_mhs/aksi_mahasiswa.php?mod=mhs&act=delete&id=<?php echo $data_mhs[id_mhs];?>&program_studi=<?php echo $_GET[program_studi]; ?>&nim=<?php echo $_GET[nim]; ?>" onclick="return confirm('Anda Yakin ingin menghapus mahasiswa <?php echo $data_mhs[nama_mahasiswa];?>?');"><img src='../images/delete.jpg' width='20'></a>
					<?php
					echo "</td>
				</tr>";
				$no++;
			} 
			?>
			</tbody>
		</table>
	<?php
	}
	break;
	
	case "card":
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
		
		echo "<img src='foto/ktm/ktm_$data_mhs[NIM].jpg' width='800'> <br><br>
			<a href='modul/mod_mhs/ktm.php?file=ktm_$data_mhs[NIM].jpg'><button type='button' class='btn btn-green'>Download KTM</button></a>
		";
		
		imagedestroy($foto);
		imagedestroy($background);
	}
	break;
	
	case "addprodi":
	?>
	<div>
		<a href="?mod=mhs"><img src='../images/back.png'></a>
	</div>
	<br>
	<h4>Tambah Mahasiswa</h4>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_addprodi" action="" method="GET">
			<input type="hidden" name="mod" value="mhs">
			<input type="hidden" name="act" value="add">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>Pilih Program Studi <font color="red">*</font></label></td>
					<td><select name="prodi" class="required">
							<option value="">- none -</option>
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
								else{
									$kd_jenjang_studi = "Profesi";
								}
								echo "<option value=$data_prodi[IDPSTMSPST]>$kd_jenjang_studi - $data_prodi[NMPSTMSPST]</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td></td>
					<td><button type="submit" class="btn btn-primary">Lanjutkan</button></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	<?php
	break;
	
	case "upload":
	echo "<a href='javascript:history.go(-1)'><img src='../images/back.png'></a>
		<h4>Upload Data Mahasiswa</h4>
		<div class='box round first fullpage'>
		<div class='block '>
			<form method='POST' action='modul/mod_mhs/aksi_mahasiswa.php?mod=mhs&act=upload' enctype='multipart/form-data' id='upload'>
			<table class='form'>
				<tr valign='top'>
					<td width='200'><label>Format Upload</label></td>
					<td><a href='modul/mod_mhs/format_upload.xlsx'><button type='button' class='btn btn-green'>Download</button></a></td>
				</tr>
				<tr valign='top'>
					<td><label>Upload File</label></td>
					<td><input type='file' name='file' class='required'></td>
				</tr>
				<tr valign='top'>
					<td></td>
					<td><button type='submit' class='btn btn-primary'>Upload</button></td>
				</tr>
			</table>
			</form>
		</div>
		</div>";
	break;
	
	case "add":
	$tahun = date("Y");
	$sql_urut = $db->database_prepare("SELECT NIM FROM as_mahasiswa WHERE kode_program_studi = ? ORDER BY NIM DESC LIMIT 1")->execute($_GET["prodi"]);
	$num_urut = $db->database_num_rows($sql_urut);
	
	
	$jprodi = strlen($_GET["prodi"]);
	if ($jprodi == 1){
		$jprodi = "0".$_GET["prodi"];
	}
	else{
		$jprodi = $_GET["prodi"];
	}
	
	$data_urut = $db->database_fetch_array($sql_urut);
	$awal = substr($data_urut['NIM'],0-4);
	$next = $awal + 1;
	$jnim = strlen($next);
	
	if (!$data_urut['NIM']){
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
		$npm = $tahun.$jprodi.$no;
	}
	else{
		$npm = $tahun.$jprodi.$no.$next;
	}
?>
	<p><a href="?mod=mhs"><img src="../images/back.png"></a></p>
	<h4>Tambah Mahasiswa</h4>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_mahasiswa" action="modul/mod_mhs/aksi_mahasiswa.php?mod=mhs&act=input" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="kode_program_studi" value="<?php echo $_GET['prodi']; ?>">
			<h5>Biodata</h5>
			<table class="form">
				<tr valign="top">
					<td width="200"><label>Nama <font color="red">*</font> <i>Nama mahasiswa</i></label></td>
					<td><input type="text" class="required" name="nama_mahasiswa" size="40" maxlength="30"></td>
				</tr>
				<tr valign="top">
					<td><label>Inisial <font color="red">*</font> <i>Inisial dari mahasiswa, misalnya AS untuk Agus Saputra</i></label></td>
					<td><input type="text" class="required" name="inisial" size="40" maxlength="30"></td>
				</tr>
				<tr valign="top">
					<td><label>Tempat Lahir <!--<font color="red">*</font>--> <i>Tempat lahir</i></label></td>
					<td><input type="text" name="tempat_lahir" size="40" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>Nomor Telepon <i>No. Telp. Rumah</i></label></td>
					<td><input type="text" name="telepon" size="40" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>Nomor Handphone <i>No. Handphone</i></label></td>
					<td><input type="text" name="hp" size="40" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>Nomor KTP</label></td>
					<td><input type="text" name="ktp" size="40" maxlength="25"></td>
				</tr>
				<tr valign="top">
					<td><label>Email <!--<font color="red">*</font>--> <i>Email mahasiswa</i></label></td>
					<td><input type="text" name="email" size="40" maxlength="40"></td>
				</tr>
				<tr valign="top">
					<td><label>Foto <i>Foto mahasiswa</i></label></td>
					<td><div id="me" class="styleall" style="cursor:pointer;">
							<label>
								<button class="btn btn-primary">Browse</button>
							</label>
						</div>
						<span id="mestatus" ></span>
						<div id="mahasiswa">
							<li class="nameupload"></li>
						</div>
						<div id="files">
			              <li class="success">
			              </li>
			            </div>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Lahir <!--<font color="red">*</font>--> <i>Tanggal lahir mahasiswa</i></label></td>
					<td><input type="text" name="tgl_lahir" size="40" maxlength="10" id="datepicker1"></td>
				</tr>
				<tr valign="top">
					<td><label>Agama <!--<font color="red">*</font>--> <i>Agama mahasiswa</i></i></label></td>
					<td><select name="agama">
							<option value="">- none -</option>
							<option value="I">Islam</option>
							<option value="K">Kristen</option>
							<option value="C">Katolik</option>
							<option value="H">Hindu</option>
							<option value="B">Budha</option>
							<option value="G">Kong Hu Cu</option>
							<option value="L">Lainnya</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Jenis Kelamin <font color="red">*</font> <i>Jenis kelamin mahasiswa</i></label></td>
					<td><select name="jenis_kelamin" class="required">
							<option value="">- none -</option>
							<option value="L">Laki-Laki</option>
							<option value="P">Perempuan</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Golongan Darah <i>Golongan darah mahasiswa</i></label></td>
					<td><select name="darah">
							<option value="">- none -</option>
							<option value="A">A</option>
							<option value="B">B</option>
							<option value="C">AB</option>
							<option value="O">O</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Kewarganegaraan <i>Kewarganegaraan mahasiswa</i></label></td>
					<td><select name="negara">
							<option value="">- none -</option>
							<option value="A">WNI</option>
							<option value="B">WNA</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Status Perkawinan <i>Status perkawinan</i></label></td>
					<td><select name="kawin">
							<option value="">- none -</option>
							<option value="A">Kawin</option>
							<option value="B">Belum Kawin</option>
							<option value="C">Janda/Duda</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Gelar Depan <i>Gelar depan pendidikan</i></label></td>
					<td><input type="text" name="gelar_depan" size="40" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>Gelar Belakang <i>Gelar belakang pendidikan</i></label></td>
					<td><input type="text" name="gelar_belakang" size="40" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td width="200"><label>Alamat <i>Alamat lengkap mahasiswa</i></label></td>
					<td><textarea name="alamat" cols="40" rows="3"></textarea></td>
				</tr>
				<tr valign="top">
					<td><label>Hobi <i>Hobi mahasiswa</i></label></td>
					<td><textarea name="hobi" cols="40" rows="3"></textarea></td>
				</tr>
			</table>
			
			<table class="form">
				<tr valign="top">
					<td width="200"><label>NIM <i>Nomor Induk Mahasiswa</i></label></td>
					<td><input type="text" name="nim" size="40" maxlength="15" value="<?php echo $npm; ?>" disabled>
						<input type="hidden" name="nim" size="40" maxlength="15" value="<?php echo $npm; ?>">
					</td>
				</tr>
				<tr valign="top">
					<td><label>Program Kuliah <font color="red">*</font> <i>Program Kuliah Mahasiswa</i></label></td>
					<td><select name="kelas" class="required">
							<option value="">- none -</option>
							<option value="R">Reguler</option>
							<option value="N">Non-Reguler</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Status Mahasiswa <font color="red">*</font> <i>Status Mahasiswa</i></label></td>
					<td><input type="hidden" name="status_mahasiswa" value="A">
						<select name="status_mahasiswa" DISABLED>
							<option value=""></option>
							<option value="A" SELECTED>Aktif</option>
							<option value="C">Cuti</option>
							<option value="D">Drop-out</option>
							<option value="L">Lulus</option>
							<option value="K">Keluar</option>
							<option value="N">Non-Aktif</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Status Awal Mahasiswa <font color="red">*</font> <i>Status Awal Mahasiswa</i></label></td>
					<td><select name="status_awal_mahasiswa" class="required">
							<option value="">- none -</option>
							<option value="B">Baru</option>
							<option value="P">Pindahan</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Angkatan <font color="red">*</font> <i>Angkatan Mahasiswa</i></label></td>
					<td><select name="angkatan_id" class="required">
							<option value="">- none -</option>
							<?php 
							$sql_angkatan = $db->database_prepare("SELECT * FROM as_angkatan WHERE aktif = 'A' ORDER BY angkatan_id DESC")->execute();
							while ($data_angkatan = $db->database_fetch_array($sql_angkatan)){
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
				<tr valign="top">
					<td><label>Semester Masuk <font color="red">*</font> <i>Semester pertama mahasiswa masuk, misalnya Genap atau Ganjil</i></label></td>
					<td><select name="semester_masuk" class="required">
							<option value="">- none -</option>
							<option value="A">Genap</option>
							<option value="B">Ganjil</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Tahun Masuk <font color="red">*</font> <i>Tahun Masuk Mahasiswa, merupakan tahun semester 1 mahasiswa</i></label></td>
					<td><input type="text" name="tahun_masuk" size="40" maxlength="4" class="required"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Masuk Mahasiswa</label></td>
					<td><input type="text" name="tgl_masuk_mhs" size="40" maxlength="10" id="datepicker2"></td>
				</tr>
				<tr valign="top">
					<td></td>
					<td><button type="submit" class="btn btn-primary"><i class="icon-save"></i> Simpan</button></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	<!--<br>
		
	<label>Batas Studi</label>
		<input type="text" name="batas_studi" size="40" maxlength="5">	
		
	<h5>Bila Mahasiswa Berstatus Pindahan</h5>
	<div class="well">
		<table width="100%">
			<tr valign="top">
				<td width="50%">
					<label>NIM Asal</label>
						<input type="text" name="nim_asal" size="40" maxlength="15">
					<label>Propinsi Asal Pendidikan</label>
						<input type="text" name="propinsi_asal_pindahan" size="40" maxlength="20">
					<label>Jumlah SKS Diakui</label>
						<input type="text" name="sks" size="40" maxlength="3">
				</td>
				<td>
					<label>Kode Perguruan Tinggi Asal</label>
						<input type="text" name="kode_pt_asal" size="40" maxlength="6">
					<label>Kode Program Studi Asal</label>
						<input type="text" name="kode_ps_asal" size="40" maxlength="5">
					<label>Jenjang Pendidikan Sebelumnya</label>
						<select name="kode_jenjang_pendidikan_sebelumnya">
							<option value=""></option>
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
		</table>
	</div>
	
	
	<br>
	<h5>Khusus Mahasiswa S3</h5>
	<div class="well">
		<table width="100%">
			<tr valign="top">
				<td width="50%">
					<label>Biaya Studi</label>
						<select name="biaya_studi">
							<option value=""></option>
							<option value="A">Biaya APBN</option>
							<option value="B">Biaya APBD</option>
							<option value="C">Biaya PTN/BHMN</option>
							<option value="D">Biaya PTS</option>
							<option value="E">Institusi Luar Negeri</option>
							<option value="F">Institusi Dalam Negeri</option>
							<option value="G">Biaya Tempat Bekerja</option>
							<option value="H">Biaya Sendiri</option>
						</select>	
					<label>Pekerjaan</label>
						<select name="pekerjaan">
							<option value=""></option>
							<option value="A">Dosen PNS-PTN/BHMN</option>
							<option value="B">Dosen Kotrak PTN/BHMN</option>
							<option value="C">Dosen DPK PTS</option>
							<option value="D">Dosen PTS</option>
							<option value="E">PNS Lembaga Pemerintah</option>
							<option value="F">TNI/Polri</option>
							<option value="G">Pegawai Swasta</option>
							<option value="H">LSM</option>
							<option value="I">Wiraswasta</option>
							<option value="J">Belum Bekerja</option>
						</select>			
					<label>Nama Tempat Bekerja</label>
						<input type="text" name="tempat_bekerja" size="40" maxlength="40">
					<label>Kode Perguruan Tinggi (Bila Pekerjaan Mahasiswa S3 Sebagai Dosen)</label>
						<input type="text" name="kode_kerja_pt" size="40" maxlength="6">
					<label>Kode Program Studi (Bila Pekerjaan Mahasiswa S3 Sebagai Dosen)</label>
						<input type="text" name="kode_kerja_ps" size="40" maxlength="5">
				</td>
			</tr>
		</table>
	</div>
	-->
	<?php
	break;
	
	case "edit":
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_mahasiswa WHERE id_mhs = ?")->execute($_GET["id"]));
?>
	<p><a href="javascript:history.go(-1)"><img src="../images/back.png"></a></p>
	<h4>Ubah Data Mahasiswa</h4>	
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_mahasiswa" action="modul/mod_mhs/aksi_mahasiswa.php?mod=mhs&act=update" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="program_studi" value="<?php echo $_GET['program_studi']; ?>">
			<input type="hidden" name="nim" value="<?php echo $_GET['nim']; ?>">
			<input type="hidden" name="id" value="<?php echo $data_mhs['id_mhs']; ?>">
			<h5>Biodata</h5>
			<table class="form">
				<tr valign="top">
					<td width="200"><label>Nama <font color="red">*</font> <i>Nama mahasiswa</i></label></td>
					<td><input type="text" class="required" name="nama_mahasiswa" size="40" maxlength="30" value="<?php echo $data_mhs['nama_mahasiswa']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Inisial <font color="red">*</font> <i>Inisial dari mahasiswa, misalnya AS untuk Agus Saputra</i></label></td>
					<td><input type="text" class="required" name="inisial" size="40" maxlength="30" value="<?php echo $data_mhs['inisial']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Tempat Lahir <!--<font color="red">*</font>--> <i>Tempat lahir</i></label></td>
					<td><input type="text" name="tempat_lahir" size="40" maxlength="20" value="<?php echo $data_mhs['tempat_lahir']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Nomor Telepon <i>No. Telp. Rumah</i></label></td>
					<td><input type="text" name="telepon" size="40" maxlength="20" value="<?php echo $data_mhs['telepon']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Nomor Handphone <i>No. Handphone</i></label></td>
					<td><input type="text" name="hp" size="40" maxlength="20" value="<?php echo $data_mhs['hp']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Nomor KTP</label></td>
					<td><input type="text" name="ktp" size="40" maxlength="25" value="<?php echo $data_mhs['ktp']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Email <!--<font color="red">*</font>--> <i>Email mahasiswa</i></label></td>
					<td><input type="text" name="email" size="40" maxlength="40" value="<?php echo $data_mhs['email']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Foto <i>Foto mahasiswa</i></label></td>
					<td><div id="me" class="styleall" style="cursor:pointer;">
							<label>
								<button class="btn btn-primary">Browse</button>
							</label>
						</div>
						<span id="mestatus" ></span>
						<div id="mahasiswa">
							<li class="nameupload"></li>
						</div>
						<div id="files">
			              <li class="success">
			              	<?php if ($data_mhs['foto'] != ''){ ?>
				              	<img src="foto/mahasiswa/<?php echo $data_mhs['foto']; ?>" width="120">
				              <?php } ?>
			              </li>
			            </div>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Lahir <!--<font color="red">*</font>--> <i>Tanggal lahir mahasiswa</i></label></td>
					<td><input type="text" name="tgl_lahir" size="40" maxlength="10" id="datepicker1" value="<?php echo $data_mhs['tanggal_lahir']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Agama <!--<font color="red">*</font>--> <i>Agama mahasiswa</i></i></label></td>
					<td><select name="agama">
							<option value="I" <?php if($data_mhs['agama'] == 'I'){ echo "SELECTED"; } ?>>Islam</option>
							<option value="K" <?php if($data_mhs['agama'] == 'K'){ echo "SELECTED"; } ?>>Kristen</option>
							<option value="C" <?php if($data_mhs['agama'] == 'C'){ echo "SELECTED"; } ?>>Katolik</option>
							<option value="H" <?php if($data_mhs['agama'] == 'H'){ echo "SELECTED"; } ?>>Hindu</option>
							<option value="B" <?php if($data_mhs['agama'] == 'B'){ echo "SELECTED"; } ?>>Budha</option>
							<option value="G" <?php if($data_mhs['agama'] == 'G'){ echo "SELECTED"; } ?>>Kong Hu Cu</option>
							<option value="L" <?php if($data_mhs['agama'] == 'L'){ echo "SELECTED"; } ?>>Lainnya</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Jenis Kelamin <font color="red">*</font> <i>Jenis kelamin mahasiswa</i></label></td>
					<td><select name="jenis_kelamin" class="required">
							<option value="L" <?php if($data_mhs['jenis_kelamin'] == 'L'){ echo "SELECTED"; } ?>>Laki-Laki</option>
							<option value="P" <?php if($data_mhs['jenis_kelamin'] == 'P'){ echo "SELECTED"; } ?>>Perempuan</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Golongan Darah <i>Golongan darah mahasiswa</i></label></td>
					<td><select name="darah">
							<option value="">- none -</option>
							<option value="A" <?php if($data_mhs['golongan_darah'] == 'A'){ echo "SELECTED"; } ?>>A</option>
							<option value="B" <?php if($data_mhs['golongan_darah'] == 'B'){ echo "SELECTED"; } ?>>B</option>
							<option value="C" <?php if($data_mhs['golongan_darah'] == 'C'){ echo "SELECTED"; } ?>>AB</option>
							<option value="O" <?php if($data_mhs['golongan_darah'] == 'O'){ echo "SELECTED"; } ?>>O</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Kewarganegaraan <i>Kewarganegaraan mahasiswa</i></label></td>
					<td><select name="negara">
							<option value="">- none -</option>
							<option value="A" <?php if($data_mhs['negara'] == 'A'){ echo "SELECTED"; } ?>>WNI</option>
							<option value="B" <?php if($data_mhs['negara'] == 'B'){ echo "SELECTED"; } ?>>WNA</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Status Perkawinan <i>Status perkawinan</i></label></td>
					<td><select name="kawin">
							<option value="">- none -</option>
							<option value="A" <?php if($data_mhs['status_kawin'] == 'A'){ echo "SELECTED"; } ?>>Kawin</option>
							<option value="B" <?php if($data_mhs['status_kawin'] == 'B'){ echo "SELECTED"; } ?>>Belum Kawin</option>
							<option value="C" <?php if($data_mhs['status_kawin'] == 'C'){ echo "SELECTED"; } ?>>Janda/Duda</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Gelar Depan <i>Gelar depan pendidikan</i></label></td>
					<td><input type="text" name="gelar_depan" size="40" maxlength="20" value="<?php echo $data_mhs['gelar_depan']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Gelar Belakang <i>Gelar belakang pendidikan</i></label></td>
					<td><input type="text" name="gelar_belakang" size="40" maxlength="20" value="<?php echo $data_mhs['gelar_belakang']; ?>"></td>
				</tr>
				<tr valign="top">
					<td width="200"><label>Alamat <i>Alamat lengkap mahasiswa</i></label></td>
					<td><textarea name="alamat" cols="40" rows="3"><?php echo $data_mhs['alamat']; ?></textarea></td>
				</tr>
				<tr valign="top">
					<td><label>Hobi <i>Hobi mahasiswa</i></label></td>
					<td><textarea name="hobi" cols="40" rows="3"><?php echo $data_mhs['hobi']; ?></textarea></td>
				</tr>
			</table>
			
			<table class="form">
				<tr valign="top">
					<td width="200"><label>NIM <i>Nomor Induk Mahasiswa</i></label></td>
					<td><input type="text" name="nim" size="40" maxlength="15" value="<?php echo $data_mhs['NIM']; ?>" disabled></td>
				</tr>
				<tr valign="top">
					<td><label>Program Kuliah <font color="red">*</font> <i>Program Kuliah Mahasiswa</i></label></td>
					<td><select name="kelas" class="required">
							<option value="R" <?php if($data_mhs['Kelas'] == 'R'){ echo "SELECTED"; } ?>>Reguler</option>
							<option value="N" <?php if($data_mhs['Kelas'] == 'N'){ echo "SELECTED"; } ?>>Non-Reguler</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Status Mahasiswa <font color="red">*</font> <i>Status Mahasiswa</i></label></td>
					<td><input type="hidden" name="status_mahasiswa" value="A">
						<select name="status_mahasiswa" DISABLED>
							<option value=""></option>
							<option value="A" <?php if($data_mhs['status_mahasiswa'] == 'A'){ echo "SELECTED"; } ?>>Aktif</option>
							<option value="C" <?php if($data_mhs['status_mahasiswa'] == 'C'){ echo "SELECTED"; } ?>>Cuti</option>
							<option value="D" <?php if($data_mhs['status_mahasiswa'] == 'D'){ echo "SELECTED"; } ?>>Drop-out</option>
							<option value="L" <?php if($data_mhs['status_mahasiswa'] == 'L'){ echo "SELECTED"; } ?>>Lulus</option>
							<option value="K" <?php if($data_mhs['status_mahasiswa'] == 'K'){ echo "SELECTED"; } ?>>Keluar</option>
							<option value="N" <?php if($data_mhs['status_mahasiswa'] == 'N'){ echo "SELECTED"; } ?>>Non-Aktif</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Status Awal Mahasiswa <font color="red">*</font> <i>Status Awal Mahasiswa</i></label></td>
					<td><select name="status_awal_mahasiswa" class="required">
							<option value="B" <?php if($data_mhs['status_awal_mahasiswa'] == 'B'){ echo "SELECTED"; } ?>>Baru</option>
							<option value="P" <?php if($data_mhs['status_awal_mahasiswa'] == 'P'){ echo "SELECTED"; } ?>>Pindahan</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Angkatan <font color="red">*</font> <i>Angkatan Mahasiswa</i></label></td>
					<td><select name="angkatan_id" class="required">
							<?php 
							$sql_angkatan = $db->database_prepare("SELECT * FROM as_angkatan WHERE aktif = 'A' ORDER BY angkatan_id DESC")->execute();
							while ($data_angkatan = $db->database_fetch_array($sql_angkatan)){
								if ($data_angkatan['semester_angkatan'] == 'A'){
									$semester = "Genap";
								}
								else{
									$semester = "Ganjil";
								}
								
								if ($data_mhs['angkatan_id'] == $data_angkatan['angkatan_id']){
									echo "<option value=$data_angkatan[angkatan_id] SELECTED>$data_angkatan[tahun_angkatan] - $semester</option>";
								}
								else{
									echo "<option value=$data_angkatan[angkatan_id]>$data_angkatan[tahun_angkatan] - $semester</option>";
								}
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Semester Masuk <font color="red">*</font> <i>Semester pertama mahasiswa masuk, misalnya Genap atau Ganjil</i></label></td>
					<td><select name="semester_masuk" class="required">
							<option value="A" <?php if($data_mhs['semester_masuk'] == 'A'){ echo "SELECTED"; } ?>>Genap</option>
							<option value="B" <?php if($data_mhs['semester_masuk'] == 'B'){ echo "SELECTED"; } ?>>Ganjil</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Tahun Masuk <font color="red">*</font> <i>Tahun Masuk Mahasiswa, merupakan tahun semester 1 mahasiswa</i></label></td>
					<td><input type="text" name="tahun_masuk" size="40" maxlength="4" class="required" value="<?php echo $data_mhs['tahun_masuk']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Tanggal Masuk Mahasiswa</label></td>
					<td><input type="text" name="tgl_masuk_mhs" size="40" maxlength="10" id="datepicker2" value="<?php echo $data_mhs['tanggal_masuk']; ?>"></td>
				</tr>
				<tr valign="top">
					<td></td>
					<td><button type="submit" class="btn btn-primary"><i class="icon-save"></i> Simpan Perubahan</button></td>
				</tr>
			</table>
			</form>
		</div>
	</div><!--<br>
		
	<label>Batas Studi</label>
		<input type="text" name="batas_studi" size="40" maxlength="5">	
		
	<h5>Bila Mahasiswa Berstatus Pindahan</h5>
	<div class="well">
		<table width="100%">
			<tr valign="top">
				<td width="50%">
					<label>NIM Asal</label>
						<input type="text" name="nim_asal" size="40" maxlength="15">
					<label>Propinsi Asal Pendidikan</label>
						<input type="text" name="propinsi_asal_pindahan" size="40" maxlength="20">
					<label>Jumlah SKS Diakui</label>
						<input type="text" name="sks" size="40" maxlength="3">
				</td>
				<td>
					<label>Kode Perguruan Tinggi Asal</label>
						<input type="text" name="kode_pt_asal" size="40" maxlength="6">
					<label>Kode Program Studi Asal</label>
						<input type="text" name="kode_ps_asal" size="40" maxlength="5">
					<label>Jenjang Pendidikan Sebelumnya</label>
						<select name="kode_jenjang_pendidikan_sebelumnya">
							<option value=""></option>
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
		</table>
	</div>
	
	
	<br>
	<h5>Khusus Mahasiswa S3</h5>
	<div class="well">
		<table width="100%">
			<tr valign="top">
				<td width="50%">
					<label>Biaya Studi</label>
						<select name="biaya_studi">
							<option value=""></option>
							<option value="A">Biaya APBN</option>
							<option value="B">Biaya APBD</option>
							<option value="C">Biaya PTN/BHMN</option>
							<option value="D">Biaya PTS</option>
							<option value="E">Institusi Luar Negeri</option>
							<option value="F">Institusi Dalam Negeri</option>
							<option value="G">Biaya Tempat Bekerja</option>
							<option value="H">Biaya Sendiri</option>
						</select>	
					<label>Pekerjaan</label>
						<select name="pekerjaan">
							<option value=""></option>
							<option value="A">Dosen PNS-PTN/BHMN</option>
							<option value="B">Dosen Kotrak PTN/BHMN</option>
							<option value="C">Dosen DPK PTS</option>
							<option value="D">Dosen PTS</option>
							<option value="E">PNS Lembaga Pemerintah</option>
							<option value="F">TNI/Polri</option>
							<option value="G">Pegawai Swasta</option>
							<option value="H">LSM</option>
							<option value="I">Wiraswasta</option>
							<option value="J">Belum Bekerja</option>
						</select>			
					<label>Nama Tempat Bekerja</label>
						<input type="text" name="tempat_bekerja" size="40" maxlength="40">
					<label>Kode Perguruan Tinggi (Bila Pekerjaan Mahasiswa S3 Sebagai Dosen)</label>
						<input type="text" name="kode_kerja_pt" size="40" maxlength="6">
					<label>Kode Program Studi (Bila Pekerjaan Mahasiswa S3 Sebagai Dosen)</label>
						<input type="text" name="kode_kerja_ps" size="40" maxlength="5">
				</td>
			</tr>
		</table>
	</div>
	-->
<?php
break;
}
?>