<style>
	.error {
		font-size:small; 
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		border-radius: 4px;
  		border-color: #eed3d7;
  		color: #b94a48; 
	}
</style>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
		$('#frm_password').validate({
			rules:{
				pass_lama: true,
				pass_baru: true,
				pass_baru2: true
			},
			messages:{
				pass_lama:{
					required: "Masukkan password lama Anda."
				},
				pass_baru:{
					required: "Masukkan password baru."
				},
				pass_baru2:{
					required: "Masukkan ulang password baru."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
	
	if ($_SESSION['level'] == 'dos'){
		$data_profil = $db->database_fetch_array($db->database_prepare("SELECT * FROM msdos WHERE IDDOSMSDOS = ?")->execute($_SESSION["useri"]));
	}
	else{
		$data_profil = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_users WHERE user_id = ?")->execute($_SESSION["userid"]));
		if ($data_profil['level'] == 1){
			$level = "Administrator";
		}
		elseif ($data_profil['level'] == 2){
			$level = "Keuangan";
		}
		elseif ($data_profil['level'] == 3){
			$level = "Perpustakaan";
		}
		elseif ($data_profil['level'] == 4){
			$level = "Staff BAAK";
		}
		else{
			$level = "Owner";
		}
		
		if ($data_profil['aktif'] == 'Y'){
			$status = "Aktif";
		}
		else{
			$status = "Non-aktif";
		}
?>
		<p>&nbsp;</p>
		<h4>Data Profil</h4>
		<div class='well'>
			<table>
				<tr>
					<td width="100">NIP/NID</td>
					<td width="10">:</td>
					<td><b><?php echo $data_profil['nip']; ?></b></td>
				</tr>
				<tr>
					<td>Nama Lengkap</td>
					<td>:</td>
					<td><b><?php echo $data_profil['nama_lengkap']; ?></b></td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>:</td>
					<td><b><?php echo $data_profil['alamat']; ?></b></td>
				</tr>
				<tr>
					<td>Level</td>
					<td>:</td>
					<td><b><?php echo $level; ?></b></td>
				</tr>
				<tr>
					<td>Jenis Kelamin</td>
					<td>:</td>
					<td><b><?php echo $data_profil['jenis_kelamin']; ?></b></td>
				</tr>
				<tr>
					<td>Telepon/Hp</td>
					<td>:</td>
					<td><b><?php echo $data_profil['telepon']; ?> / <?php echo $data_profil['hp']; ?></b></td>
				</tr>
				<tr>
					<td>Email</td>
					<td>:</td>
					<td><b><?php echo $data_profil['email']; ?></b></td>
				</tr>
				<tr>
					<td>Status / Blokir</td>
					<td>:</td>
					<td><b><?php echo $status; ?> / <?php echo $data_profil['blokir']; ?></b></td>
				</tr>
			</table>
		</div>
<?php
	}
	break;
}
?>