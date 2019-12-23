<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Master Biaya Baru berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Master Biaya berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Master Biaya berhasil dihapus.</p>
	</div>
<?php
}
?>
<?php 
if ($_GET['code_a'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Akun Biaya Baru berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code_a'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Akun Biaya berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code_a'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Akun Biaya berhasil dihapus.</p>
	</div>
<?php
}
?>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
		$('#frm_biaya').validate({
			rules:{
				prodi: true,
				tahun: true
			},
			messages:{
				prodi:{
					required: "Program studi wajib diisi Wajib Diisi."
				},
				tahun:{
					required: "Tahun/semester Wajib Diisi."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
<div>
	<a href="?mod=biaya&act=add"><button type="button" class="btn btn-green">+ Tambah Master Biaya</button></a>
</div>
		<br>		
	<table class="data display datatable" id="example">
	<thead>
		<tr>
			<th width='30'>No</th>
			<th width='220'>Program Studi</th>
			<th>Aksi</th>
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
			<td><a href='?mod=biaya&act=view&proid=$data_prodi[IDPSTMSPST]'><img src='../images/view.png' width='20'></a></td>
		</tr>";
		$no++;
	} 
	?>
	</tbody>
</table>
<?php

	break;
	
	case "view":
	if ($_GET['sess'] == ''){
	?>
		<a href="javascript:history.go(-1)"><img src="../images/back.png"></a><br><br>
		<?php
		$prodi = $db->database_fetch_array($db->database_prepare("SELECT KDJENMSPST, NMPSTMSPST FROM mspst WHERE IDPSTMSPST = ?")->execute($_GET["proid"]));
		if ($prodi['KDJENMSPST'] == 'A'){
			$kd_jenjang_studi = "S3";
		}
		elseif ($prodi['KDJENMSPST'] == 'B'){
			$kd_jenjang_studi = "S2";
		}
		elseif ($prodi['KDJENMSPST'] == 'C'){
			$kd_jenjang_studi = "S1";
		}
		elseif ($prodi['KDJENMSPST'] == 'D'){
			$kd_jenjang_studi = "D4";
		}
		elseif ($prodi['KDJENMSPST'] == 'E'){
			$kd_jenjang_studi = "D3";
		}
		elseif ($prodi['KDJENMSPST'] == 'F'){
			$kd_jenjang_studi = "D2";
		}
		elseif ($prodi['KDJENMSPST'] == 'G'){
			$kd_jenjang_studi = "D1";
		}
		elseif ($prodi['KDJENMSPST'] == 'H'){
			$kd_jenjang_studi = "Sp-1";
		}
		elseif ($prodi['KDJENMSPST'] == 'I'){
			$kd_jenjang_studi = "Sp-2";
		}
		elseif ($prodi['KDJENMSPST'] == 'J'){
			$kd_jenjang_studi = "Profesi";
		}
		?>
		<h5><?php echo $kd_jenjang_studi." - ".$prodi['NMPSTMSPST']; ?><br>
			Daftar Master Biaya</h5><br>
		<div>
			<a href="?mod=biaya&act=add&proid=<?php echo $_GET['proid']; ?>"><button type="button" class="btn btn-green">+ Tambah Master Biaya</button></a>
		</div><br>
		<table class="data display datatable" id="example">
			<thead>
				<tr>
					<th width='30'>No</th>
					<th width='150'>Tahun Angkatan</th>
					<th width='500'>Keterangan</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$no = 1;
			$sql_biaya = $db->database_prepare("SELECT tahun_angkatan,semester_angkatan,keterangan,mst_biaya_id FROM as_mst_biaya LEFT JOIN as_angkatan ON as_angkatan.angkatan_id=as_mst_biaya.angkatan_id WHERE as_mst_biaya.prodi_id = ? ORDER BY as_mst_biaya.mst_biaya_id DESC")->execute($_GET["proid"]);
			while ($data_biaya = $db->database_fetch_array($sql_biaya)){
				if($data_biaya['semester_angkatan'] == 'A'){
					$semester = "Genap";
				}
				else{
					$semester = "Ganjil";
				}
				echo "
				<tr>
					<td>$no</td>
					<td>$data_biaya[tahun_angkatan] - $semester</td>
					<td>$data_biaya[keterangan]</td>
					<td><a title='Lihat' href='?mod=biaya&act=view&proid=$_GET[proid]&mstbiayaid=$data_biaya[mst_biaya_id]'><img src='../images/view.png' width='20'></a> 
						<a title='Ubah' href='?mod=biaya&act=edit&proid=$_GET[proid]&mstbiayaid=$data_biaya[mst_biaya_id]'><img src='../images/edit.jpg' width='20'></a>";
						?>
						<a title='Hapus' href="modul/mod_biaya/aksi_biaya.php?mod=biaya&act=delete&id=<?php echo $data_biaya[mst_biaya_id];?>&proid=<?php echo $_GET[proid]; ?>" onclick="return confirm('Anda Yakin ingin menghapus master biaya <?php echo $data_biaya[tahun_angkatan]." - ".$semester; ?>?');"><img src='../images/delete.jpg' width='20'></a>
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
	if ($_GET['act'] == 'view' && $_GET['mstbiayaid'] != '' && $_GET['sess'] == ''){
		$data_angkatan = $db->database_fetch_array($db->database_prepare("SELECT tahun_angkatan,semester_angkatan FROM as_mst_biaya INNER JOIN as_angkatan ON as_angkatan.angkatan_id=as_mst_biaya.angkatan_id WHERE as_mst_biaya.mst_biaya_id = ?")->execute($_GET["mstbiayaid"]));
		if ($data_angkatan['semester_angkatan'] == 'A'){
			$sem_ang = "Genap";
		} 
		else{
			$sem_ang = "Ganjil";
		}
	?>
		<p>&nbsp;</p><p>&nbsp;</p><h5>Akun Biaya <br>Th. Angkatan: <?php echo $data_angkatan['tahun_angkatan']; ?> - <?php echo $sem_ang; ?></h5>
		<div>
			<a href="?mod=biaya&act=view&sess=akun_add&proid=<?php echo $_GET['proid']; ?>&mstbiayaid=<?php echo $_GET['mstbiayaid']; ?>"><button type="button" class="btn btn-green">+ Tambah Akun Biaya</button></a>
		</div><br>
		<table class="data display datatable" id="example">
			<thead>
				<tr>
					<th width="30">No</th>
					<th width="140">Uang Gedung</th>
					<th width="140">SKS</th>
					<th width="140">SPP</th>
					<th width="100">Semester</th>
					<th width="130">Program</th>
					<th width="130">Status</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$no = 1;
			$sql_akun_biaya = $db->database_prepare("SELECT * FROM as_akun_biaya WHERE mst_biaya_id = ? ORDER BY akun_id DESC")->execute($_GET["mstbiayaid"]);
			while ($data_akun_biaya = $db->database_fetch_array($sql_akun_biaya)){
				if ($data_akun_biaya['pembayaran'] == 'A'){
					$pembayaran = "Sebelum Masuk";
				}
				elseif($data_akun_biaya['pembayaran'] == 'B'){
					$pembayaran = "Awal Masuk";
				}
				elseif($data_akun_biaya['pembayaran'] == 'C'){
					$pembayaran = "Tiap Semester";
				}
				elseif($data_akun_biaya['pembayaran'] == 'D'){
					$pembayaran = "Sebelum Ujian";
				}
				else{
					$pembayaran = "Lulus Studi";
				}
				
				if($data_akun_biaya['aktif'] == 'A'){
					$status = "Aktif";
				}
				else{
					$status = "Tidak Aktif";
				}
				
				if($data_akun_biaya['program'] == 'A'){
					$program = "Reguler";
				}
				else{
					$program = "Non-Reguler";
				}
				
				$uang_gedung = rupiah($data_akun_biaya['uang_gedung']);
				$sks = rupiah($data_akun_biaya['uang_sks']);
				$spp = rupiah($data_akun_biaya['uang_spp']);
				echo "
				<tr>
					<td>$no</td>
					<td>Rp. $uang_gedung</td>
					<td>Rp. $sks</td>
					<td>Rp. $spp</td>
					<td>$data_akun_biaya[semester]</td>
					<td>$program</td>
					<td>$status</td>
					<td><a href='?mod=biaya&act=edit&sess=akun_edit&id=$data_akun_biaya[akun_id]&proid=$_GET[proid]&mstbiayaid=$_GET[mstbiayaid]'><img src='../images/edit.jpg' width='20'></a>";
					?>
					<a href="modul/mod_biaya/aksi_biaya.php?mod=akun_biaya&act=delete&id=<?php echo $data_akun_biaya[akun_id];?>&mstbiayaid=<?php echo $_GET[mstbiayaid]; ?>&proid=<?php echo $_GET[proid]; ?>" onclick="return confirm('Anda Yakin ingin menghapus akun biaya semester <?php echo $data_akun_biaya[semester];?>?');"><img src='../images/delete.jpg' width='20'></a>
					<?php
			echo "		</td>
				</tr>";
				$no++;
			} 
			?>
			</tbody>
		</table>
	
	<?php
	}

	elseif ($_GET['sess'] == 'akun_add'){
	?>
		<a href="index.php?mod=biaya&act=view&proid=<?php echo $_GET['proid']; ?>&mstbiayaid=<?php echo $_GET['mstbiayaid']; ?>"><img src="../images/back.png"></a>
		<h5>Tambah Akun Biaya</h5>
		<div class="box round first fullpage">
			<div class="block ">
			<form id="frm_akun_biaya" action="modul/mod_biaya/aksi_biaya.php?mod=akun_biaya&act=input" method="POST">
			<input type="hidden" name="mst_biaya_id" value="<?php echo $_GET['mstbiayaid']; ?>">
			<input type="hidden" name="proid" value="<?php echo $_GET['proid']; ?>">
			<table class="form">
				<tr valign="top">
					<td width="200"><label><b>Uang Gedung</b> <i>Besarnya biaya gedung yang harus dibayar</i></label></td>
					<td><input type="text" name="uang_gedung" size="40" maxlength="11"></td>
				</tr>
				<tr valign="top">
					<td><label><b>Biaya per SKS</b> <i>Besarnya biaya per SKS yang harus dibayar per semester</i></label></td>
					<td><input type="text" name="uang_sks" size="40" maxlength="11"></td>
				</tr>
				<tr valign="top">
					<td><label><b>SPP</b> <i>Besarnya biaya SPP yang harus dibayar dalam 1 semester</i></label></td>
					<td><input type="text" name="uang_spp" size="40" maxlength="11"></td>
				</tr>
				<tr valign="top">
					<td><label><b>Program Kuliah </b> <i>Biaya berlaku untuk Program kuliah?</i></label></td>
					<td><select name="program">
							<option value="">- none -</option>
							<option value="A">Reguler</option>
							<option value="B">Non-Reguler</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label><b>Semester</b> <i>Semester</i></label> </td>
					<td><select name="semester">
							<option value="">- none -</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label><b>Status Biaya</b> <i>Status biaya</i></label> </td>
					<td><select name="status">
							<option value="">- none -</option>
							<option value="A">Aktif</option>
							<option value="N">Tidak Aktif</option>
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
				
				<!--<label><b>Pembayaran </b><i>Waktu wajib pembayaran biaya kuliah</i></label>
					<select name="pembayaran">
						<option value=""></option>
						<option value="A">Sebelum Masuk</option>
						<option value="B">Awal Masuk</option>
						<option value="C">Tiap Semester</option>
						<option value="D">Sebelum Ujian (UTS/UAS)</option>
						<option value="E">Lulus Studi</option>
					</select>-->
				
	<?php
	}
	break;
	
	case "add":
?>
	<a href="index.php?mod=biaya&act=view&proid=<?php echo $_GET['proid']; ?>"><img src='../images/back.png'></a>
	<h5>Tambah Master Biaya</h5>
	<div class="box round first fullpage">
		<div class="block ">
		<form id="frm_biaya" action="modul/mod_biaya/aksi_biaya.php?mod=biaya&act=input" method="POST">
			<table class='form'>
				<tr valign='top'>
					<td width='200'><label>Program Studi <font color="red">*</font> <i>Program studi</i></label></td>
					<td><select name="prodi" class="required">
							<option value="">- none -</option>
							<?php
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
								echo "<option value=$data_prodi[IDPSTMSPST]>$kd_jenjang_studi - $data_prodi[NMPSTMSPST]</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Tahun Angkatan<font color="red">*</font> <i>Tahun angkatan</i></label></td>
					<td><select name="tahun" class="required">
							<option value="">- none -</option>
						<?php
						$sql_angkatan = $db->database_prepare("SELECT * FROM as_angkatan WHERE aktif = 'A' ORDER BY tahun_angkatan ASC")->execute();
						while ($data_angkatan = $db->database_fetch_array($sql_angkatan)){
							if ($data_angkatan['semester_angkatan'] == 'A'){
								$sem = "Genap";
							}
							else{
								$sem = "Ganjil";
							}
							echo "<option value=$data_angkatan[angkatan_id]>$data_angkatan[tahun_angkatan] - $sem</option>";
						}
						?>
						</select>		
					</td>
				</tr>
				<tr valign="top">
					<td><label>Keterangan</label></td>
					<td><textarea name="keterangan" cols="60" rows="5"></textarea></td>
				</tr>
				<tr valign="top">
					<td></td>
					<td><button type="submit" class="btn btn-primary">Simpan</button></td>
				</tr>
			</table>
		</div>
	</div>
	<?php
	break;
	
	case "edit":
	$data_biaya = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_mst_biaya LEFT JOIN mspst ON mspst.IDPSTMSPST=as_mst_biaya.prodi_id WHERE as_mst_biaya.mst_biaya_id = ?")->execute($_GET["mstbiayaid"]));
	if ($data_biaya['KDJENMSPST'] == 'A'){
		$kd_jenjang_studi = "S3";
	}
	elseif ($data_biaya['KDJENMSPST'] == 'B'){
		$kd_jenjang_studi = "S2";
	}
	elseif ($data_biaya['KDJENMSPST'] == 'C'){
		$kd_jenjang_studi = "S1";
	}
	elseif ($data_biaya['KDJENMSPST'] == 'D'){
		$kd_jenjang_studi = "D4";
	}
	elseif ($data_biaya['KDJENMSPST'] == 'E'){
		$kd_jenjang_studi = "D3";
	}
	elseif ($data_biaya['KDJENMSPST'] == 'F'){
		$kd_jenjang_studi = "D2";
	}
	elseif ($data_biaya['KDJENMSPST'] == 'G'){
		$kd_jenjang_studi = "D1";
	}
	elseif ($data_biaya['KDJENMSPST'] == 'H'){
		$kd_jenjang_studi = "Sp-1";
	}
	elseif ($data_biaya['KDJENMSPST'] == 'I'){
		$kd_jenjang_studi = "Sp-2";
	}
	else{
		$kd_jenjang_studi = "Profesi";
	}
	
	if ($_GET['sess'] == 'akun_edit'){
		$data_akun = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_akun_biaya WHERE akun_id = ?")->execute($_GET["id"]));
		?>
		<a href="index.php?mod=biaya&act=view&proid=<?php echo $_GET['proid']; ?>&mstbiayaid=<?php echo $_GET['mstbiayaid']; ?>"><img src="../images/back.png"></a><br><br>
		<h5>Ubah Akun Biaya</h5>
		<div class="box round first fullpage">
			<div class="block ">
			<form id="frm_akun_biaya" action="modul/mod_biaya/aksi_biaya.php?mod=akun_biaya&act=update" method="POST">
			<input type="hidden" name="mst_biaya_id" value="<?php echo $_GET['mstbiayaid']; ?>">
			<input type="hidden" name="proid" value="<?php echo $_GET['proid']; ?>">
			<input type="hidden" name="id" value="<?php echo $data_akun['akun_id']; ?>">
			<table class="form">
				<tr valign="top">
					<td width="200"><label><b>Uang Gedung</b> <i>Besarnya biaya gedung yang harus dibayar</i></label></td>
					<td><input type="text" name="uang_gedung" size="40" maxlength="11" value="<?php echo $data_akun['uang_gedung']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label><b>Biaya per SKS</b> <i>Besarnya biaya per SKS yang harus dibayar per semester</i></label></td>
					<td><input type="text" name="uang_sks" size="40" maxlength="11" value="<?php echo $data_akun['uang_sks']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label><b>SPP</b> <i>Besarnya biaya SPP yang harus dibayar dalam 1 semester</i></label></td>
					<td><input type="text" name="uang_spp" size="40" maxlength="11" value="<?php echo $data_akun['uang_spp']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label><b>Program Kuliah </b> <i>Biaya berlaku untuk Program kuliah?</i></label></td>
					<td><select name="program">
							<option value="">- none -</option>
							<option value="A" <?php if($data_akun['program'] == 'A'){ echo "SELECTED"; } ?>>Reguler</option>
							<option value="B" <?php if($data_akun['program'] == 'B'){ echo "SELECTED"; } ?>>Non-Reguler</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label><b>Semester</b> <i>Semester</i></label> </td>
					<td><select name="semester">
							<option value="">- none -</option>
							<option value="1" <?php if($data_akun['semester'] == 1){ echo "SELECTED"; } ?>>1</option>
							<option value="2" <?php if($data_akun['semester'] == 2){ echo "SELECTED"; } ?>>2</option>
							<option value="3" <?php if($data_akun['semester'] == 3){ echo "SELECTED"; } ?>>3</option>
							<option value="4" <?php if($data_akun['semester'] == 4){ echo "SELECTED"; } ?>>4</option>
							<option value="5" <?php if($data_akun['semester'] == 5){ echo "SELECTED"; } ?>>5</option>
							<option value="6" <?php if($data_akun['semester'] == 6){ echo "SELECTED"; } ?>>6</option>
							<option value="7" <?php if($data_akun['semester'] == 7){ echo "SELECTED"; } ?>>7</option>
							<option value="8" <?php if($data_akun['semester'] == 8){ echo "SELECTED"; } ?>>8</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label><b>Status Biaya</b> <i>Status biaya</i></label> </td>
					<td><select name="status">
							<option value="">- none -</option>
							<option value="A" <?php if($data_akun['aktif'] == A){ echo "SELECTED"; } ?>>Aktif</option>
							<option value="N" <?php if($data_akun['aktif'] == N){ echo "SELECTED"; } ?>>Tidak Aktif</option>
						</select>
					</td>
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
	}
	else{
?>
	
	<a href="index.php?mod=biaya&act=view&proid=<?php echo $_GET['proid']; ?>"><img src="../images/back.png"></a>
	<h5>Ubah Master Biaya</h5>
	<div class="box round first fullpage">
		<div class="block ">
		<form id="frm_biaya" action="modul/mod_biaya/aksi_biaya.php?mod=biaya&act=update" method="POST">
		<input type="hidden" name="id" value="<?php echo $data_biaya['mst_biaya_id']; ?>">
		<input type="hidden" name="prodi" value="<?php echo $data_biaya['prodi_id']; ?>">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>Program Studi <font color="red">*</font> <i>Program studi</i></label></td>
					<td><b><?php echo $kd_jenjang_studi." - ".$data_biaya['NMPSTMSPST']; ?></b></td>
				</tr>
				<tr>
					<td><label>Tahun Angkatan<font color="red">*</font> <i>Tahun angkatan</i></label></td>
					<td><select name="tahun" class="required">
						<?php
						$sql_angkatan = $db->database_prepare("SELECT * FROM as_angkatan WHERE aktif = 'A' ORDER BY tahun_angkatan,semester_angkatan ASC")->execute();
						while ($data_angkatan = $db->database_fetch_array($sql_angkatan)){
							if ($data_angkatan['semester_angkatan'] == 'A'){
								$sem = "Genap";
							}
							else{
								$sem = "Ganjil";
							}
							
							if ($data_biaya['angkatan_id'] == $data_angkatan['angkatan_id']){
								echo "<option value=$data_angkatan[angkatan_id] SELECTED>$data_angkatan[tahun_angkatan] - $sem</option>";
							}
							else{
								echo "<option value=$data_angkatan[angkatan_id]>$data_angkatan[tahun_angkatan] - $sem</option>";
							}
						}
						?>
						</select>	
					</td>
				</tr>
				<tr valign="top">
					<td><label>Keterangan</label></td>
					<td><textarea name="keterangan" cols="60" rows="5"><?php echo $data_biaya['keterangan']; ?></textarea></td>
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
	}
	break;
}
?>