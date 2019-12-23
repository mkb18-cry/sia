<?php
switch($_GET['act']){
	default:
?>
	<h4>Laporan Akademik</h4><br>
	<table class="data display datatable" id="example">
	<thead>
		<tr>
			<th width='30'>No</th>
			<th width='100'>Kode</th>
			<th width='270'>Nama Laporan</th>
			<th width='130'>Tahun Angkatan</th>
			<th align='left'>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>1</td>
			<td>MSYYS</td>
			<td>Master Yayasan</td>
			<td></td>
			<td><a href="modul/mod_epsbed/msyys.php" target="_blank"><button type="submit" class="btn btn-green">Download</button></a></td>
		</tr>
		<tr>
			<td>2</td>
			<td>MSPTI</td>
			<td>Master Perguruan Tinggi</td>
			<td></td>
			<td><a href="modul/mod_epsbed/mspti.php" target="_blank"><button type="submit" class="btn btn-green">Download</button></a></td>
		</tr>
		<tr>
			<td>3</td>
			<td>MSPST</td>
			<td>Master Program Studi</td>
			<td></td>
			<td><a href="modul/mod_epsbed/mspst.php" target="_blank"><button type="submit" class="btn btn-green">Download</button></a></td>
		</tr>
		<tr>
			<td>4</td>
			<td>MSDOS</td>
			<td>Master Dosen</td>
			<td></td>
			<td><a href="modul/mod_epsbed/msdos.php" target="_blank"><button type="submit" class="btn btn-green">Download</button></a></td>
		</tr>
		<tr>
			<td>5</td>
			<td>MSMHS</td>
			<td>Master Mahasiswa</td>
			<form method="GET" action="modul/mod_epsbed/msmhs.php" target="_blank">
			<td>
				<select name="th">
					<option value="all">All</option>
					<?php
					$sql_angkatan = $db->database_prepare("SELECT * FROM as_angkatan WHERE aktif = 'A' ORDER BY tahun_angkatan,semester_angkatan DESC")->execute();
					while ($data_angkatan = $db->database_fetch_array($sql_angkatan)){
						if ($data_angkatan['semester_angkatan'] == 'A'){
							$semester = "Genap";
						}
						else{
							$semester = "Ganjil";
						}
						
						echo "<option value='$data_angkatan[angkatan_id]'>$data_angkatan[tahun_angkatan] - $semester</option>";
					}
					?>
				</select>
			</td>
			<td><button type="submit" class="btn btn-green">Download</button></td>
			</form>
		</tr>
		<tr>
			<td>6</td>
			<td>TRAKD</td>
			<td>Master Transaksi Dosen</td>
			<td></td>
			<td><a href="modul/mod_epsbed/trakd.php" target="_blank"><button type="submit" class="btn btn-green">Download</button></a></td>
		</tr>
		<tr>
			<form method="GET" action="modul/mod_epsbed/trakm.php" target="_blank">
			<td>7</td>
			<td>TRAKM</td>
			<td>Master Transaksi Mahasiswa</td>
			<td>
				<select name="th">
					<option value="all">All</option>
					<?php
					$sql_angkatan = $db->database_prepare("SELECT * FROM as_angkatan WHERE aktif = 'A' ORDER BY tahun_angkatan,semester_angkatan DESC")->execute();
					while ($data_angkatan = $db->database_fetch_array($sql_angkatan)){
						if ($data_angkatan['semester_angkatan'] == 'A'){
							$semester = "Genap";
						}
						else{
							$semester = "Ganjil";
						}
						
						echo "<option value='$data_angkatan[angkatan_id]'>$data_angkatan[tahun_angkatan] - $semester</option>";
					}
					?>
				</select>
			</td>
			<td>
				<button type="submit" class="btn btn-green">Download</button>
			</td>
			</form>
		</tr>
		<tr>
			<form method="GET" action="modul/mod_epsbed/trnlm.php" target="_blank">
			<td>8</td>
			<td>TRNLM</td>
			<td>Master Transaksi Nilai Mahasiswa</td>
			<td>
				<select name="th">
					<option value="all">All</option>
					<?php
					$sql_angkatan = $db->database_prepare("SELECT * FROM as_angkatan WHERE aktif = 'A' ORDER BY tahun_angkatan,semester_angkatan DESC")->execute();
					while ($data_angkatan = $db->database_fetch_array($sql_angkatan)){
						if ($data_angkatan['semester_angkatan'] == 'A'){
							$semester = "Genap";
						}
						else{
							$semester = "Ganjil";
						}
						
						echo "<option value='$data_angkatan[angkatan_id]'>$data_angkatan[tahun_angkatan] - $semester</option>";
					}
					?>
				</select>
			</td>
			<td><button type="submit" class="btn btn-green">Download</button></td>
			</form>
		</tr>
		<!--<tr>
			<td>9</td>
			<td>TRLSM</td>
			<td>Master Trasanski Cuti/Keluar/Lulus Mahasiswa</td>
			<td></td>
			<td><a href="modul/mod_epsbed/trlsm.php" target="_blank"><button type="submit" class="btn btn-green">Download</button></a></td>
		</tr>
		<tr>
			<td>10</td>
			<td>TRLSD</td>
			<td>Master Transaksi Cuti/Meninggal Dosen</td>
			<td></td>
			<td><a href="modul/mod_epsbed/trlsd.php" target="_blank"><button type="submit" class="btn btn-green">Download</button></a></td>
		</tr>-->
		<tr>
			<td>9</td>
			<td>TRPUD</td>
			<td>Master Publikasi Dosen</td>
			<td></td>
			<td><a href="modul/mod_epsbed/trpud.php" target="_blank"><button type="submit" class="btn btn-green">Download</button></a></td>
		</tr>
	</tbody>
</table>
<?php

	break;
}
?>