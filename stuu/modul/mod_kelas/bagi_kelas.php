<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Pembagian Kelas Baru berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Pembagian Kelas berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Pembagian Kelas berhasil dihapus.</p>
	</div>
<?php
}
?>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
		$('#frm_lanjut').validate({
			rules:{
				prodi: true,
				tahun_angkatan: true
			},
			messages:{
				prodi:{
					required: "Pilih program studi."
				},
				tahun_angkatan:{
					required: "Pilih tahun angkatan."
				}
			}
		});
		
		$('#frm_lanjut2').validate({
			rules:{
				prodi: true,
				tahun_angkatan: true
			},
			messages:{
				prodi:{
					required: "Pilih program studi."
				},
				tahun_angkatan:{
					required: "Pilih tahun angkatan."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
	echo "
	<h5>Pembagian Kelas Mahasiswa</h5><br>
	<div class='well'>
		<ul id='menu2' class='menu2'>
			<li class='active'><a href='#home'>Data Mahasiswa Angkatan Baru</a></li>
			<li><a href='#jurusan'>Data Mahasiswa Per Jurusan</a></li>
		</ul>
		<div id='home' class='content2'>
			<p>
			<div class='box round first fullpage'>
				<div class='block '>
					<form method='GET' action='' id='frm_lanjut'>
					<input type='hidden' name='mod' value='bagi_kelas'>
					<input type='hidden' name='act' value='data_mhs'>
					<table class='form'>
						<tr valign='top'>
							<td width='200'><label>Program Studi</label></td>
							<td><select name='prodi' class='required'>
									<option value=''>- none -</option>";
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
						echo "	</select>
							</td>
						</tr>
						<tr valign='top'>
							<td><label>Tahun Angkatan</label></td>
							<td><select name='tahun_angkatan' class='required'>
									<option value=''>- none -</option>";
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
								echo "</select>
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
			</p>
		</div>
		
		<div id='jurusan' class='content2'>
			<p>
			<div class='box round first fullpage'>
				<div class='block '>
					<form method='GET' action='' id='frm_lanjut2'>
					<input type='hidden' name='mod' value='bagi_kelas'>
					<input type='hidden' name='act' value='all'>
					<table class='form'>
						<tr valign='top'>
							<td width='200'><label>Program Studi</label></td>
							<td><select name='prodi' class='required'>
									<option value=''>- none -</option>";
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
						echo "	</select>
							</td>
						</tr>
						<tr>
							<td><label>Tahun Angkatan</label></td>
							<td><select name='tahun_angkatan' class='required'>
									<option value=''>- none -</option>";
									$sql_angkatan = $db->database_prepare("SELECT * FROM as_angkatan WHERE aktif = 'A' ORDER BY angkatan_id DESC")->execute();
									while ($data_angkatan = $db->database_fetch_array($sql_angkatan)){
										if ($data_angkatan['semester_angkatan'] == 'A'){
											$semes = "Genap";
										}
										else{
											$semes = "Ganjil";
										}
										echo "<option value=$data_angkatan[angkatan_id]>$data_angkatan[tahun_angkatan] - $semes</option>";
									}
								echo "</select>
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
			</p>
		</div>
	</div>
	";

	break;
	
	case "data_mhs":
	$data_angkatan = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_angkatan WHERE angkatan_id = ?")->execute($_GET['tahun_angkatan']));
	$sql_prodi = $db->database_prepare("SELECT * FROM mspst WHERE IDPSTMSPST = ?")->execute($_GET['prodi']);
	$data_prodi = $db->database_fetch_array($sql_prodi);
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
	echo "<a href='index.php?mod=bagi_kelas'><img src='../images/back.png'></a>
		<h5>Data Mahasiswa Ajaran Baru <br>
		Program Studi: $kd_jenjang_studi - $data_prodi[NMPSTMSPST], Th. Angkatan: $data_angkatan[tahun_angkatan]</h5><br>
		<form method='POST' action='modul/mod_kelas/aksi_bagi_kelas.php?mod=bagi_kelas&act=input'>
		<table class='data display datatable' id='example'>
			<thead>
			<tr bgcolor='#B7D577'>
				<th width='30'>No</th>
				<th width='150'>NIM/NPM</th>
				<th width='250'>Nama</th>
				<th width='100'>Status</th>
				<th width='50'>JK</th>
				<th>Kelas</th>
			</tr>
			<thead><tbody>
			";
			$i = 1;
			$sql_mhs = $db->database_prepare("SELECT * FROM as_mahasiswa WHERE angkatan_id = ? AND kode_program_studi = ? ORDER BY id_mhs ASC")->execute($_GET['tahun_angkatan'],$_GET['prodi']);
			while ($data_mhs = $db->database_fetch_array($sql_mhs)){
				if ($i % 2 == 1){
					$bg = "#CCCCCC";
				}
				else{
					$bg = "#FFFFFF";
				}
				if ($data_mhs['status_mahasiswa'] == 'A'){
					$status = 'Aktif';
				}
				elseif ($data_mhs['status_mahasiswa'] == 'C'){
					$status = 'Cuti';
				}
				elseif ($data_mhs['status_mahasiswa'] == 'D'){
					$status = 'Drop-out';
				}
				elseif ($data_mhs['status_mahasiswa'] == 'L'){
					$status = 'Lulus';
				}
				elseif ($data_mhs['status_mahasiswa'] == 'K'){
					$status = 'Keluar';
				}
				else{
					$status = 'Non-Aktif';
				}
				
				$num = $db->database_num_rows($db->database_prepare("SELECT * FROM as_kelas_mahasiswa WHERE id_mhs = ? AND semester = '1'")->execute($data_mhs['id_mhs']));
				if ($num == 0){
					echo "<tr>
							<td bgcolor=$bg>$i</td>
							<td bgcolor=$bg>$data_mhs[NIM]<input type='hidden' name='id_mhs[]' value=$data_mhs[id_mhs]></td>
							<td bgcolor=$bg>$data_mhs[nama_mahasiswa]</td>
							<td bgcolor=$bg>$status</td>
							<td bgcolor=$bg>$data_mhs[jenis_kelamin]</td>
							<td bgcolor=$bg><select name='kelas_id[]'><option value=''></option>";
							$sql_kelas = $db->database_prepare("SELECT * FROM as_kelas WHERE prodi_id = ? AND angkatan_id = ? AND semester_kelas = '1' AND aktif = 'A' ORDER BY kelas_id ASC")->execute($_GET['prodi'],$_GET['tahun_angkatan']);
							while($data_kelas = $db->database_fetch_array($sql_kelas)){
								echo "<option value=$data_kelas[kelas_id]>$data_kelas[nama_kelas] ($data_kelas[daya_tampung])</option>"; 
							}
							echo "</select></td>
						</tr>";
						$i++;
				}
				
			}
			echo "</tbody>
		</table>
		<p>&nbsp;</p><p>&nbsp;</p>
		<div>
			<button type='submit' class='btn btn-primary'><i class='icon-save'></i> Simpan</button>
		</div>
		</form>
	";
		
	break;
	
	case "all":
	$data_angkatan = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_angkatan WHERE angkatan_id = ?")->execute($_GET['tahun_angkatan']));
	$sql_prodi = $db->database_prepare("SELECT * FROM mspst WHERE IDPSTMSPST = ?")->execute($_GET['prodi']);
	$data_prodi = $db->database_fetch_array($sql_prodi);
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
		<a href='index.php?mod=bagi_kelas'><img src='../images/back.png'></a>
		<h5>Data Mahasiswa <br>
		Program Studi: $kd_jenjang_studi - $data_prodi[NMPSTMSPST], Th. Angkatan: $data_angkatan[tahun_angkatan]</h5>
		<table class='data display datatable' id='example'>
			<thead>
			<tr>
				<th width='30'>No</th>
				<th width='150'>NIM/NPM</th>
				<th width='250'>Nama</th>
				<th width='100'>Status</th>
				<th width='50'>JK</th>
				<th width='50'>Kelas</th>
				<th align='left'>Semester</th>
			</tr>
			</thead>
			<tbody>
			";
			$i = 1;
			$sql_mhs = $db->database_prepare("SELECT * FROM as_mahasiswa INNER JOIN as_kelas_mahasiswa ON as_kelas_mahasiswa.id_mhs=as_mahasiswa.id_mhs 
											INNER JOIN as_kelas ON as_kelas.kelas_id=as_kelas_mahasiswa.kelas_id WHERE as_mahasiswa.angkatan_id = ? AND as_mahasiswa.kode_program_studi = ? ORDER BY as_mahasiswa.id_mhs ASC")->execute($_GET['tahun_angkatan'],$_GET['prodi']);
			while ($data_mhs = $db->database_fetch_array($sql_mhs)){
				if ($data_mhs['status_mahasiswa'] == 'A'){
					$status = 'Aktif';
				}
				elseif ($data_mhs['status_mahasiswa'] == 'C'){
					$status = 'Cuti';
				}
				elseif ($data_mhs['status_mahasiswa'] == 'D'){
					$status = 'Drop-out';
				}
				elseif ($data_mhs['status_mahasiswa'] == 'L'){
					$status = 'Lulus';
				}
				elseif ($data_mhs['status_mahasiswa'] == 'K'){
					$status = 'Keluar';
				}
				elseif ($data_mhs['status_mahasiswa'] == 'N'){
					$status = 'Non-Aktif';
				}
				
				echo "<tr>
						<td>$i</td>
						<td>$data_mhs[NIM]</td>
						<td>$data_mhs[nama_mahasiswa]</td>
						<td>$status</td>
						<td>$data_mhs[jenis_kelamin]</td>
						<td>$data_mhs[nama_kelas]</td>
						<td>$data_mhs[semester_kelas]</td>
					</tr>";
				$i++;
			}
			echo "</tbody>
		</table>
	";
		
	break;
	
	case "detail":
	?>
	<p>&nbsp;</p>
	<a href="javascript:history.go(-1)"><img src="../images/back.png"></a>
	<p>&nbsp;</p>
	<h4>Daftar Program Studi</h4>
	<table id="example" class="display">
		<thead>
			<tr>
				<th>No</th>
				<th>Program Studi</th>
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
			elseif ($data_prodi['KDJENMSPST'] == 'J'){
				$kd_jenjang_studi = "Profesi";
			}
			echo "
			<tr>
				<td>$no</td>
				<td>$kd_jenjang_studi - $data_prodi[NMPSTMSPST]</td>
				<td><a href='?mod=kelas_prodi&act=detail&proid=$data_prodi[IDPSTMSPST]&angkatan_id=$_GET[id]'>Lihat</a></td>
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
		elseif ($dt_prodi['KDJENMSPST'] == 'J'){
			$kd_jenjang_studi = "Profesi";
		}
		echo "<p>&nbsp;</p>
				<h4>Data Kelas: $kd_jenjang_studi - $dt_prodi[NMPSTMSPST]<br>
				Th. Angkatan $data_ang[tahun_angkatan]</h4>
		";
		?><div>
				<a href="?mod=kelas_prodi&act=add&proid=<?php echo $_GET['proid']; ?>&angkatan_id=<?php echo $_GET['angkatan_id']; ?>"><button type='button' class='btn btn-primary'>+ Tambah Kelas</button></a>
			</div>
			<table id="example2" class="display">
				<thead>
					<tr>
						<th>No</th>
						<th>Kelas</th>
						<th>Semester</th>
						<th>Daya Tampung</th>
						<th>Status</th>
						<th>Aksi</th>
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
						<td>$data_kelas[semester]</td>
						<td>$data_kelas[daya_tampung]</td>
						<td>$status</td>
						<td><a href='?mod=kelas_prodi&act=edit&id=$data_kelas[kelas_id]&proid=$_GET[proid]&angkatan_id=$_GET[angkatan_id]'><img src='../images/edit.jpg' width='20'></a>";
						?>
						<a href="modul/mod_kelas/aksi_kelas.php?mod=kelas_prodi&act=delete&id=<?php echo $data_kelas[kelas_id];?>&proid=<?php echo $_GET['proid']; ?>&angkatan_id=<?php echo $_GET['angkatan_id']; ?>" onclick="return confirm('Anda Yakin ingin menghapus kelas <?php echo $data_kelas[nama_kelas];?>?');"><img src='../images/delete.jpg' width='20'></a>
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
	<p>&nbsp;</p>
	<h4>Tambah Kelas</h4>
	<div class="well">
		<form id="frm_kelas" action="modul/mod_kelas/aksi_kelas.php?mod=kelas_prodi&act=input" method="POST">
			<label>Program Studi</label>
				<b><?php echo $kd_jenjang_studi." - ".$dt_prodi['NMPSTMSPST']; ?></b><p></p><input type="hidden" name="proid" value="<?php echo $dt_prodi['IDPSTMSPST']; ?>">
			
			<label>Tahun Angkatan</label>
				<b><?php echo $data_ang['tahun_angkatan']; ?></b><p></p><input type="hidden" name="angkatan_id" value="<?php echo $data_ang['angkatan_id']; ?>">
			<label>Nama Kelas <font color="red">*</font></label>
				<input type="text" name="nama_kelas" class="required">
			<label>Semester <font color="red">*</font></label>
				<select name="semester" class="required">
					<option value=""></option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
				</select>
			<label>Daya Tampung <font color="red">*</font> <i>Daya tampung kursi / mahasiswa per kelas</i></label>
				<input type="text" name="daya_tampung" class="required">
			<label>Status <font color="red">*</font></label>
				<select name="aktif" class="required">
					<option value=""></option>
					<option value="A">Aktif</option>
					<option value="N">Non-Aktif</option>
				</select>		
		<br><br>	
		<div>
			<button type="submit" class="btn btn-primary"><i class="icon-save"></i> Simpan</button>
		</div>
		</form>
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
	elseif ($dt_prodi['KDJENMSPST'] == 'J'){
		$kd_jenjang_studi = "Profesi";
	}
?>
	<p>&nbsp;</p>
	<h4>Ubah Kelas</h4>
	<div class="well">
		<form id="frm_kelas" action="modul/mod_kelas/aksi_kelas.php?mod=kelas_prodi&act=update" method="POST">
			<input type="hidden" name="id" value="<?php echo $data_kelas['kelas_id']; ?>">
			<input type="hidden" name="proid" value="<?php echo $_GET['proid']; ?>">
			<input type="hidden" name="angkatan_id" value="<?php echo $_GET['angkatan_id']; ?>">
			<label>Program Studi</label>
				<b><?php echo $kd_jenjang_studi." - ".$dt_prodi['NMPSTMSPST']; ?></b><p></p><input type="hidden" name="proid" value="<?php echo $dt_prodi['IDPSTMSPST']; ?>">
			
			<label>Tahun Angkatan</label>
				<b><?php echo $data_ang['tahun_angkatan']; ?></b><p></p><input type="hidden" name="angkatan_id" value="<?php echo $data_ang['angkatan_id']; ?>">
			<label>Nama Kelas <font color="red">*</font></label>
				<input type="text" name="nama_kelas" class="required" value="<?php echo $data_kelas['nama_kelas']; ?>">
			<label>Semester <font color="red">*</font></label>
				<select name="semester" class="required">
					<option value=""></option>
					<option value="1" <?php if($data_kelas['semester'] == 1){ echo "SELECTED"; } ?>>1</option>
					<option value="2" <?php if($data_kelas['semester'] == 2){ echo "SELECTED"; } ?>>2</option>
					<option value="3" <?php if($data_kelas['semester'] == 3){ echo "SELECTED"; } ?>>3</option>
					<option value="4" <?php if($data_kelas['semester'] == 4){ echo "SELECTED"; } ?>>4</option>
					<option value="5" <?php if($data_kelas['semester'] == 5){ echo "SELECTED"; } ?>>5</option>
					<option value="6" <?php if($data_kelas['semester'] == 6){ echo "SELECTED"; } ?>>6</option>
					<option value="7" <?php if($data_kelas['semester'] == 7){ echo "SELECTED"; } ?>>7</option>
					<option value="8" <?php if($data_kelas['semester'] == 8){ echo "SELECTED"; } ?>>8</option>
				</select>
			<label>Daya Tampung <font color="red">*</font> <i>Daya tampung kursi / mahasiswa per kelas</i></label>
				<input type="text" name="daya_tampung" class="required" value="<?php echo $data_kelas['daya_tampung']; ?>">
			<label>Status <font color="red">*</font></label>
				<select name="aktif" class="required">
					<option value=""></option>
					<option value="A" <?php if($data_kelas['aktif'] == 'A'){ echo "SELECTED"; } ?>>Aktif</option>
					<option value="N" <?php if($data_kelas['aktif'] == 'N'){ echo "SELECTED"; } ?>>Non-Aktif</option>
				</select>		
		<br><br>	
		<div>
			<button type="submit" class="btn btn-primary"><i class="icon-save"></i> Simpan</button>
		</div>
		</form>
	</div>
	<?php
	break;
}
?>