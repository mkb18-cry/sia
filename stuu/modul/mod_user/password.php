<?php 
if ($_GET['code'] == 1){
?>
	<div class='message error'>
		<h5>Failed!</h5>
		<p>Password lama Anda salah.</p>
	</div>
<?php
}
if ($_GET['code'] == 2){
?>
	<div class='message error'>
		<h5>Failed!</h5>
		<p>Password Baru dan Re-type password tidak cocok.</p>
	</div>
<?php
}
if ($_GET['code'] == 3){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Password berhasil diubah.</p>
	</div>
<?php
}
?>
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
?>
	<h5>Ubah Password</h5>
	<div class="box round first fullpage">
		<div class="block ">
		<form method="POST" action="modul/mod_user/aksi_password.php?mod=ubah_password" id="frm_password">
		<table class="form">
			<tr valign="top">
				<td width="200"><label>Password Lama</label></td>
				<td><input type="password" name="pass_lama" class="required"></td>
			</tr>
			<tr valign="top">
				<td><label>Password Baru</label></td>
				<td><input type="password" name="pass_baru" class="required"></td>
			</tr>
			<tr valign="top">
				<td><label>Ketikkan Ulang Password Baru</label></td>
				<td><input type="password" name="pass_baru2" class="required"></td>
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