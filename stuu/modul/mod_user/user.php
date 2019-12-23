<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Pengguna Baru berhasil disimpan.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Pengguna berhasil diubah.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Pengguna berhasil dihapus.</p>
	</div>
<?php
}
?>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
		$('#frm_user').validate({
			rules:{
				nip: true,
				nama_lengkap: true,
				level: true,
				level_jabatan: true,
				email: true,
				aktif: true,
				blokir: true
			},
			messages:{
				nip:{
					required: "Nomor Induk Pegawai Wajib Diisi."
				},
				nama_lengkap:{
					required: "Nama Lengkap Wajib Diisi."
				},
				level:{
					required: "Level Pengguna Wajib Diisi."
				},
				level_jabatan:{
					required: "Level Jabatan Pengguna di Divisi Wajib Diisi."
				},
				email:{
					required: "Email Pengguna Wajib Diisi."
				},
				aktif:{
					required: "Status Pengguna Wajib Diisi."
				},
				blokir:{
					required: "Status Blokir Wajib Diisi."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h4>Master Data Pengguna</h4><br>
	<div>
		<a href="?mod=user&act=add"><button type="button" class="btn btn-green">+ Tambah Pengguna</button></a>
	</div>
	<br>		
	<table class="data display datatable" id="example">
	<thead>
		<tr>
			<th>No</th>
			<th>NIP</th>
			<th>Nama Lengkap</th>
			<th>Level</th>
			<th>Email</th>
			<th>Status</th>
			<th>Blokir</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$no = 1;
	$sql_user = $db->database_prepare("SELECT * FROM as_users A WHERE user_id != 1 ORDER BY nip,nama_lengkap ASC")->execute();
	while ($data_user = $db->database_fetch_array($sql_user)){
		if ($data_user['level'] == 1){
			$level2 = "Administrator";
		}
		elseif ($data_user['level'] == 2){
			$level2 = "Keuangan";
		}
		elseif ($data_user['level'] == 3){
			$level2 = "Perpustakaan";
		}
		elseif ($data_user['level'] == 4){
			$level2 = "BAAK";
		}
		else{
			$level2 = "Owner";
		}
		echo "
		<tr>
			<td>$no</td>
			<td>$data_user[nip]</td>
			<td>$data_user[nama_lengkap]</td>
			<td>$level2</td>
			<td>$data_user[email]</td>
			<td>$data_user[aktif]</td>
			<td>$data_user[blokir]</td>
			<td><a title='Ubah' href='?mod=user&act=edit&id=$data_user[user_id]'><img src='../images/edit.jpg' width='20'></a>";
			?>
				<a title='Hapus' href="modul/mod_user/aksi_user.php?mod=user&act=delete&id=<?php echo $data_user[user_id];?>" onclick="return confirm('Anda Yakin ingin menghapus pengguna <?php echo $data_user[nama_lengkap];?>?');"><img src='../images/delete.jpg' width='20'></a>
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
	<p><a href="?mod=user"><img src="../images/back.png"></a></p>
	<h4>Tambah Pengguna</h4>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_user" action="modul/mod_user/aksi_user.php?mod=user&act=input" method="POST">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>NIP <font color="red">*</font> <i>Nomor Induk Pegawai</i></label></td>
					<td><input type="text" class="required" name="nip" size="40" maxlength="15"></td>
				</tr>
				<tr valign="top">
					<td><label>Nama Lengkap <font color="red">*</font> <i>Nama lengkap pengguna</i></label></td>
					<td><input type="text" class="required" name="nama_lengkap" size="40" maxlength="40"></td>
				</tr>
				<tr valign="top">
					<td><label>Nama Panggilan <i>Nama panggilan pengguna</i></label></td>
					<td><input type="text" name="nama_panggil" size="40" maxlength="40"></td>
				</tr>
				<tr valign="top">
					<td><label>Alamat</label></td>
					<td><textarea name="alamat" cols="40" rows="3"></textarea></td>
				</tr>
				<tr valign="top">
					<td><label>Jenis Kelamin</label></td>
					<td><select name="jenis_kelamin">
							<option value="">- none -</option>
							<option value="L">Laki-Laki</option>
							<option value="P">Perempuan</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Email <font color="red">*</font> <i>Akan digunakan sebagai username</i></label></td>
					<td><input type="text" name="email" size="40" maxlength="40"></td>
				</tr>
				<tr valign="top">
					<td><label>Level Divisi Pengguna</label></td>
					<td><select name="level" class="required">
							<option value="">- none -</option>
							<option value="1">Administrator</option>
							<option value="2">Keuangan</option>
							<!--<option value="3">Perpustakaan</option>-->
							<option value="4">Staff BAAK</option>
							<option value="5">Owner</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Level Pengguna di Divisi</label></td>
					<td><select name="level_jabatan" class="required">
							<option value="">- none -</option>
							<option value="1">Administrator</option>
							<option value="2">Staff</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Telepon</label></td>
					<td><input type="text" name="telepon" size="40" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>Handphone</label></td>
					<td><input type="text" name="hp" size="40" maxlength="20"></td>
				</tr>
				<tr valign="top">
					<td><label>Aktif</label></td>
					<td><select name="aktif">
							<option value="">- none -</option>
							<option value="Y" SELECTED>Aktif</option>
							<option value="N">Tidak Aktif</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Blokir</label></td>
					<td><select name="blokir">
							<option value="">- none -</option>
							<option value="Y">Ya</option>
							<option value="N" SELECTED>Tidak</option>
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
	$data_user = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_users WHERE user_id = ?")->execute($_GET["id"]));
?>	
	<p><a href="?mod=user"><img src="../images/back.png"></a></p>
	<h4>Ubah Data Pengguna</h4>
	<div class="box round first fullpage">
		<div class="block ">
			<form id="frm_user" action="modul/mod_user/aksi_user.php?mod=user&act=update" method="POST">
			<input type="hidden" name="id" value="<?php echo $data_user['user_id']; ?>">
			<table class="form">
				<tr valign="top">
					<td width="200"><label>NIP <font color="red">*</font> <i>Nomor Induk Pegawai</i></label></td>
					<td class="col2"><input type="text" class="required" name="nip" size="40" maxlength="15" value="<?php echo $data_user['nip']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Nama Lengkap <font color="red">*</font> <i>Nama lengkap pengguna</i></label></td>
					<td><input type="text" class="required" name="nama_lengkap" size="40" maxlength="40" value="<?php echo $data_user['nama_lengkap']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Nama Panggilan <i>Nama panggilan pengguna</i></label></td>
					<td><input type="text" name="nama_panggil" size="40" maxlength="40" value="<?php echo $data_user['nama_panggil']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Alamat</label></td>
					<td><textarea name="alamat" cols="40" rows="3"><?php echo $data_user['alamat']; ?></textarea></td>
				</tr>
				<tr valign="top">
					<td><label>Jenis Kelamin</label></td>
					<td><select name="jenis_kelamin">
							<option value="L" <?php if($data_user['jenis_kelamin'] == 'L'){ echo "SELECTED"; } ?>>Laki-Laki</option>
							<option value="P" <?php if($data_user['jenis_kelamin'] == 'P'){ echo "SELECTED"; } ?>>Perempuan</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Email <font color="red">*</font> <i>Akan digunakan sebagai username</i></label></td>
					<td><input type="text" name="email" size="40" maxlength="40" value="<?php echo $data_user['email']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Level Divisi Pengguna</label></td>
					<td><select name="level" class="required">
							<option value="1" <?php if($data_user['level'] == '1'){ echo "SELECTED"; } ?>>Administrator</option>
							<option value="2" <?php if($data_user['level'] == '2'){ echo "SELECTED"; } ?>>Keuangan</option>
							<!--<option value="3" <?php if($data_user['level'] == '3'){ echo "SELECTED"; } ?>>Perpustakaan</option>-->
							<option value="4" <?php if($data_user['level'] == '4'){ echo "SELECTED"; } ?>>Staff BAAK</option>
							<option value="5" <?php if($data_user['level'] == '5'){ echo "SELECTED"; } ?>>Owner</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Level Pengguna di Divisi</label></td>
					<td><select name="level_jabatan" class="required">
							<option value="1" <?php if($data_user['level_jabatan'] == '1'){ echo "SELECTED"; } ?>>Administrator</option>
							<option value="2" <?php if($data_user['level_jabatan'] == '2'){ echo "SELECTED"; } ?>>Staff</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Telepon</label></td>
					<td><input type="text" name="telepon" size="40" maxlength="20" value="<?php echo $data_user['telepon']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Handphone</label></td>
					<td><input type="text" name="hp" size="40" maxlength="20" value="<?php echo $data_user['hp']; ?>"></td>
				</tr>
				<tr valign="top">
					<td><label>Aktif</label></td>
					<td><select name="aktif">
							<option value="Y" <?php if($data_user['aktif'] == 'Y'){ echo "SELECTED"; } ?>>Aktif</option>
							<option value="N" <?php if($data_user['aktif'] == 'N'){ echo "SELECTED"; } ?>>Tidak Aktif</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td><label>Blokir</label></td>
					<td><select name="blokir">
							<option value="Y" <?php if($data_user['blokir'] == 'Y'){ echo "SELECTED"; } ?>>Ya</option>
							<option value="N" <?php if($data_user['blokir'] == 'N'){ echo "SELECTED"; } ?>>Tidak</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<td></td>
					<td><button type="submit" class="btn btn-primary"><i class="icon-save"></i> Simpan Perubahan</button></td>
				</tr>
			</table>
		</div>
	</div>
	<?php
	break;
}
?>