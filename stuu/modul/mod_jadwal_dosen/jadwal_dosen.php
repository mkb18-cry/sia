<script type='text/javascript' src='../js/jquery.validate.js'></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.autocomplete.css" />
<script type="text/javascript" src="../js/jquery.autocomplete.js"></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
		$('#frm_form').validate({
			rules:{
				nid: true
			},
			messages:{
				nid:{
					required: "Masukkan Nomor Induk Dosen terlebih dahulu."
				}
			}
		});
		
		$("#getnid").autocomplete("modul/mod_jadwal_dosen/getnid.php", {
			selectFirst: true
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h5>Masukkan NID/NIP Dosen</h5>
	<div class='box round first fullpage'>
		<div class='block '>
			<form action="" method="GET" id="frm_form">
			<input type="hidden" name="mod" value="jadwal_dosen">
			<input type="hidden" name="act" value="form">
			<table class='form'>
				<tr valign="top">
					<td width="150"><label>NID Dosen</label></td>
					<td><input type="text" name="nid" size="40" id="getnid" class="required"></td>
				</tr>
				<tr valign='top'>
					<td></td>
					<td><button type="submit" class="btn btn-primary">Lihat Jadwal</button></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
<?php

	break;
	
	case "form":
	$n = explode("-", $_GET['nid']);
	$nid = $n[0];
	$sql_dosen = $db->database_prepare("SELECT * FROM msdos WHERE NODOSMSDOS = ?")->execute($nid);
	$nums = $db->database_num_rows($sql_dosen);
	if ($nums == 0){
		echo "<p>&nbsp;</p><div class='well'>NID/NIP Dosen tidak ditemukan. <br><a href='javascript:history.go(-1)'>Back</a></div>";
	}
	else{
		$data_dosen = $db->database_fetch_array($sql_dosen);
		
		echo "<a href='index.php?mod=jadwal_dosen'><img src='../images/back.png'></a>
			<h5>Jadwal Dosen</h5>
			<div class='box round first fullpage'>
				<div class='block '>
				<table class='form'>
					<tr valign='top'>
						<td width='100'>NID</td>
						<td width='5'>:</td>
						<td><b>$data_dosen[NODOSMSDOS] <input type='hidden' name='id_dosen' value='$data_dosen[IDDOSMSDOS]'></b></td>
					</tr>
					<tr valign='top'>
						<td>Nama Dosen</td>
						<td>:</td>
						<td><b>$data_dosen[NMDOSMSDOS] $data_dosen[GELARMSDOS]</b></td>
					</tr>
				</table>
				</div>
			</div>";
		
		echo "
			<table class='data display datatable' id='example'>
				<thead>
					<tr>
						<th width='30'>No</th>
						<th width='80'>Hari</th>
						<th width='80'>Jam</th>
						<th width='200'>Program Studi</th>
						<th width='200'>Kode MK / MK</th>
						<th width='100'>Ruang</th>
						<th width='100'>Th. Angkatan</th>
						<th width='50'>Sms</th>
						<th>Kelas</th>
					</tr>
				</thead><tbody>";
		$i = 1;	
		$sql_jadwal = $db->database_prepare("SELECT * FROM as_jadwal_kuliah INNER JOIN as_makul ON as_makul.mata_kuliah_id=as_jadwal_kuliah.makul_id 
											INNER JOIN as_kelas ON as_kelas.kelas_id=as_jadwal_kuliah.kelas_id
											INNER JOIN as_ruang ON as_ruang.ruang_id=as_jadwal_kuliah.ruang_id
											INNER JOIN as_angkatan ON as_angkatan.angkatan_id=as_kelas.angkatan_id
											INNER JOIN mspst ON mspst.IDPSTMSPST=as_kelas.prodi_id
											INNER JOIN msdos ON msdos.IDDOSMSDOS=as_jadwal_kuliah.dosen_id
											WHERE as_jadwal_kuliah.dosen_id = ? AND as_kelas.aktif = 'A' ORDER BY as_jadwal_kuliah.jadwal_id DESC")->execute($data_dosen['IDDOSMSDOS']);
		while ($data_jadwal = $db->database_fetch_array($sql_jadwal)){
			if ($data_jadwal['hari'] == 1){
				$hari = "Senin";
			}
			elseif ($data_jadwal['hari'] == 2){
				$hari = "Selasa";
			}
			elseif ($data_jadwal['hari'] == 3){
				$hari = "Rabu";
			}
			elseif ($data_jadwal['hari'] == 4){
				$hari = "Kamis";
			}
			elseif ($data_jadwal['hari'] == 5){
				$hari = "Jumat";
			}
			elseif ($data_jadwal['hari'] == 6){
				$hari = "Sabtu";
			}
			else{
				$hari = "Minggu";
			}
			
			if ($data_jadwal['KDJENMSPST'] == 'A'){
				$kd_jenjang_studi = "S3";
			}
			elseif ($data_jadwal['KDJENMSPST'] == 'B'){
				$kd_jenjang_studi = "S2";
			}
			elseif ($data_jadwal['KDJENMSPST'] == 'C'){
				$kd_jenjang_studi = "S1";
			}
			elseif ($data_jadwal['KDJENMSPST'] == 'D'){
				$kd_jenjang_studi = "D4";
			}
			elseif ($data_jadwal['KDJENMSPST'] == 'E'){
				$kd_jenjang_studi = "D3";
			}
			elseif ($data_jadwal['KDJENMSPST'] == 'F'){
				$kd_jenjang_studi = "D2";
			}
			elseif ($data_jadwal['KDJENMSPST'] == 'G'){
				$kd_jenjang_studi = "D1";
			}
			elseif ($data_jadwal['KDJENMSPST'] == 'H'){
				$kd_jenjang_studi = "Sp-1";
			}
			elseif ($data_jadwal['KDJENMSPST'] == 'I'){
				$kd_jenjang_studi = "Sp-2";
			}
			else{
				$kd_jenjang_studi = "Profesi";
			}
			
			echo "<tr>
					<td>$i</td>
					<td>$hari</td>
					<td>$data_jadwal[jam_mulai] - $data_jadwal[jam_selesai]</td>
					<td>$kd_jenjang_studi - $data_jadwal[NMPSTMSPST]</td>
					<td>$data_jadwal[kode_mata_kuliah] / $data_jadwal[nama_mata_kuliah_eng]</td>
					<td>$data_jadwal[nama_ruang]</td>
					<td>$data_jadwal[tahun_angkatan]</td>
					<td>$data_jadwal[semester]</td>
					<td>$data_jadwal[nama_kelas]</td>
				</tr>";
			$i++;
		}
		echo "</tbody></table>";
	}
	break;
}
?>