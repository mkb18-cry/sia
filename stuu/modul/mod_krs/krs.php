<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>KRS baru berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>KRS berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>KRS berhasil dihapus.</p>
	</div>
<?php
}
?>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
		$('#frm_form').validate({
			rules:{
				nim: true
			},
			messages:{
				nim:{
					required: "Masukkan NIM/NPM terlebih dahulu."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h5>Masukkan NIM/NPM</h5>
	<div class="box round first fullpage">
		<div class="block ">
			<form action="" method="GET" id="frm_form">
			<input type="hidden" name="mod" value="krs">
			<input type="hidden" name="act" value="form">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>NIM Mahasiswa</label></td>
					<td><input type="text" name="nim" size="40" maxlength="15" class="required"></td>
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
	
	case "form":
	$sql_mhs = $db->database_prepare("SELECT * FROM as_mahasiswa INNER JOIN mspst ON mspst.IDPSTMSPST=as_mahasiswa.kode_program_studi 
									INNER JOIN as_kelas_mahasiswa ON as_kelas_mahasiswa.id_mhs=as_mahasiswa.id_mhs
									INNER JOIN as_kelas ON as_kelas.kelas_id=as_kelas_mahasiswa.kelas_id
									WHERE NIM = ? AND status_mahasiswa = 'A' ORDER BY kelas_mhs_id DESC LIMIT 1")->execute($_GET['nim']);
	$nums = $db->database_num_rows($sql_mhs);
	if ($nums == 0){
		echo "<p>&nbsp;</p><div class='well'>NIM/NPM Mahasiswa tidak ditemukan. <br><a href='javascript:history.go(-1)'>Back</a></div>";
	}
	else{
		$data_mhs = $db->database_fetch_array($sql_mhs);
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
		echo "<a href='index.php?mod=krs'><img src='../images/back.png'></a>
			<h5>Kartu Rencana Studi (KRS)</h5>
			<form method='POST' action='modul/mod_krs/aksi_krs.php?mod=krs&act=input'>
			<div class='box round first fullpage'>
				<div class='block '>
					<table class='form'>
						<tr valign='top'>
							<td width='200'><label>NIM</label></td>
							<td><b>$data_mhs[NIM] <input type='hidden' name='id_mhs' value='$data_mhs[id_mhs]'></b></td>
						</tr>
						<tr valign='top'>
							<td><label>Nama</label></td>
							<td><b>$data_mhs[nama_mahasiswa]</b></td>
						</tr>
						<tr valign='top'>
							<td><label>Program Studi</label></td>
							<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST]</b></td>
						</tr>
						<tr valign='top'>
							<td><label>Kelas</label></td>
							<td><b>$data_mhs[nama_kelas] - $data_mhs[semester] <input type='hidden' name='kelas_id' value='$data_mhs[kelas_id]'>
								<input type='hidden' name='semester' value='$data_mhs[semester]'></b>
							</td>
						</tr>
					</table>
				</div>
			</div>";
		
		echo "<table class='data display datatable' id='example'>
				<thead>
					<tr>
						<th width='30'>No</th>
						<th width='70'>Kode MK</th>
						<th width='140'>Nama MK</th>
						<th width='70'>Program</th>
						<th width='40'>SKS</th>
						<th width='40'>SMS</th>
						<th width='45'>Kelas</th>
						<th width='150'>Dosen</th>
						<th width='50'>Hari</th>
						<th width='75'>Jam Mulai</th>
						<th width='85'>Jam Selesai</th>
						<th>Ambil</th>
					</tr>
				</thead><tbody>";
		$i = 1;	
		$sql_krs = $db->database_prepare("SELECT * FROM as_jadwal_kuliah INNER JOIN as_makul ON as_makul.mata_kuliah_id=as_jadwal_kuliah.makul_id 
											INNER JOIN as_kelas ON as_kelas.kelas_id=as_jadwal_kuliah.kelas_id
											INNER JOIN msdos ON msdos.IDDOSMSDOS=as_jadwal_kuliah.dosen_id WHERE as_jadwal_kuliah.kelas_id = ?")->execute($data_mhs['kelas_id']);
		while ($data_krs = $db->database_fetch_array($sql_krs)){
			$nums = $db->database_num_rows($db->database_prepare("SELECT * FROM as_krs WHERE id_mhs=? AND jadwal_id=?")->execute($data_mhs["id_mhs"],$data_krs["jadwal_id"]));
			if ($data_krs['program'] == 'A'){
				$program = "Reguler";
			}
			else{
				$program = "Non-Reguler";
			}
			
			if ($data_krs['hari'] == 1){
				$hari = "Senin";
			}
			elseif ($data_krs['hari'] == 2){
				$hari = "Selasa";
			}
			elseif ($data_krs['hari'] == 3){
				$hari = "Rabu";
			}
			elseif ($data_krs['hari'] == 4){
				$hari = "Kamis";
			}
			elseif ($data_krs['hari'] == 5){
				$hari = "Jumat";
			}
			elseif ($data_krs['hari'] == 6){
				$hari = "Sabtu";
			}
			else{
				$hari = "Minggu";
			}
			if ($nums == 0){
				echo "<tr>
						<td>$i</td>
						<td>$data_krs[kode_mata_kuliah]</td>
						<td>$data_krs[nama_mata_kuliah_eng]</td>
						<td>$program</td>
						<td>$data_krs[sks_mata_kuliah]</td>
						<td>$data_krs[semester]</td>
						<td>$data_krs[nama_kelas]</td>
						<td>$data_krs[NMDOSMSDOS] $data_krs[GELARMSDOS]</td>
						<td>$hari</td>
						<td>$data_krs[jam_mulai]</td>
						<td>$data_krs[jam_selesai]</td>
						<td><input type='checkbox' name='ambil[]' value='$data_krs[jadwal_id]'></td>
					</tr>";
				}
			$i++;
		}
		echo "</tbody></table><p>&nbsp;</p><p>&nbsp;</p>
		<div>
			<button type='submit' class='btn btn-primary'>Ambil</button>
		</div></form>";
	}
	break;
	
	case "krs_detail":
	$sql_mhs = $db->database_prepare("SELECT * FROM as_mahasiswa INNER JOIN mspst ON mspst.IDPSTMSPST=as_mahasiswa.kode_program_studi 
									INNER JOIN as_kelas_mahasiswa ON as_kelas_mahasiswa.id_mhs=as_mahasiswa.id_mhs
									INNER JOIN as_kelas ON as_kelas.kelas_id=as_kelas_mahasiswa.kelas_id
									WHERE as_mahasiswa.id_mhs = ? AND status_mahasiswa = 'A' ORDER BY kelas_mhs_id DESC LIMIT 1")->execute($_GET['id_mhs']);
	$nums = $db->database_num_rows($sql_mhs);
	$data_mhs = $db->database_fetch_array($sql_mhs);
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
	echo "
		<h5>Kartu Rencana Studi (KRS)</h5>
		<div class='box round first fullpage'>
			<div class='block '>
			<table class='form'>
				<tr valign='top'>
					<td width='200'><label>NIM</label></td>
					<td><b>$data_mhs[NIM] </b></td>
				</tr>
				<tr valign='top'>
					<td><label>Nama</label></td>
					<td><b>$data_mhs[nama_mahasiswa]</b></td>
				</tr>
				<tr valign='top'>
					<td><label>Program Studi</label></td>
					<td><b>$kd_jenjang_studi - $data_mhs[NMPSTMSPST]</b></td>
				</tr>
				<tr valign='top'>
					<td valign='top'>Kelas</td>
					<td><b>$data_mhs[nama_kelas] - $data_mhs[semester] </b></td>
				</tr>
			</table>
			</div>
		</div>";
	
	echo "<table class='data display datatable' id='example'>
			<thead>
				<tr>
					<th width='30'>No</th>
					<th width='70'>Kode MK</th>
					<th width='170'>Nama MK</th>
					<th width='45'>SKS</th>
					<th width='45'>SMS</th>
					<th width='45'>Kelas</th>
					<th width='160'>Dosen</th>
					<th width='50'>Hari</th>
					<th width='90'>Jam Mulai</th>
					<th width='90'>Jam Selesai</th>
					<th>Hapus</th>
				</tr>
			</thead><tbody>";
	$i = 1;	
	$sql_krs = $db->database_prepare("SELECT * FROM as_krs A INNER JOIN as_jadwal_kuliah B ON A.jadwal_id=B.jadwal_id
										INNER JOIN as_makul C ON C.mata_kuliah_id=B.makul_id 
										INNER JOIN as_kelas D ON D.kelas_id=B.kelas_id
										INNER JOIN msdos E ON E.IDDOSMSDOS=B.dosen_id 
										WHERE B.kelas_id = ? AND A.id_mhs = ? AND B.semester = ?")->execute($_GET["kelas_id"],$_GET["id_mhs"],$_GET["semester"]);
	while ($data_krs = $db->database_fetch_array($sql_krs)){
		if ($data_krs['program'] == 'A'){
			$program = "Reguler";
		}
		else{
			$program = "Non-Reguler";
		}
		
		if ($data_krs['hari'] == 1){
			$hari = "Senin";
		}
		elseif ($data_krs['hari'] == 2){
			$hari = "Selasa";
		}
		elseif ($data_krs['hari'] == 3){
			$hari = "Rabu";
		}
		elseif ($data_krs['hari'] == 4){
			$hari = "Kamis";
		}
		elseif ($data_krs['hari'] == 5){
			$hari = "Jumat";
		}
		elseif ($data_krs['hari'] == 6){
			$hari = "Sabtu";
		}
		else{
			$hari = "Minggu";
		}
		echo "<tr>
				<td>$i</td>
				<td>$data_krs[kode_mata_kuliah]</td>
				<td>$data_krs[nama_mata_kuliah_eng]</td>
				<td>$data_krs[sks_mata_kuliah]</td>
				<td>$data_krs[semester]</td>
				<td>$data_krs[nama_kelas]</td>
				<td>$data_krs[NMDOSMSDOS] $data_krs[GELARMSDOS]</td>
				<td>$hari</td>
				<td>$data_krs[jam_mulai]</td>
				<td>$data_krs[jam_selesai]</td>
				<td>"; ?>
					<a title='Batalkan' href="modul/mod_krs/aksi_krs.php?mod=krs&act=delete&id=<?php echo $data_krs[krs_id];?>&id_mhs=<?php echo $_GET['id_mhs']; ?>&kelas_id=<?php echo $_GET['kelas_id']; ?>&semester=<?php echo $_GET['semester']; ?>" onclick="return confirm('Anda Yakin ingin membatalkan KRS MTK <?php echo $data_krs[nama_mata_kuliah_eng];?>?');"><img src='../images/delete.jpg' width='20'></a>
				<?php	
				echo "</td>
			</tr>";
		$i++;
	}
	echo "</tbody></table><p>&nbsp;</p><p>&nbsp;</p>";
	$tot_krs = $db->database_fetch_array($db->database_prepare("SELECT SUM(C.sks_mata_kuliah) as jumlah FROM as_krs A INNER JOIN as_jadwal_kuliah B ON A.jadwal_id=B.jadwal_id
										INNER JOIN as_makul C ON C.mata_kuliah_id=B.makul_id 
										INNER JOIN as_kelas D ON D.kelas_id=B.kelas_id
										INNER JOIN msdos E ON E.IDDOSMSDOS=B.dosen_id 
										WHERE B.kelas_id = ? AND A.id_mhs = ? AND B.semester = ?")->execute($_GET["kelas_id"],$_GET["id_mhs"],$_GET["semester"]));
	echo "<table class='form'>
		<tr>
			<td width='200'><label>TOTAL KESELURUHAN SKS AMBIL</label></td>
			<td><b>$tot_krs[jumlah] SKS</b></td>
		</tr>
	</table>
	<br>
	<div>
		<a href='modul/mod_krs/invoice.php?mod=krs&act=print&id_mhs=$_GET[id_mhs]&kelas_id=$_GET[kelas_id]&semester=$_GET[semester]' target='_blank'><button type='button' class='btn btn-primary'><i class='icon-print'></i> Cetak KRS</button></a>
		<a href='index.php?mod=krs'><button type='button' class='btn btn-primary'>Selesai/Keluar</button></a>
	</div>";
	
		/*<tr>
			<td><label>INDEX PRESTASI SEMESTER</label></td>
			<td><b></b></td>
		</tr>
		<tr>
			<td><label>MAKSMIMAL SKS YG DIAMBIL</label></td>
			<td><b></b></td>
		</tr>*/
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
	<p>&nbsp;</p>
	<p><a href="?mod=mhs"><img src="../images/back.png"></a></p>
	<h4>Tambah Mahasiswa</h4>
	<form id="frm_mahasiswa" action="modul/mod_mhs/aksi_mahasiswa.php?mod=mhs&act=input" method="POST" enctype="multipart/form-data">
	<br>
	
	<h5>Biodata</h5>
	<div class="well">
		<table width="100%">
			<tr valign="top">
				<td width="50%">
						<input type="hidden" name="kode_program_studi" value="<?php echo $_GET['prodi']; ?>">
					<label>Email <font color="red">*</font> <i>Isikan alamat email</i></label>
						<input type="text" name="email" size="40" maxlength="40" class="required">
					<label>Nama <font color="red">*</font></label>
						<input type="text" class="required" name="nama_mahasiswa" size="40" maxlength="30">
					<label>Inisial <i>Inisial dari user, misalnya AS untuk Agus Saputra</i></label>
						<input type="text" class="required" name="inisial" size="40" maxlength="30">
					<label>Tempat Lahir <font color="red">*</font></label>
						<input type="text" class="required" name="tempat_lahir" size="40" maxlength="20">
					<label>Nomor Telepon <i>No. Telp. Rumah</i></label>
						<input type="text" name="telepon" size="40" maxlength="20">
					<label>Nomor Handphone <i>No. Handphone</i></label>
						<input type="text" name="hp" size="40" maxlength="20">
					<label>Nomor KTP</label>
						<input type="text" name="ktp" size="40" maxlength="25">
					<label>Foto</label>
						<div id="me" class="styleall" style="cursor:pointer;">
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
				<td>
					<label>Tanggal Lahir <font color="red">*</font></label>
						<?php
						combotgl(1,31,'tgl_lahir',$tgl_skrg);
						combonamabln(1,12,'bln_lahir',$bln_sekarang);
						combothn(1940,$thn_sekarang,'thn_lahir',$thn_sekarang);
						?>
					<label>Agama <font color="red">*</font></label>
						<select name="agama" class="required">
							<option value=""></option>
							<option value="I">Islam</option>
							<option value="K">Kristen</option>
							<option value="C">Katolik</option>
							<option value="H">Hindu</option>
							<option value="B">Budha</option>
							<option value="G">Kong Hu Cu</option>
							<option value="L">Lainnya</option>
						</select>
					<label>Jenis Kelamin <font color="red">*</font></label>
						<select name="jenis_kelamin" class="required">
							<option value=""></option>
							<option value="L">Laki-Laki</option>
							<option value="P">Perempuan</option>
						</select>
					<label>Golongan Darah</label>
						<select name="darah">
							<option value=""></option>
							<option value="A">A</option>
							<option value="B">B</option>
							<option value="C">AB</option>
							<option value="O">O</option>
						</select>
					<label>Kewarganegaraan</label>
						<select name="negara">
							<option value=""></option>
							<option value="A">WNI</option>
							<option value="B">WNA</option>
						</select>
					<label>Status Perkawinan</label>
						<select name="kawin">
							<option value=""></option>
							<option value="A">Kawin</option>
							<option value="B">Belum Kawin</option>
							<option value="C">Janda/Duda</option>
						</select>
					<label>Gelar Depan</label>
							<input type="text" name="gelar_depan" size="40" maxlength="20">
					<label>Gelar Belakang</label>
						<input type="text" name="gelar_belakang" size="40" maxlength="20">
				</td>
			</tr>
			<tr valign="top">
				<td width="50%">
					<label>Alamat</label>
						<textarea name="alamat" cols="40" rows="3"></textarea>
				</td>
				<td>
					<label>Hobi</label>
						<textarea name="hobi" cols="40" rows="3"></textarea>
				</td>
			</tr>
		</table>
	</div>
	
	<br>
	<table width="100%">
		<tr valign="top">
			<td width="50%">
				<label>NPM <font color="red">*</font> <i>Nomor Pokok Mahasiswa</i></label>
					<input type="text" name="nim" size="40" maxlength="15" value="<?php echo $npm; ?>" disabled>
					<input type="hidden" name="nim" size="40" maxlength="15" value="<?php echo $npm; ?>">
				
					<!--<label>Jenjang Pendidikan <font color="red">*</font> <i>Jenjang Studi Mahasiswa</i></label>
						<select name="kode_jenjang_pendidikan" class="required">
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
						</select>-->
					<label>Program Kuliah <font color="red">*</font> <i>Program Kuliah Mahasiswa</i></label>
						<select name="kelas" class="required">
							<option value=""></option>
							<option value="R">Reguler</option>
							<option value="N">Non-Reguler</option>
						</select>
					<label>Status Mahasiswa</label>
						<select name="status_mahasiswa">
							<option value=""></option>
							<option value="A">Aktif</option>
							<option value="C">Cuti</option>
							<option value="D">Drop-out</option>
							<option value="L">Lulus</option>
							<option value="K">Keluar</option>
							<option value="N">Non-Aktif</option>
						</select>
					<label>Status Awal Mahasiswa</label>
						<select name="status_awal_mahasiswa">
							<option value=""></option>
							<option value="B">Baru</option>
							<option value="P">Pindahan</option>
						</select>
			</td>
			<td>
				<label>Angkatan <font color="red">*</font> <i>Angkatan Mahasiswa</i></label>
					<select name="angkatan_id" class="required">
						<option value=""></option>
						<?php 
						$sql_angkatan = $db->database_prepare("SELECT * FROM as_angkatan WHERE aktif = 'A' ORDER BY angkatan_id ASC")->execute();
						while ($data_angkatan = $db->database_fetch_array($sql_angkatan)){
							if ($data_angkatan['semester'] == 'A'){
								$semester = "Genap";
							}
							else{
								$semester = "Ganjil";
							}
							echo "<option value=$data_angkatan[angkatan_id]>($semester $data_angkatan[tahun_angkatan])</option>";
						}
						?>
					</select>
				<label>Semester Masuk <font color="red">*</font> <i>Semester pertama mahasiswa masuk, misalnya Genap atau Ganjil</i></label>
					<select name="semester_masuk" class="required">
						<option value=""></option>
						<option value="A">Genap</option>
						<option value="B">Ganjil</option>
					</select>
				<label>Tahun Masuk <font color="red">*</font> <i>Tahun Masuk Mahasiswa, merupakan tahun semester 1 mahasiswa</i></label>
					<input type="text" name="tahun_masuk" size="40" maxlength="4" class="required">
				<label>Tanggal Masuk Mahasiswa</label>
						<?php
						combotgl(1,31,'tgl_masuk_mhs',$tgl_skrg);
						combonamabln(1,12,'bln_masuk_mhs',$bln_sekarang);
						combothn(2000,$thn_sekarang,'thn_masuk_mhs',$thn_sekarang);
						?>
			</td>
		</tr>
	</table>
	
	<br>
	<h5>Kelulusan</h5>
	<div class="well">
		<table width="100%">
			<tr valign="top">
				<td width="50%">
					<label>NILUN <i>Nomor Induk Lulusan Nasional</i></label>
						<input type="text" name="nilun" size="40" maxlength="40">
					<label>Semester Lulus <font color="red">*</font> <i>Semester mahasiswa lulus, misalnya Genap atau Ganjil</i></label>
						<select name="semester_lulus">
							<option value=""></option>
							<option value="A">Genap</option>
							<option value="B">Ganjil</option>
						</select>
					<label>Tahun Lulus <i>Tahun mahasiswa lulus</i></label>
						<input type="text" name="tahun_lulus" size="40" maxlength="4">
					<label>Tanggal Lulus Mahasiswa</label>
						<?php
						combotgl(1,31,'tgl_lulus',$tgl_skrg);
						combonamabln(1,12,'bln_lulus',$bln_sekarang);
						combothn(2000,$thn_sekarang,'thn_lulus',$thn_sekarang);
						?><br>
						<input type="checkbox" name="centang_lulus" value="1" CHECKED> Hilangkan tanda centang jika ingin mengisi tanggal lulus mahasiswa<br><br>
					<label>Nomor Ijazah</label>
						<input type="text" name="no_seri_ijazah" size="40" maxlength="40">
					<label>Nomor SK Yudisium</label>
						<input type="text" name="no_sk_yudisium" size="40" maxlength="30">	
					<label>Tanggal SK Yudisium</label>
						<?php
						combotgl(1,31,'tgl_yudisium',$tgl_skrg);
						combonamabln(1,12,'bln_yudisium',$bln_sekarang);
						combothn(2000,$thn_sekarang,'thn_yudisium',$thn_sekarang);
						?><br>
						<input type="checkbox" name="centang_yudisium" value="1" CHECKED> Hilangkan tanda centang jika ingin mengisi tanggal yudisium<br><br>
					<label>Awal Bimbingan</label>
						<input type="text" name="awal_bimbingan" size="40" maxlength="6"> <br><i>Misalnya 052010 untuk Mei 2010, 062009 untuk Juni 2009</i><br><br>
					<label>Akhir Bimbingan</label>
						<input type="text" name="akhir_bimbingan" size="40" maxlength="6"> <br><i>Misalnya 052010 untuk Mei 2010, 062009 untuk Juni 2009</i>
				</td>
				<td>
					<label>Judul Skripsi</label>
						<textarea name="judul_skripsi" cols="40" rows="3"></textarea>
					<label>Jalur Skripsi</label>
						<select name="jalur_skripsi">
							<option value=""></option>
							<option value="1">Tugas Akhir/Skripsi</option>
							<option value="2">Student Project</option>
							<option value="3">Tesis</option>
							<option value="4">Disertasi</option>
						</select>
					<label>Penyusunan Skripsi</label>
						<select name="penyusunan_skripsi">
							<option value=""></option>
							<option value="I">Individu</option>
							<option value="K">Kelompok</option>
						</select>
					<label>NIDN Pembimbing 1</label>
						<input type="text" name="nidn_promotor1" size="40" maxlength="10">
					<label>NIDN Pembimbing 2</label>
						<input type="text" name="nidn_promotor2" size="40" maxlength="10">
					<label>NIDN Pembimbing 3</label>
						<input type="text" name="nidn_promotor3" size="40" maxlength="10">
					<label>NIDN Pembimbing 4</label>
						<input type="text" name="nidn_promotor4" size="40" maxlength="10">
				</td>
			</tr>
		</table>
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
	
	
	<div class="well">
		<div>
			<button type="submit" class="btn btn-primary"><i class="icon-save"></i> Simpan</button>
		</div>
	</div>
	</form>
	<?php
	break;
	
	case "edit":
	$data_mhs = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_mahasiswa WHERE id_mhs = ?")->execute($_GET["id"]));
?>	
	<p>&nbsp;</p>
	<p><a href="javascript:history.go(-1)"><img src="../images/back.png"></a></p>
	<h4>Ubah Data Mahasiswa</h4>
	<form id="frm_mahasiswa" action="modul/mod_mhs/aksi_mahasiswa.php?mod=mhs&act=update" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="program_studi" value="<?php echo $_GET['program_studi']; ?>">
	<input type="hidden" name="nim" value="<?php echo $_GET['nim']; ?>">
	<input type="hidden" name="id" value="<?php echo $data_mhs['id_mhs']; ?>">
	<div class="well">
		<table width="100%">
			<tr valign="top">
				<td width="50%">
					<label>Email <font color="red">*</font> <i>Isikan alamat email</i></label>
						<input type="text" name="email" size="40" maxlength="40" class="required" value="<?php echo $data_mhs['email']; ?>">
					<label>Nama <font color="red">*</font></label>
						<input type="text" class="required" name="nama_mahasiswa" size="40" maxlength="30" value="<?php echo $data_mhs['nama_mahasiswa']; ?>">
					<label>Inisial <i>Inisial dari user, misalnya AS untuk Agus Saputra</i></label>
						<input type="text" class="required" name="inisial" size="40" maxlength="30" value="<?php echo $data_mhs['inisial']; ?>">
					<label>Tempat Lahir <font color="red">*</font></label>
						<input type="text" class="required" name="tempat_lahir" size="40" maxlength="20" value="<?php echo $data_mhs['tempat_lahir']; ?>">
					<label>Nomor Telepon <i>No. Telp. Rumah</i></label>
						<input type="text" name="telepon" size="40" maxlength="20" value="<?php echo $data_mhs['telepon']; ?>">
					<label>Nomor Handphone <i>No. Handphone</i></label>
						<input type="text" name="hp" size="40" maxlength="20" value="<?php echo $data_mhs['hp']; ?>">
					<label>Nomor KTP</label>
						<input type="text" name="ktp" size="40" maxlength="25" value="<?php echo $data_mhs['ktp']; ?>">
					<label>Foto</label>
						<div id="me" class="styleall" style="cursor:pointer;">
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
				<td>
					<label>Tanggal Lahir <font color="red">*</font></label>
						<?php
						$get_tgl=substr("$data_mhs[tanggal_lahir]",8,2);
						combotgl(1,31,'tgl_lahir',$get_tgl);
						$get_bln=substr("$data_mhs[tanggal_lahir]",5,2);
						combonamabln(1,12,'bln_lahir',$get_bln);
						$get_thn=substr("$data_mhs[tanggal_lahir]",0,4);
						$thn_skrg=date("Y");
						combothn($thn_skrg-70,$thn_sekarang,'thn_lahir',$get_thn);
						?>
					<label>Agama <font color="red">*</font></label>
						<select name="agama" class="required">
							<option value=""></option>
							<option value="I" <?php if($data_mhs['agama'] == 'I'){ echo "SELECTED"; } ?>>Islam</option>
							<option value="K" <?php if($data_mhs['agama'] == 'K'){ echo "SELECTED"; } ?>>Kristen</option>
							<option value="C" <?php if($data_mhs['agama'] == 'C'){ echo "SELECTED"; } ?>>Katolik</option>
							<option value="H" <?php if($data_mhs['agama'] == 'H'){ echo "SELECTED"; } ?>>Hindu</option>
							<option value="B" <?php if($data_mhs['agama'] == 'B'){ echo "SELECTED"; } ?>>Budha</option>
							<option value="G" <?php if($data_mhs['agama'] == 'G'){ echo "SELECTED"; } ?>>Kong Hu Cu</option>
							<option value="L" <?php if($data_mhs['agama'] == 'L'){ echo "SELECTED"; } ?>>Lainnya</option>
						</select>
					<label>Jenis Kelamin <font color="red">*</font></label>
						<select name="jenis_kelamin" class="required">
							<option value=""></option>
							<option value="L" <?php if($data_mhs['jenis_kelamin'] == 'L'){ echo "SELECTED"; } ?>>Laki-Laki</option>
							<option value="P" <?php if($data_mhs['jenis_kelamin'] == 'P'){ echo "SELECTED"; } ?>>Perempuan</option>
						</select>
					<label>Golongan Darah</label>
						<select name="darah">
							<option value=""></option>
							<option value="A" <?php if($data_mhs['golongan_darah'] == 'A'){ echo "SELECTED"; } ?>>A</option>
							<option value="B" <?php if($data_mhs['golongan_darah'] == 'B'){ echo "SELECTED"; } ?>>B</option>
							<option value="C" <?php if($data_mhs['golongan_darah'] == 'C'){ echo "SELECTED"; } ?>>AB</option>
							<option value="O" <?php if($data_mhs['golongan_darah'] == 'O'){ echo "SELECTED"; } ?>>O</option>
						</select>
					<label>Kewarganegaraan</label>
						<select name="negara">
							<option value=""></option>
							<option value="A" <?php if($data_mhs['negara'] == 'A'){ echo "SELECTED"; } ?>>WNI</option>
							<option value="B" <?php if($data_mhs['negara'] == 'B'){ echo "SELECTED"; } ?>>WNA</option>
						</select>
					<label>Status Perkawinan</label>
						<select name="kawin">
							<option value=""></option>
							<option value="A" <?php if($data_mhs['status_kawin'] == 'A'){ echo "SELECTED"; } ?>>Kawin</option>
							<option value="B" <?php if($data_mhs['status_kawin'] == 'B'){ echo "SELECTED"; } ?>>Belum Kawin</option>
							<option value="C" <?php if($data_mhs['status_kawin'] == 'C'){ echo "SELECTED"; } ?>>Janda/Duda</option>
						</select>
					<label>Gelar Depan</label>
							<input type="text" name="gelar_depan" size="40" maxlength="20" value="<?php echo $data_mhs['gelar_depan']; ?>">
					<label>Gelar Belakang</label>
						<input type="text" name="gelar_belakang" size="40" maxlength="20" value="<?php echo $data_mhs['gelar_belakang']; ?>">
				</td>
			</tr>
			<tr valign="top">
				<td width="50%">
					<label>Alamat</label>
						<textarea name="alamat" cols="40" rows="3"><?php echo $data_mhs['alamat']; ?></textarea>
				</td>
				<td>
					<label>Hobi</label>
						<textarea name="hobi" cols="40" rows="3"><?php echo $data_mhs['hobi']; ?></textarea>
				</td>
			</tr>
		</table>
	</div>
	
	<br>
	<table width="100%">
		<tr valign="top">
			<td width="50%">
				<label>NPM <font color="red">*</font> <i>Nomor Pokok Mahasiswa</i></label>
					<input type="text" name="nim" size="40" maxlength="15" value="<?php echo $data_mhs['NIM']; ?>" disabled>
				
					<!--<label>Jenjang Pendidikan <font color="red">*</font> <i>Jenjang Studi Mahasiswa</i></label>
						<select name="kode_jenjang_pendidikan" class="required">
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
						</select>-->
					<label>Program Kuliah <font color="red">*</font> <i>Program Kuliah Mahasiswa</i></label>
						<select name="kelas" class="required">
							<option value=""></option>
							<option value="R" <?php if($data_mhs['Kelas'] == 'R'){ echo "SELECTED"; } ?>>Reguler</option>
							<option value="N" <?php if($data_mhs['Kelas'] == 'N'){ echo "SELECTED"; } ?>>Non-Reguler</option>
						</select>
					<label>Status Mahasiswa</label>
						<select name="status_mahasiswa">
							<option value=""></option>
							<option value="A" <?php if($data_mhs['status_mahasiswa'] == 'A'){ echo "SELECTED"; } ?>>Aktif</option>
							<option value="C" <?php if($data_mhs['status_mahasiswa'] == 'C'){ echo "SELECTED"; } ?>>Cuti</option>
							<option value="D" <?php if($data_mhs['status_mahasiswa'] == 'D'){ echo "SELECTED"; } ?>>Drop-out</option>
							<option value="L" <?php if($data_mhs['status_mahasiswa'] == 'L'){ echo "SELECTED"; } ?>>Lulus</option>
							<option value="K" <?php if($data_mhs['status_mahasiswa'] == 'K'){ echo "SELECTED"; } ?>>Keluar</option>
							<option value="N" <?php if($data_mhs['status_mahasiswa'] == 'N'){ echo "SELECTED"; } ?>>Non-Aktif</option>
						</select>
					<label>Status Awal Mahasiswa</label>
						<select name="status_awal_mahasiswa">
							<option value=""></option>
							<option value="B" <?php if($data_mhs['status_awal_mahasiswa'] == 'B'){ echo "SELECTED"; } ?>>Baru</option>
							<option value="P" <?php if($data_mhs['status_awal_mahasiswa'] == 'P'){ echo "SELECTED"; } ?>>Pindahan</option>
						</select>
			</td>
			<td>
				<label>Angkatan <font color="red">*</font> <i>Angkatan Mahasiswa</i></label>
					<select name="angkatan_id" class="required">
						<option value=""></option>
						<?php 
						$sql_angkatan = $db->database_prepare("SELECT * FROM as_angkatan WHERE aktif = 'A' ORDER BY angkatan_id ASC")->execute();
						while ($data_angkatan = $db->database_fetch_array($sql_angkatan)){
							if ($data_angkatan['semester'] == 'A'){
								$semester = "Genap";
							}
							else{
								$semester = "Ganjil";
							}
							
							if ($data_mhs['angkatan_id'] == $data_angkatan['angkatan_id']){
								echo "<option value=$data_angkatan[angkatan_id] SELECTED>($semester $data_angkatan[tahun_angkatan])</option>";
							}
							else{
								echo "<option value=$data_angkatan[angkatan_id]>($semester $data_angkatan[tahun_angkatan])</option>";
							}
						}
						?>
					</select>
				<label>Semester Masuk <font color="red">*</font> <i>Semester pertama mahasiswa masuk, misalnya Genap atau Ganjil</i></label>
					<select name="semester_masuk" class="required">
						<option value=""></option>
						<option value="A" <?php if($data_mhs['semester_masuk'] == 'A'){ echo "SELECTED"; } ?>>Genap</option>
						<option value="B" <?php if($data_mhs['semester_masuk'] == 'B'){ echo "SELECTED"; } ?>>Ganjil</option>
					</select>
				<label>Tahun Masuk <font color="red">*</font> <i>Tahun Masuk Mahasiswa, merupakan tahun semester 1 mahasiswa</i></label>
					<input type="text" name="tahun_masuk" size="40" maxlength="4" class="required" value="<?php echo $data_mhs['tahun_masuk']; ?>">
				<label>Tanggal Masuk Mahasiswa</label>
						<?php
						$get_tgl=substr("$data_mhs[tanggal_masuk]",8,2);
						combotgl(1,31,'tgl_masuk_mhs',$get_tgl);
						$get_bln=substr("$data_mhs[tanggal_masuk]",5,2);
						combonamabln(1,12,'bln_masuk_mhs',$get_bln);
						$get_thn=substr("$data_mhs[tanggal_masuk]",0,4);
						$thn_skrg=date("Y");
						combothn(2000,$thn_sekarang,'thn_masuk_mhs',$get_thn);
						?>
			</td>
		</tr>
	</table>
	
	<br>
	<h5>Kelulusan</h5>
	<div class="well">
		<table width="100%">
			<tr valign="top">
				<td width="50%">
					<label>NILUN <i>Nomor Induk Lulusan Nasional</i></label>
						<input type="text" name="nilun" size="40" maxlength="40" value="<?php echo $data_mhs['nilun']; ?>">
					<label>Semester Lulus <font color="red">*</font> <i>Semester mahasiswa lulus, misalnya Genap atau Ganjil</i></label>
						<select name="semester_lulus">
							<option value=""></option>
							<option value="A" <?php if($data_mhs['semester_lulus'] == 'A'){ echo "SELECTED"; } ?>>Genap</option>
							<option value="B" <?php if($data_mhs['semester_lulus'] == 'B'){ echo "SELECTED"; } ?>>Ganjil</option>
						</select>
					<label>Tahun Lulus <i>Tahun mahasiswa lulus</i></label>
						<input type="text" name="tahun_lulus" size="40" maxlength="4" value="<?php echo $data_mhs['tahun_lulus']; ?>">
					<label>Tanggal Lulus Mahasiswa</label>
						<?php
						$get_tgl=substr("$data_mhs[tanggal_lulus]",8,2);
						combotgl(1,31,'tgl_lulus',$get_tgl);
						$get_bln=substr("$data_mhs[tanggal_lulus]",5,2);
						combonamabln(1,12,'bln_lulus',$get_bln);
						$get_thn=substr("$data_mhs[tanggal_lulus]",0,4);
						$thn_skrg=date("Y");
						combothn(2000,$thn_sekarang,'thn_lulus',$get_thn);
						?><br>
						<input type="checkbox" name="centang_lulus" value="1" CHECKED> Hilangkan tanda centang jika ingin mengubah tanggal lulus mahasiswa<br><br>
					<label>Nomor Ijazah</label>
						<input type="text" name="no_seri_ijazah" size="40" maxlength="40" value="<?php echo $data_mhs['nomor_seri_ijazah']; ?>">
					<label>Nomor SK Yudisium</label>
						<input type="text" name="no_sk_yudisium" size="40" maxlength="30" value="<?php echo $data_mhs['nomor_sk_yudisium']; ?>">	
					<label>Tanggal SK Yudisium</label>
						<?php
						$get_tgl=substr("$data_mhs[tanggal_sk_yudisium]",8,2);
						combotgl(1,31,'tgl_yudisium',$get_tgl);
						$get_bln=substr("$data_mhs[tanggal_sk_yudisium]",5,2);
						combonamabln(1,12,'bln_yudisium',$get_bln);
						$get_thn=substr("$data_mhs[tanggal_sk_yudisium]",0,4);
						$thn_skrg=date("Y");
						combothn(2000,$thn_sekarang,'thn_yudisium',$get_thn);
						?><br>
						<input type="checkbox" name="centang_yudisium" value="1" CHECKED> Hilangkan tanda centang jika ingin mengubah tanggal yudisium<br><br>
					<label>Awal Bimbingan</label>
						<input type="text" name="awal_bimbingan" size="40" maxlength="6" value="<?php echo $data_mhs['awal_bimbingan']; ?>"> <br><i>Misalnya 052010 untuk Mei 2010, 062009 untuk Juni 2009</i><br><br>
					<label>Akhir Bimbingan</label>
						<input type="text" name="akhir_bimbingan" size="40" maxlength="6" value="<?php echo $data_mhs['akhir_bimbingan']; ?>"> <br><i>Misalnya 052010 untuk Mei 2010, 062009 untuk Juni 2009</i>
				</td>
				<td>
					<label>Judul Skripsi</label>
						<textarea name="judul_skripsi" cols="40" rows="3"><?php echo $data_mhs['judul_skripsi']; ?></textarea>
					<label>Jalur Skripsi</label>
						<select name="jalur_skripsi">
							<option value=""></option>
							<option value="1" <?php if($data_mhs['jalur_skripsi'] == '1'){ echo "SELECTED"; } ?>>Tugas Akhir/Skripsi</option>
							<option value="2" <?php if($data_mhs['jalur_skripsi'] == '2'){ echo "SELECTED"; } ?>>Student Project</option>
							<option value="3" <?php if($data_mhs['jalur_skripsi'] == '3'){ echo "SELECTED"; } ?>>Tesis</option>
							<option value="4" <?php if($data_mhs['jalur_skripsi'] == '4'){ echo "SELECTED"; } ?>>Disertasi</option>
						</select>
					<label>Penyusunan Skripsi</label>
						<select name="penyusunan_skripsi">
							<option value=""></option>
							<option value="I" <?php if($data_mhs['penyusunan_skripsi'] == 'I'){ echo "SELECTED"; } ?>>Individu</option>
							<option value="K" <?php if($data_mhs['penyusunan_skripsi'] == 'K'){ echo "SELECTED"; } ?>>Kelompok</option>
						</select>
					<label>NIDN Pembimbing 1</label>
						<input type="text" name="nidn_promotor1" size="40" maxlength="10" value="<?php echo $data_mhs['NIDN_kopromotor1']; ?>">
					<label>NIDN Pembimbing 2</label>
						<input type="text" name="nidn_promotor2" size="40" maxlength="10" value="<?php echo $data_mhs['NIDN_kopromotor2']; ?>">
					<label>NIDN Pembimbing 3</label>
						<input type="text" name="nidn_promotor3" size="40" maxlength="10" value="<?php echo $data_mhs['NIDN_kopromotor3']; ?>">
					<label>NIDN Pembimbing 4</label>
						<input type="text" name="nidn_promotor4" size="40" maxlength="10" value="<?php echo $data_mhs['NIDN_kopromotor4']; ?>">
				</td>
			</tr>
		</table>
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
	
	<div class="well">
		<button type="submit" class="btn btn-primary"><i class="icon-save"></i> Simpan Perubahan</button>
	</div>
	</form>
<?php
break;
}
?>