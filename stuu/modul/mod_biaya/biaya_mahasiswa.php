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
?>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<?php
switch($_GET['act']){
	default:
?>
	<!--<a href="?mod=mhs&act=addprodi"><button type="button" class="btn btn-primary">+ Tambah Pembiayaan Mahasiswa</button></a>-->
	
	<h5>Pembiayaan Mahasiswa</h5>
	<div class="box round first fullpage">
		<div class="block ">
		<form action="" method="GET">
		<input type="hidden" name="mod" value="biaya_mahasiswa">
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
			<tr valign="top">
				<td><label>NIM Mahasiswa</label></td>
				<td><input type="text" name="nim" size="40" maxlength="15"></td>
			</tr>
			<tr valign="top">
				<td></td>
				<td><button type="submit" class="btn btn-primary">Buka Data</button></td>
			</tr>
		</table>
		</div>
	</div>
<?php

	break;
	
	case "biodata":
	if ($_GET["program_studi"] == "" && $_GET["nim"] == ""){
	?>
	<p><a href="?mod=biaya_mahasiswa"><img src="../images/back.png"></a></p>
	<h5>Data Semua Mahasiswa - Semua Program Studi</h5><br>
		<table class="data display datatable" id="example">
			<thead>
				<tr>
					<th width="30">No</th>
					<th width="210">Program Studi</th>
					<th width="100">NPM/NIM</th>
					<th width="250">Nama Mahasiswa</th>
					<th width="100">Status Biaya</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$no = 1;
			$sql_mhs = $db->database_prepare("SELECT A.kode_program_studi,B.KDJENMSPST, B.NMPSTMSPST, A.id_mhs, A.NIM, A.nama_mahasiswa, A.jenis_kelamin, A.Kelas, A.email, A.status_mahasiswa
												FROM as_mahasiswa A LEFT JOIN mspst B ON A.kode_program_studi = B.IDPSTMSPST
												ORDER BY A.kode_program_studi, A.NIM ASC")->execute();
			while ($data_mhs = $db->database_fetch_array($sql_mhs)){
				$data_semester = $db->database_fetch_array($db->database_prepare("SELECT semester FROM as_akun_biaya INNER JOIN as_mst_biaya ON as_mst_biaya.mst_biaya_id=as_akun_biaya.mst_biaya_id 
																				WHERE as_mst_biaya.prodi_id = ? AND as_akun_biaya.aktif = 'A' ORDER BY akun_id DESC LIMIT 1")->execute($data_mhs["kode_program_studi"]));
				$status_a = $db->database_prepare("SELECT 	A.tahun_angkatan,
															A.angkatan_id,
															C.semester,
															D.biaya_id
														FROM as_angkatan A INNER JOIN as_mst_biaya B ON B.angkatan_id=A.angkatan_id
														INNER JOIN as_akun_biaya C ON C.mst_biaya_id=B.mst_biaya_id
														INNER JOIN as_biaya_kuliah D ON D.akun_id=C.akun_id
														WHERE D.id_mhs = ? ORDER BY D.biaya_id DESC LIMIT 1")->execute($data_mhs["id_mhs"]);
				$status_b = $db->database_num_rows($status_a);
				$data_status = $db->database_fetch_array($status_a);
				if ($data_semester['semester'] > $data_status['semester']){
					$tambah_biaya = "<a href='?mod=biaya_mahasiswa&act=add&id=$data_mhs[id_mhs]&program_studi=$_GET[program_studi]&nim=$_GET[nim]'><img src='../images/add.jpg' width='20'></a>";
					$status_biaya = "";
				}
				else{
					$tambah_biaya = "";
					$status_biaya = $data_status['tahun_angkatan']." - ".$data_status['semester'];
				}
				
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
					<td>$status_biaya</td>
					<td>$tambah_biaya
						<a href='?mod=biaya_mahasiswa&act=edit&bid=$data_status[biaya_id]&id=$data_mhs[id_mhs]&program_studi=$_GET[program_studi]&nim=$_GET[nim]&ang_id=$data_status[angkatan_id]&sms=$data_status[semester]'><img src='../images/edit.jpg' width='20'></a>
					</td>
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
	
	<h5>Data Semua Mahasiswa<br>
		<?php echo $kd_prodi." - ".$data_prodi['NMPSTMSPST']; ?></h5><br>
	<p><a href="?mod=biaya_mahasiswa"><img src="../images/back.png"></a></p>
	
		<table class="data display datatable" id="example">
			<thead>
				<tr>
					<th width="30">No</th>
					<th width="210">Program Studi</th>
					<th width="100">NPM/NIM</th>
					<th width="250">Nama Mahasiswa</th>
					<th width="100">Status Biaya</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$no = 1;          
			$sql_mhs = $db->database_prepare("SELECT A.kode_program_studi,B.KDJENMSPST, B.NMPSTMSPST, A.id_mhs, A.NIM, A.nama_mahasiswa, A.jenis_kelamin, A.Kelas, A.email, A.status_mahasiswa
												FROM as_mahasiswa A LEFT JOIN mspst B ON A.kode_program_studi = B.IDPSTMSPST
												WHERE A.kode_program_studi = ?
												ORDER BY A.kode_program_studi, A.NIM ASC")->execute($_GET["program_studi"]);
			while ($data_mhs = $db->database_fetch_array($sql_mhs)){
				$data_semester = $db->database_fetch_array($db->database_prepare("SELECT semester FROM as_akun_biaya INNER JOIN as_mst_biaya ON as_mst_biaya.mst_biaya_id=as_akun_biaya.mst_biaya_id 
																				WHERE as_mst_biaya.prodi_id = ? AND as_akun_biaya.aktif = 'A' ORDER BY akun_id DESC LIMIT 1")->execute($data_mhs["kode_program_studi"]));
				$status_a = $db->database_prepare("SELECT 	A.tahun_angkatan,
															A.angkatan_id,
															C.semester,
															D.biaya_id
														FROM as_angkatan A INNER JOIN as_mst_biaya B ON B.angkatan_id=A.angkatan_id
														INNER JOIN as_akun_biaya C ON C.mst_biaya_id=B.mst_biaya_id
														INNER JOIN as_biaya_kuliah D ON D.akun_id=C.akun_id
														WHERE D.id_mhs = ? ORDER BY D.biaya_id DESC LIMIT 1")->execute($data_mhs["id_mhs"]);
				$status_b = $db->database_num_rows($status_a);
				$data_status = $db->database_fetch_array($status_a);
				if ($data_semester['semester'] > $data_status['semester']){
					$tambah_biaya = "<a href='?mod=biaya_mahasiswa&act=add&id=$data_mhs[id_mhs]&program_studi=$_GET[program_studi]&nim=$_GET[nim]'><img src='../images/add.jpg' width='20'></a> ";
					$status_biaya = "";
				}
				else{
					$tambah_biaya = "";
					$status_biaya = $data_status['tahun_angkatan']." - ".$data_status['semester'];
				}
				
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
					<td>$status_biaya</td>
					<td>$tambah_biaya
						<a title='Ubah' href='?mod=biaya_mahasiswa&act=edit&bid=$data_status[biaya_id]&id=$data_mhs[id_mhs]&program_studi=$_GET[program_studi]&nim=$_GET[nim]&ang_id=$data_status[angkatan_id]&sms=$data_status[semester]'><img src='../images/edit.jpg' width='20'></a></td>
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
		elseif ($data_prodi['KDJENMSPST'] == 'J'){
			$kd_prodi = "Profesi";
		}
	?>
	
	<h5>Data Mahasiswa</h5>
	<p><a href="?mod=biaya_mahasiswa"><img src="../images/back.png"></a></p>
	
		<table class="data display datatable" id="example">
			<thead>
				<tr>
					<th width="30">No</th>
					<th width="210">Program Studi</th>
					<th width="100">NPM/NIM</th>
					<th width="250">Nama Mahasiswa</th>
					<th width="100">Status Biaya</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$no = 1;          
			$sql_mhs = $db->database_prepare("SELECT A.kode_program_studi,B.KDJENMSPST, B.NMPSTMSPST, A.id_mhs, A.NIM, A.nama_mahasiswa, A.jenis_kelamin, A.Kelas, A.email, A.status_mahasiswa
												FROM as_mahasiswa A LEFT JOIN mspst B ON A.kode_program_studi = B.IDPSTMSPST
												WHERE A.kode_program_studi = ? AND A.nim = ?
												ORDER BY A.kode_program_studi, A.NIM ASC")->execute($_GET["program_studi"],$_GET["nim"]);
			while ($data_mhs = $db->database_fetch_array($sql_mhs)){
				$data_semester = $db->database_fetch_array($db->database_prepare("SELECT semester FROM as_akun_biaya INNER JOIN as_mst_biaya ON as_mst_biaya.mst_biaya_id=as_akun_biaya.mst_biaya_id 
																				WHERE as_mst_biaya.prodi_id = ? AND as_akun_biaya.aktif = 'A' ORDER BY akun_id DESC LIMIT 1")->execute($data_mhs["kode_program_studi"]));
				$status_a = $db->database_prepare("SELECT 	A.tahun_angkatan,
															A.angkatan_id,
															C.semester,
															D.biaya_id
														FROM as_angkatan A INNER JOIN as_mst_biaya B ON B.angkatan_id=A.angkatan_id
														INNER JOIN as_akun_biaya C ON C.mst_biaya_id=B.mst_biaya_id
														INNER JOIN as_biaya_kuliah D ON D.akun_id=C.akun_id
														WHERE D.id_mhs = ? ORDER BY D.biaya_id DESC LIMIT 1")->execute($data_mhs["id_mhs"]);
				$status_b = $db->database_num_rows($status_a);
				$data_status = $db->database_fetch_array($status_a);
				if ($data_semester['semester'] > $data_status['semester']){
					$tambah_biaya = "<a href='?mod=biaya_mahasiswa&act=add&id=$data_mhs[id_mhs]&program_studi=$_GET[program_studi]&nim=$_GET[nim]'><img src='../images/add.jpg' width='20'></a> ";
					$status_biaya = "";
				}
				else{
					$tambah_biaya = "";
					$status_biaya = $data_status['tahun_angkatan']." - ".$data_status['semester'];
				}
				
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
					<td>$status_biaya</td>
					<td>$tambah_biaya
						<a href='?mod=biaya_mahasiswa&act=edit&bid=$data_status[biaya_id]&id=$data_mhs[id_mhs]&program_studi=$_GET[program_studi]&nim=$_GET[nim]&ang_id=$data_status[angkatan_id]&sms=$data_status[semester]'><img src='../images/edit.jpg' width='20'></a></td>
				</tr>";
				$no++;
			} 
			?>
			</tbody>
		</table>
	<?php
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
	
	case "add":
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_mahasiswa WHERE id_mhs = ?")->execute($_GET["id"]));
	$data_prodi = $db->database_fetch_array($db->database_prepare("SELECT KDJENMSPST,NMPSTMSPST FROM mspst WHERE IDPSTMSPST = ?")->execute($data_mhs["kode_program_studi"]));
	if ($data_mhs['semester_masuk'] == 'A'){
		$semester = "1";
	}
	else{
		$semester = "2";
	}
	
	if ($data_mhs['status_mahasiswa'] == 'A'){
		$status_mahasiswa = "Aktif";
	}
	elseif ($data_mhs['status_mahasiswa'] == 'C'){
		$status_mahasiswa = "Cuti";
	}
	elseif ($data_mhs['status_mahasiswa'] == 'D'){
		$status_mahasiswa = "Drop-out";
	}
	elseif ($data_mhs['status_mahasiswa'] == 'L'){
		$status_mahasiswa = "Lulus";
	}
	elseif ($data_mhs['status_mahasiswa'] == 'K'){
		$status_mahasiswa = "keluar";
	}
	else{
		$status_mahasiswa = "Non-aktif";
	}
	
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
?>
	<p><a href="javascript:history.go(-1)"><img src="../images/back.png"></a></p><br>
	<h5>Tambah Biaya Kuliah</h5>
	<form action="modul/mod_biaya/aksi_biaya_mahasiswa.php?mod=biaya_mahasiswa&act=input" method="POST">
	<input type="hidden" name="kode_program_studi" value="<?php echo $_GET['prodi']; ?>">
	<input type="hidden" name="prodi" value="<?php echo $_GET['program_studi']; ?>">
	<input type="hidden" name="id_mhs" value="<?php echo $_GET['id']; ?>">
	<input type="hidden" name="nim" value="<?php echo $_GET['nim']; ?>">
	
		<table class="form">
			<tr valign="top">
				<td width="100">NIM</td>
				<td><?php echo $data_mhs['NIM']; ?></td>
			</tr>
			<tr valign="top">
				<td>Nama</td>
				<td><?php echo $data_mhs['nama_mahasiswa']; ?> / <?php echo $data_mhs['jenis_kelamin']; ?></td>
			</tr>
			<tr valign="top">
				<td>Tahun Masuk</td>
				<td><?php echo $data_mhs['tahun_masuk']; ?> - <?php echo $semester; ?></td>
			</tr>
			<tr valign="top">
				<td>Program Studi</td>
				<td><b><?php echo $kd_jenjang_studi." - ".$data_prodi['NMPSTMSPST']; ?></b></td>
			</tr>
			<tr valign="top">
				<td>Status</td>
				<td><b><?php echo $status_mahasiswa; ?></b></td>
			</tr>
		</table>
		<table class="form">
			<?php
			if ($data_mhs['Kelas'] == 'R'){
				$kelas = "A";
			}
			else{
				$kelas = "B";
			}
			$sql_biaya = $db->database_prepare("SELECT A.semester, A.akun_id, C.tahun_angkatan,C.semester_angkatan, A.uang_gedung, A.uang_sks, A.uang_spp FROM as_akun_biaya A 
												INNER JOIN as_mst_biaya B ON A.mst_biaya_id=B.mst_biaya_id
												INNER JOIN as_angkatan C ON C.angkatan_id=B.angkatan_id
												WHERE B.prodi_id = ? AND A.aktif = 'A' AND A.program = ?")->execute($data_mhs['kode_program_studi'],$kelas);
			$nums = $db->database_num_rows($sql_biaya);
			if ($nums == 0){
				echo "<b>Pembiayaan belum tersedia.</b>";
			}
			else{
			
			$data_biaya = $db->database_fetch_array($sql_biaya);
				if ($data_biaya['semester_angkatan'] == 'A'){
					$sem = "Genap";
				}
				else{
					$sem = "Ganjil";
				}
			echo "<h5>Tahun Angkatan: $data_biaya[tahun_angkatan] $sem <br>Semester : $data_biaya[semester]</h5>";
			?>
				<input type="hidden" name="akun_id" value="<?php echo $data_biaya['akun_id']; ?>">
				<tr valign="top">
					<td width="200"><label><b>Uang Gedung</b></label></td>
					<td><input type="text" name="uang_gedung" size="40" maxlength="11" value="<?php echo $data_biaya['uang_gedung']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label><b>Biaya SPP (Selama 1 semester)</b></label></td>
					<td><input type="text" name="uang_spp" size="40" maxlength="11" value="<?php echo $data_biaya['uang_spp']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label><b>Biaya per SKS</b></label></td>
					<td><input type="text" name="uang_sks" size="40" maxlength="11" value="<?php echo $data_biaya['uang_sks']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label><b>Keterangan</b></label></td>
					<td><textarea name="keterangan" cols="40" rows="5"></textarea></td>
				</tr>
			<?php
			}
			?>
		</table>
	<?php
	if ($nums > 0){ 
	?>
			<button type="submit" class="btn btn-green">Simpan</button>
	<?php
	}
	?>
	</form>
	<?php
	break;
	
	case "edit":
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_mahasiswa WHERE id_mhs = ?")->execute($_GET["id"]));
	$data_prodi = $db->database_fetch_array($db->database_prepare("SELECT KDJENMSPST,NMPSTMSPST FROM mspst WHERE IDPSTMSPST = ?")->execute($data_mhs["kode_program_studi"]));
	if ($data_mhs['semester_masuk'] == 'A'){
		$semester = "1";
	}
	else{
		$semester = "2";
	}
	
	if ($data_mhs['status_mahasiswa'] == 'A'){
		$status_mahasiswa = "Aktif";
	}
	elseif ($data_mhs['status_mahasiswa'] == 'C'){
		$status_mahasiswa = "Cuti";
	}
	elseif ($data_mhs['status_mahasiswa'] == 'D'){
		$status_mahasiswa = "Drop-out";
	}
	elseif ($data_mhs['status_mahasiswa'] == 'L'){
		$status_mahasiswa = "Lulus";
	}
	elseif ($data_mhs['status_mahasiswa'] == 'K'){
		$status_mahasiswa = "keluar";
	}
	else{
		$status_mahasiswa = "Non-aktif";
	}
	
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
?>
	<p><a href="javascript:history.go(-1)"><img src="../images/back.png"></a></p><br>
	<h5>Ubah Biaya Kuliah</h5>
	<form action="modul/mod_biaya/aksi_biaya_mahasiswa.php?mod=biaya_mahasiswa&act=update" method="POST">
	<input type="hidden" name="kode_program_studi" value="<?php echo $_GET['prodi']; ?>">
	<input type="hidden" name="prodi" value="<?php echo $_GET['program_studi']; ?>">
	<input type="hidden" name="id_mhs" value="<?php echo $_GET['id']; ?>">
	<input type="hidden" name="nim" value="<?php echo $_GET['nim']; ?>">
	<input type="hidden" name="id" value="<?php echo $_GET['bid']; ?>">
	
		<table class="form">
			<tr valign="top">
				<td width="100">NIM</td>
				<td><?php echo $data_mhs['NIM']; ?></td>
			</tr>
			<tr valign="top">
				<td width="80">Nama</td>
				<td><?php echo $data_mhs['nama_mahasiswa']; ?> / <?php echo $data_mhs['jenis_kelamin']; ?></td>
			</tr>
			<tr valign="top">
				<td width="80">Tahun Masuk</td>
				<td><?php echo $data_mhs['tahun_masuk']; ?> - <?php echo $semester; ?></td>
			</tr>
			<tr valign="top">
				<td width="80">Program Studi</td>
				<td><b><?php echo $kd_jenjang_studi." - ".$data_prodi['NMPSTMSPST']; ?></b></td>
			</tr>
			<tr valign="top">
				<td width="80">Status</td>
				<td><b><?php echo $status_mahasiswa; ?></b></td>
			</tr>
		</table>
		<table class="form">
			<?php
			if ($data_mhs['Kelas'] == 'R'){
				$kelas = "A";
			}
			else{
				$kelas = "B";
			}
			$sql_biaya = $db->database_prepare("SELECT A.uang_gedung, A.uang_sks, A.uang_spp, A.keterangan FROM 
												as_biaya_kuliah A WHERE 
												A.biaya_id = ?")->execute($_GET['bid']);
			$nums = $db->database_num_rows($sql_biaya);
			if ($nums == 0){
				echo "<b>Pembiayaan belum tersedia.</b>";
			}
			else{
			
			$data_biaya = $db->database_fetch_array($sql_biaya);
				if ($data_biaya['semester_angkatan'] == 'A'){
					$sem = "Genap";
				}
				else{
					$sem = "Ganjil";
				}
			echo "<h5>Tahun Angkatan: $data_biaya[tahun_angkatan] $sem <br>Semester : $data_biaya[semester]</h5>";
			?>
				<input type="hidden" name="akun_id" value="<?php echo $data_biaya['akun_id']; ?>">
				<tr valign="top">
					<td width="200"><label><b>Uang Gedung</b></label></td>
					<td><input type="text" name="uang_gedung" size="40" maxlength="11" value="<?php echo $data_biaya['uang_gedung']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label><b>Biaya SPP (Selama 1 semester)</b></label></td>
					<td><input type="text" name="uang_spp" size="40" maxlength="11" value="<?php echo $data_biaya['uang_spp']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label><b>Biaya per SKS</b></label></td>
					<td><input type="text" name="uang_sks" size="40" maxlength="11" value="<?php echo $data_biaya['uang_sks']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label><b>Keterangan</b></label></td>
					<td><textarea name="keterangan" cols="40" rows="5"><?php echo $data_biaya['keterangan']; ?></textarea></td>
				</tr>
				<?php if ($nums > 0){ ?>
					<tr valign="top">
					<td></td>
					<td><button type="submit" class="btn btn-primary">Simpan Perubahan</button></td>
				</tr>
				<?php } ?>
			<?php
			}
			?>
		</table>
	
	</form>
	<?php
	break;
}
?>