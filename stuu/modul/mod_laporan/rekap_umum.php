<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
		$( "#datepicker1" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: '2013:c-0'
		});
		
		$( "#datepicker2" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: '2013:c-0'
		});
		
		$("#prodi").change(function(){
			var prodi = $("#prodi").val();
			$.ajax({
				url: "modul/mod_laporan/ambilkelas.php",
				data: "prodi="+prodi,
				cache: false,
				success: function(msg){
					$("#kelas").html(msg);
				}
			});
		});
		
		$('#frm_bayar').validate({
			rules:{
				awal: true,
				akhir: true
			},
			messages:{
				awal:{
					required: "Periode awal wajib diisi."
				},
				akhir:{
					required: "Periode akhir wajib diisi."
				}
			}
		});
	});
</script>

<?php
switch($_GET['act']){
	default:
?>
	<h5>Rekapitulasi Pembayaran Umum</h5>
	<div class="box round first fullpage">
		<div class="block ">
		<form method="GET" action="" id="frm_bayar">
		<input type="hidden" name="mod" value="lap_rekap_umum">
		<input type="hidden" name="act" value="detail">
		<table class="form">
			<tr valign="top">
				<td width="100"><label>Program Studi</label></td>
				<td width="10">:</td>
				<td>
					<select name="prodi" class="required" id='prodi'>
						<option value="">- Pilih Program Studi -</option>
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
			<td><label>Kelas</label></td>
			<td>:</td>
			<td>
				<select name='kelas' id='kelas'>
					<option value=''></option>
				</select>
			</td>
		</tr>
		</table>
		<button type="submit" class="btn btn-primary">Buka Laporan</button>
		</form>
	</div></div>
<?php

	break;
	
	case "detail":
	$kelas = explode("*", $_GET['kelas']);
	$data_prodi = $db->database_fetch_array($db->database_prepare("SELECT KDJENMSPST, NMPSTMSPST, fakultas FROM mspst INNER JOIN msfks ON msfks.fakultas_id = mspst.fakultas_id WHERE IDPSTMSPST = ?")->execute($_GET["prodi"]));
	$data_kelas = $db->database_fetch_array($db->database_prepare("SELECT * FROM as_kelas WHERE kelas_id = ?")->execute($kelas[0]));
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
	
	$tanggal_awal = tgl_indo($_GET['awal']);
	$tanggal_akhir = tgl_indo($_GET['akhir']);
?>
	<a href="index.php?mod=lap_rekap_umum"><img src='../images/back.png'></a>
	<h5>Data Mahasiswa yang Sudah Membayar</h5>
	<div class="box round first fullpage">
		<div class="block ">
		<table class="form">
			<tr>
				<td width="100">Program Studi </td>
				<td width="10">:</td>
				<td><b><?php echo $kd_jenjang_studi." ".$data_prodi['fakultas']." - ".$data_prodi['NMPSTMSPST']; ?></b></td>
			</tr>
			<tr>
				<td>Kelas</td>
				<td>:</td>
				<td><b><?php echo $data_kelas['nama_kelas']." - ".$kelas[1]; ?></b></td>
			</tr>
		</table>
	</div>
	</div>
	
		<?php
		echo "<table class='data display datatable' id='example'>
				<thead>
				<tr>
					<td colspan='4' bgcolor='#CFCFCF'></td>
					<td colspan='3' align=center bgcolor='#999'><b>Total Sudah Bayar (Rp)</b></td>
					<td colspan='3' align=center bgcolor='#999ccc'><b>Status (Rp)</b></td>
				</tr>
				<tr>
					<th width=30>No</th>
					<th width=80>NPM/NIM</th>
					<th width=180>Nama Mahasiswa</th>
					<th width=50>Kelas</th>
					<th>Gedung</th>
					<th>SPP</th>
					<th>SKS</th>
					<th>Gedung</th>
					<th>SPP</th>
					<th>SKS</th>
				</tr>
				<thead><tbody>";
		$i = 1;
		$sql_data = $db->database_prepare("SELECT * FROM as_mahasiswa A
											INNER JOIN as_kelas_mahasiswa B ON B.id_mhs = A.id_mhs
											INNER JOIN as_kelas C ON C.kelas_id = B.kelas_id 
											WHERE A.kode_program_studi = ? AND B.kelas_id = ? AND A.status_mahasiswa = 'A'")->execute($_GET["prodi"],$kelas[0]);
		while ($data_data = $db->database_fetch_array($sql_data)){
			$data_bayar = $db->database_fetch_array($db->database_prepare("SELECT SUM(uang_gedung) as jumlah_gedung, SUM(uang_spp) as jumlah_spp, 
																			SUM(uang_sks) as jumlah_sks FROM as_transaksi_bayar WHERE id_mhs=?")->execute($data_data['id_mhs']));
			$data_utang = $db->database_fetch_array($db->database_prepare("SELECT uang_gedung, uang_sks, uang_spp FROM as_biaya_kuliah WHERE id_mhs = ?")->execute($data_data["id_mhs"]));
			$tot_krs = $db->database_fetch_array($db->database_prepare("SELECT SUM(C.sks_mata_kuliah) as jumlah FROM as_krs A INNER JOIN as_jadwal_kuliah B ON A.jadwal_id=B.jadwal_id
										INNER JOIN as_makul C ON C.mata_kuliah_id=B.makul_id 
										INNER JOIN as_kelas D ON D.kelas_id=B.kelas_id
										INNER JOIN msdos E ON E.IDDOSMSDOS=B.dosen_id 
										WHERE B.kelas_id = ? AND A.id_mhs = ?")->execute($data_data["kelas_id"],$data_data["id_mhs"]));
			
			if ($data_bayar['jumlah_gedung'] >= $data_utang['uang_gedung']){
				$status_gedung = "<font color='green'><b>Lunas</b></font>";
			}
			else{
				$sisa_gedung = rupiah($data_utang['uang_gedung'] - $data_bayar['jumlah_gedung']);
				$status_gedung = "<font color=red><b>- $sisa_gedung</b></font>";
			}
			
			if ($data_bayar['jumlah_spp'] >= $data_utang['uang_spp']){
				$status_spp = "<font color='green'><b>Lunas</b></font>";
			}
			else{
				$sisa_spp = rupiah($data_utang['uang_spp'] - $data_bayar['jumlah_spp']);
				$status_spp = "<font color=red><b>- $sisa_spp</b></font>";
			}
			
			$krs = $tot_krs['jumlah'] * $data_utang['uang_sks'];
			if ($data_bayar['jumlah_sks'] >= $krs){
				$status_sks = "<font color='green'><b>Lunas</b></font>";
			}
			else{
				$sisa_sks = rupiah($krs - $data_bayar['jumlah_spp']);
				$status_sks = "<font color=red><b>- $sisa_sks</b></font>";
			}
			
			
			$sudah_bayar_gedung = rupiah($data_bayar['jumlah_gedung']);
			$sudah_bayar_spp = rupiah($data_bayar['jumlah_spp']);
			$sudah_bayar_sks = rupiah($data_bayar['jumlah_sks']);
			$kurang = rupiah($data_sem_1['uang_gedung'] - $data_bayar['jumlah']);
			echo "<tr>
					<td>$i</td>
					<td align=center>$data_data[NIM]</td>
					<td>$data_data[nama_mahasiswa]</td>
					<td>$data_data[nama_kelas]</td>
					<td>$sudah_bayar_gedung</td>
					<td>$sudah_bayar_spp</td>
					<td>$sudah_bayar_sks</td>
					<td>$status_gedung</td>
					<td>$status_spp</td>
					<td>$status_sks</td>
				</tr>";
			$i++;
		}
		echo "</tbody></table>";
		?>
	<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
	<a target="_blank" href="modul/mod_laporan/export_umum.php?prodi=<?php echo $_GET['prodi']; ?>&kelas=<?php echo $_GET['kelas']; ?>"><button type='button' class='btn btn-primary'>Export to PDF</button></a>
	<?php
	break;
}
?>