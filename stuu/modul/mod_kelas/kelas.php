<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Kelas Baru berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Kelas berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Kelas berhasil dihapus.</p>
	</div>
<?php
}
?>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
		$('#frm_kelas').validate({
			rules:{
				nama_kelas: true,
				semester: true,
				daya_tampung: true,
				aktif: true
			},
			messages:{
				nama_kelas:{
					required: "Nama Kelas Wajib Diisi."
				},
				semester:{
					required: "Semester Wajib Diisi."
				},
				daya_tampung:{
					required: "Kapasitas maksimal mahasiswa wajib diisi."
				},
				aktif:{
					required: "Status Kelas Wajib Diisi."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>		
	<h4>Pilih Tahun Angkatan</h4><br>
	<table class="data display datatable" id="example">
	<thead>
		<tr>
			<th width='30'>No</th>
			<th width='130'>Th. Angkatan</th>
			<th width='100'>Semester</th>
			<th width='90'>Status</th>
			<th align='left'>Lihat</th>
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
			<td>$data_angkatan[tahun_angkatan]</td>
			<td>$semester</td>
			<td>$status_angkatan</td>
			<td><a title='Masuk' href='?mod=kelas_prodi&act=detail&angkatan_id=$data_angkatan[angkatan_id]'><img src='../images/view.png' width='20'></a></td>
		</tr>";
		$no++;
	} 
	?>
	</tbody>
</table>
<?php

	break;
	
	case "detail":
	?>
	<a href="index.php?mod=kelas_prodi"><img src="../images/back.png"></a>
	<h4>Daftar Program Studi</h4><br>
	<table class="data display datatable" id="example">
		<thead>
			<tr>
				<th width='30'>No</th>
				<th width='250'>Program Studi</th>
				<th align='left'>Lihat</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$no = 1;
		$sql_prodi = $db->database_prepare("SELECT * FROM mspst WHERE STATUMSPST = 'A' ORDER BY KDJENMSPST,NMPSTMSPST ASC")->execute();
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
			echo "
			<tr>
				<td>$no</td>
				<td>$kd_jenjang_studi - $data_prodi[NMPSTMSPST]</td>
				<td><a title='Buka' href='?mod=kelas_prodi&act=detail&proid=$data_prodi[IDPSTMSPST]&angkatan_id=$_GET[angkatan_id]'><img src='../images/view.png' width='20'></a></td>
			</tr>";
			$no++;
		} 
		?>
		</tbody>
	</table>
	
	<?php
	if($_GET['proid'] != ''  && $_GET['angkatan_id'] != ''){
		$data_ang = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_angkatan WHERE angkatan_id = ?")->execute($_GET['angkatan_id']));
		$dt_prodi = $db->database_fetch_array($db->database_prepare("SELECT * FROM mspst WHERE IDPSTMSPST = ?")->execute($_GET["proid"]));
		if ($dt_prodi['KDJENMSPST'] == 'A'){
			$kd_jenjang_studi = "S3";
		}
		elseif ($dt_prodi['KDJENMSPST'] == 'B'){
			$kd_jenjang_studi = "S2";
		}
		elseif ($dt_prodi['KDJENMSPST'] == 'C'){
			$kd_jenjang_studi = "S1";
		}
		elseif ($dt_prodi['KDJENMSPST'] == 'D'){
			$kd_jenjang_studi = "D4";
		}
		elseif ($dt_prodi['KDJENMSPST'] == 'E'){
			$kd_jenjang_studi = "D3";
		}
		elseif ($dt_prodi['KDJENMSPST'] == 'F'){
			$kd_jenjang_studi = "D2";
		}
		elseif ($dt_prodi['KDJENMSPST'] == 'G'){
			$kd_jenjang_studi = "D1";
		}
		elseif ($dt_prodi['KDJENMSPST'] == 'H'){
			$kd_jenjang_studi = "Sp-1";
		}
		elseif ($dt_prodi['KDJENMSPST'] == 'I'){
			$kd_jenjang_studi = "Sp-2";
		}
		else{
			$kd_jenjang_studi = "Profesi";
		}
		
		if ($data_ang['semester_angkatan'] == 'A'){
			$semester = "Genap";
		}
		else{
			$semester = "Ganjil";
		}
		echo "<p>&nbsp;</p><p>&nbsp;</p>
			<div class='message info'>
				<h5>
				Data Kelas: $kd_jenjang_studi - $dt_prodi[NMPSTMSPST]<br>
				Th. Angkatan $data_ang[tahun_angkatan] - $semester</h5>
			</div>
		";
		?>
			<div>
				<a href="?mod=kelas_prodi&act=add&proid=<?php echo $_GET['proid']; ?>&angkatan_id=<?php echo $_GET['angkatan_id']; ?>"><button type='button' class='btn btn-green'>+ Tambah Kelas</button></a>
			</div><br>
			<table class="data display datatable" id="example">
				<thead>
					<tr>
						<th width='30'>No</th>
						<th width='100'>Kelas</th>
						<th width='100'>Semester</th>
						<th width='200'>Kapasitas Mahasiswa</th>
						<th width='100'>Status</th>
						<th align="left">Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 1;
				$sql_kelas = $db->database_prepare("SELECT * FROM as_kelas WHERE prodi_id = ? AND angkatan_id = ? ORDER BY kelas_id DESC")->execute($_GET["proid"],$_GET["angkatan_id"]);
				while ($data_kelas = $db->database_fetch_array($sql_kelas)){
					if ($data_kelas['aktif'] == 'A'){
						$status = "Aktif";
					}
					else{
						$status = "Tidak Aktif";
					}
					echo "
					<tr>
						<td>$no</td>
						<td>$data_kelas[nama_kelas]</td>
						<td>$data_kelas[semester_kelas]</td>
						<td>$data_kelas[daya_tampung]</td>
						<td>$status</td>
						<td><a title='Ubah' href='?mod=kelas_prodi&act=edit&id=$data_kelas[kelas_id]&proid=$_GET[proid]&angkatan_id=$_GET[angkatan_id]'><img src='../images/edit.jpg' width='20'</a>";
						?>
						<a title="Hapus" href="modul/mod_kelas/aksi_kelas.php?mod=kelas_prodi&act=delete&id=<?php echo $data_kelas[kelas_id];?>&proid=<?php echo $_GET['proid']; ?>&angkatan_id=<?php echo $_GET['angkatan_id']; ?>" onclick="return confirm('Anda Yakin ingin menghapus kelas <?php echo $data_kelas[nama_kelas];?>?');"><img src='../images/delete.jpg' width='20'></a>
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
	
	case "add":
	$data_ang = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_angkatan WHERE angkatan_id = ?")->execute($_GET['angkatan_id']));
	$dt_prodi = $db->database_fetch_array($db->database_prepare("SELECT * FROM mspst WHERE IDPSTMSPST = ?")->execute($_GET["proid"]));
	if ($dt_prodi['KDJENMSPST'] == 'A'){
		$kd_jenjang_studi = "S3";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'B'){
		$kd_jenjang_studi = "S2";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'C'){
		$kd_jenjang_studi = "S1";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'D'){
		$kd_jenjang_studi = "D4";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'E'){
		$kd_jenjang_studi = "D3";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'F'){
		$kd_jenjang_studi = "D2";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'G'){
		$kd_jenjang_studi = "D1";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'H'){
		$kd_jenjang_studi = "Sp-1";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'I'){
		$kd_jenjang_studi = "Sp-2";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'J'){
		$kd_jenjang_studi = "Profesi";
	}
?>
	<a href='javascript:history.go(-1)'><img src='../images/back.png'></a>
	<h4>Tambah Kelas</h4>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_kelas" action="modul/mod_kelas/aksi_kelas.php?mod=kelas_prodi&act=input" method="POST">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>Program Studi</label></td>
					<td><b><?php echo $kd_jenjang_studi." - ".$dt_prodi['NMPSTMSPST']; ?></b><p></p><input type="hidden" name="proid" value="<?php echo $dt_prodi['IDPSTMSPST']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Tahun Angkatan</label></td>
					<td><b><?php echo $data_ang['tahun_angkatan']; ?></b><p></p><input type="hidden" name="angkatan_id" value="<?php echo $data_ang['angkatan_id']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Nama Kelas <font color="red">*</font> <i>Nama kelas untuk program studi</i></label></td>
					<td><input type="text" name="nama_kelas" class="required"></td>
				</tr>
				<tr valign="top">
					<td><label>Semester <font color="red">*</font> <i>Semester kelas, segera update jika pergantian semester ke tingkat selanjutnya</i></label></td>
					<td><select name="semester" class="required">
							<option value="">- none -</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
						</select></td>
				</tr>
				<tr valign="top">
					<td><label>Kapasitas Mahasiswa <font color="red">*</font> <i>Kapasitas mahasiswa per kelas</i></label></td>
					<td><input type="text" name="daya_tampung" class="required"></td>
				</tr>
				<tr valign="top">
					<td><label>Status <font color="red">*</font> <i>Status kelas</i></label></td>
					<td><select name="aktif" class="required">
							<option value="">- none -</option>
							<option value="A">Aktif</option>
							<option value="N">Non-Aktif</option>
						</select>		
					</td>
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
	$data_ang = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_angkatan WHERE angkatan_id = ?")->execute($_GET['angkatan_id']));
	$dt_prodi = $db->database_fetch_array($db->database_prepare("SELECT * FROM mspst WHERE IDPSTMSPST = ?")->execute($_GET["proid"]));
	$data_kelas = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_kelas WHERE kelas_id=?")->execute($_GET["id"]));
	if ($dt_prodi['KDJENMSPST'] == 'A'){
		$kd_jenjang_studi = "S3";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'B'){
		$kd_jenjang_studi = "S2";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'C'){
		$kd_jenjang_studi = "S1";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'D'){
		$kd_jenjang_studi = "D4";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'E'){
		$kd_jenjang_studi = "D3";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'F'){
		$kd_jenjang_studi = "D2";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'G'){
		$kd_jenjang_studi = "D1";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'H'){
		$kd_jenjang_studi = "Sp-1";
	}
	elseif ($dt_prodi['KDJENMSPST'] == 'I'){
		$kd_jenjang_studi = "Sp-2";
	}
	else{
		$kd_jenjang_studi = "Profesi";
	}
?>
	<a href="javascript:history.go(-1)"><img src="../images/back.png"></a>
	<h4>Ubah Kelas</h4>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_kelas" action="modul/mod_kelas/aksi_kelas.php?mod=kelas_prodi&act=update" method="POST">
			<input type="hidden" name="id" value="<?php echo $data_kelas['kelas_id']; ?>">
			<input type="hidden" name="proid" value="<?php echo $_GET['proid']; ?>">
			<input type="hidden" name="angkatan_id" value="<?php echo $_GET['angkatan_id']; ?>">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>Program Studi</label></td>
					<td><b><?php echo $kd_jenjang_studi." - ".$dt_prodi['NMPSTMSPST']; ?></b><p></p><input type="hidden" name="proid" value="<?php echo $dt_prodi['IDPSTMSPST']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Tahun Angkatan</label></td>
					<td><b><?php echo $data_ang['tahun_angkatan']; ?></b><p></p><input type="hidden" name="angkatan_id" value="<?php echo $data_ang['angkatan_id']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Nama Kelas <font color="red">*</font> <i>Nama kelas untuk program studi</i></label></td>
					<td><input type="text" name="nama_kelas" class="required" value="<?php echo $data_kelas['nama_kelas']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Semester <font color="red">*</font> <i>Semester kelas, segera update jika pergantian semester ke tingkat selanjutnya</i></label></td>
					<td><select name="semester" class="required">
							<option value="1" <?php if($data_kelas['semester_kelas'] == 1){ echo "SELECTED"; } ?>>1</option>
							<option value="2" <?php if($data_kelas['semester_kelas'] == 2){ echo "SELECTED"; } ?>>2</option>
							<option value="3" <?php if($data_kelas['semester_kelas'] == 3){ echo "SELECTED"; } ?>>3</option>
							<option value="4" <?php if($data_kelas['semester_kelas'] == 4){ echo "SELECTED"; } ?>>4</option>
							<option value="5" <?php if($data_kelas['semester_kelas'] == 5){ echo "SELECTED"; } ?>>5</option>
							<option value="6" <?php if($data_kelas['semester_kelas'] == 6){ echo "SELECTED"; } ?>>6</option>
							<option value="7" <?php if($data_kelas['semester_kelas'] == 7){ echo "SELECTED"; } ?>>7</option>
							<option value="8" <?php if($data_kelas['semester_kelas'] == 8){ echo "SELECTED"; } ?>>8</option>
						</select>
				</td>
				</tr>
				<tr valign="top">
					<td><label>Kapasitas Mahasiswa <font color="red">*</font> <i>Kapasitas mahasiswa per kelas</i></label></td>
					<td><input type="text" name="daya_tampung" class="required" value="<?php echo $data_kelas['daya_tampung']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Status <font color="red">*</font> <i>Status kelas</i></label></td>
					<td><select name="aktif" class="required">
							<option value="A" <?php if($data_kelas['aktif'] == 'A'){ echo "SELECTED"; } ?>>Aktif</option>
							<option value="N" <?php if($data_kelas['aktif'] == 'N'){ echo "SELECTED"; } ?>>Non-Aktif</option>
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