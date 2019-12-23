<?php 
if ($_GET['code'] == 1){
?>
	<div class='message success'>
		<h5>Success!</h5>
		<p>Data Perguruan Tinggi berhasil diperbaharui.</p>
	</div>
<?php
}
?>
<script type='text/javascript' src='../js/jquery.validate.js'></script>
		
<script type='text/javascript'>
	$(document).ready(function() {
		$( "#datepicker1" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: 'c-60:c-0'
		});
		
		$( "#datepicker2" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: 'c-60:c-0'
		});
		
		$( "#datepicker3" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: 'c-60:c-0'
		});
		
		$( "#datepicker4" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: 'c-60:c-0'
		});
		
		$( "#datepicker5" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: 'c-60:c-0'
		});
		
		$('#frm_pt2').validate({
			rules:{
				kdyysmspti: true,
				kdptimspti: true,
				nmptimspti: true,
				almt1mspti: true,
				kotaamspti: true,
				tanggal_akta: true,
				nomskmspti: true,
				tanggal_pendirian: true
			},
			messages:{
				kdyysmspti:{
					required: "Kode yayasan wajib diisi."
				},
				kdptimspti:{
					required: "kode perguruan tinggi wajib diisi."
				},
				nmptimspti:{
					required: "Nama perguruan tinggi wajib diisi."
				},
				almt1mspti:{
					required: "Alamat 1 perguruan tinggi wajib diisi."
				},
				kotaamsyss:{
					required: "Kota wajib diisi."
				},
				tanggal_akta:{
					required: "Tanggal akta / SK terakhir wajib diisi."
				},
				nomskmspti:{
					required: "Nomor akta / SK yayasan terakhir wajib diisi."
				},
				tanggal_pendirian:{
					required: "Tanggal awal pendirian badan hukum wajib diisi."
				}
			}
		});
		
		$('#frm_pt').validate({
			rules:{
				kdyysmsyys: true,
				nmyysmsyys: true,
				almt1msyys: true,
				kotaamsyys: true,
				tanggal_akta: true,
				nomskmsyys: true,
				tanggal_sah: true,
				tanggal_pendirian: true
			},
			messages:{
				kdyysmsyys:{
					required: "Kode badan hukum perguruan tinggi wajib diisi."
				},
				nmyysmsyys:{
					required: "Nama badan hukum perguruan tinggi wajib diisi."
				},
				almt1msyys:{
					required: "Alamat 1 perguruan tinggi wajib diisi."
				},
				kotaamsyss:{
					required: "Kota wajib diisi."
				},
				tanggal_akta:{
					required: "Tanggal akta / SK terakhir wajib diisi."
				},
				nomskmsyys:{
					required: "Nomor akta / SK yayasan terakhir wajib diisi."
				},
				tanggal_sah:{
					required: "Tanggal pengesahan pengadilan negeri terakhir wajib diisi."
				},
				tanggal_pendirian:{
					required: "Tanggal awal pendirian badan hukum wajib diisi."
				}
			}
		});
	});
</script>
<div class="btn-toolbar">
	
	<!--<a href="#myModal" data-toggle="modal" class="btn">Delete</a>-->
	<div class="btn-group"></div>
</div>
<h4>Data Badan Hukum dan PT</h4><br>
<div class="well">
	<ul id="menu2" class="menu2">
		<li class="active"><a href="#badan_pt">Badan Hukum Perguruan Tinggi</a></li>
		<li><a href="#pt">Perguruan Tinggi</a></li>
	</ul>
	<div id="badan_pt" class="content2">
		<?php
		$data_bpt = $db->database_fetch_array($db->database_prepare("SELECT * FROM msyys WHERE IDYYSMSYYS = '1'")->execute());
		$data_pt = $db->database_fetch_array($db->database_prepare("SELECT * FROM mspti WHERE IDYYSMSPTI = '1'")->execute());  
		?>
		<p>
			<div class="box round first fullpage">
				<div class="block ">
					<form id="frm_pt" action="modul/mod_pt/aksi_pt.php?tab=1" method="POST">
					<table class="form">
						<tr valign="top">
							<td width="200"><label>Kode Badan Hukum Perguruan Tinggi <font color="red">*</font></label></td>
							<td><input type="text" class="required" name="kdyysmsyys" value="<?php echo $data_bpt['KDYYSMSYYS']; ?>" size="40"></td>
						</tr>
						<tr valign="top">
							<td><label>Nama Badan Hukum Perguruan Tinggi <font color="red">*</font></label></td>
							<td><input type="text" class="required" name="nmyysmsyys" value="<?php echo $data_bpt['NMYYSMSYYS']; ?>" size="40"></td>
						</tr>
						<tr valign="top">
							<td><label>Alamat 1 <font color="red">*</font></label></td>
							<td><input type="text" class="required" name="almt1msyys" value="<?php echo $data_bpt['ALMT1MSYYS']; ?>" size="40"></td>
						</tr>
						<tr valign="top">
							<td><label>Alamat 2</label></td>
							<td><input type="text" name="almt2msyys" value="<?php echo $data_bpt['ALMT2MSYYS']; ?>" size="40"></td>
						</tr>
						<tr valign="top">
							<td><label>Kota <font color="red">*</font></label></td>
							<td><input type="text" class="required" name="kotaamsyys" value="<?php echo $data_bpt['KOTAAMSYYS']; ?>" size="40"></td>
						</tr>
						<tr valign="top">
							<td><label>Kode Pos</label></td>
							<td><input type="text" name="kdposmsyys" value="<?php echo $data_bpt['KDPOSMSYYS']; ?>"></td>
						</tr>
						<tr valign="top">
							<td><label>Telepon</label></td>
							<td><input type="text" name="telpomsyys" value="<?php echo $data_bpt['TELPOMSYYS']; ?>"></td>
						</tr>
						<tr valign="top">
							<td><label>Faksimil</label></td>
							<td><input type="text" name="faksimsyys" value="<?php echo $data_bpt['FAKSIMSYYS']; ?>"></td>
						</tr>
						<tr valign="top">
							<td><label>Tanggal Akta/SK Terakhir <font color="red">*</font></label></td>
							<td><input type="text" name="tanggal_akta" id="datepicker1" class="required" value="<?php echo $data_bpt['TGYYSMSYYS']; ?>"></td>
						</tr>
						<tr valign="top">
							<td><label>Nomor Akta/SK Yayasan Terakhir <font color="red">*</font></label></td>
							<td><input type="text" class="required" name="nomskmsyys" value="<?php echo $data_bpt['NOMSKMSYYS']; ?>"></td>
						</tr>
						<tr valign="top">
							<td><label>Tanggal Pengesahan Pengadilan Negeri/Lembar Berita Negara Terakhir *)</label></td>
							<td><input type="text" name="tanggal_sah" id="datepicker2" class="required" value="<?php echo $data_bpt['TGLBNMSYYS']; ?>"></td>
						</tr>
						<tr valign="top">
							<td><label>Email</label></td>
							<td><input type="text" name="emailmsyys" value="<?php echo $data_bpt['EMAILMSYYS']; ?>" size="40"></td>
						</tr>
						<tr valign="top">
							<td><label>Website</label></td>
							<td><input type="text" name="hpagemsyys" value="<?php echo $data_bpt['HPAGEMSYYS']; ?>" size="40"></td>
						</tr>
						<tr valign="top">
							<td><label>Tanggal Awal Pendirian Badan Hukum <font color="red">*</font></label></td>
							<td><input type="text" name="tanggal_pendirian" id="datepicker3" class="required" value="<?php echo $data_bpt['TGLAWLMSYYS']; ?>"></td>
						</tr>
						<tr valign="top">
							<td></td>
							<td><button type="submit" class="btn btn-primary"><i class="icon-save"></i> Simpan</button></td>
						</tr>
                    </table>
                    </form>
                </div>
            </div>
		</p>
	</div>
	<div id="pt" class="content2">
		<p>
			<div class="box round first fullpage">
				<div class="block ">
					<form id="frm_pt2" action="modul/mod_pt/aksi_pt.php?tab=2" method="POST">
					<table class="form">
						<tr valign="top">
							<td width="200"><label>Kode Yayasan <font color="red">*</font></label></td>
							<td><input type="text" class="required" name="kdyysmspti" value="<?php echo $data_pt['KDYYSMSPTI']; ?>" size="40"></td>
						</tr>
						<tr valign="top">
							<td><label>Kode Perguruan Tinggi <font color="red">*</font></label></td>
							<td><input type="text" class="required" name="kdptimspti" value="<?php echo $data_pt['KDPTIMSPTI']; ?>" size="40"></td>
						</tr>
						<tr valign="top">
							<td><label>Nama Perguruan Tinggi <font color="red">*</font></label></td>
							<td><input type="text" class="required" name="nmptimspti" value="<?php echo $data_pt['NMPTIMSPTI']; ?>" size="40"></td>
						</tr>
						<tr valign="top">
							<td><label>Alamat 1 <font color="red">*</font></label></td>
							<td><input type="text" class="required" name="almt1mspti" value="<?php echo $data_pt['ALMT1MSPTI']; ?>" size="40"></td>
						</tr>
						<tr valign="top">
							<td><label>Alamat 2</label></td>
							<td><input type="text" name="almt2mspti" value="<?php echo $data_pt['ALMT2MSPTI']; ?>" size="40"></td>
						</tr>
						<tr valign="top">
							<td><label>Kota <font color="red">*</font></label></td>
							<td><input type="text" class="required" name="kotaamspti" value="<?php echo $data_pt['KOTAAMSPTI']; ?>" size="40"></td>
						</tr>
						<tr valign="top">
							<td><label>Kode Pos</label></td>
							<td><input type="text" name="kdposmspti" value="<?php echo $data_pt['KDPOSMSPTI']; ?>"></td>
						</tr>
						<tr valign="top">
							<td><label>Telepon</label></td>
							<td><input type="text" name="telpomspti" value="<?php echo $data_pt['TELPOMSPTI']; ?>"></td>
						</tr>
						<tr valign="top">
							<td><label>Faksimil</label></td>
							<td><input type="text" name="faksimspti" value="<?php echo $data_pt['FAKSIMSPTI']; ?>"></td>
						</tr>
						<tr valign="top">
							<td><label>Tanggal Akta/SK Pendirian Terakhir <font color="red">*</font></label></td>
							<td><input type="text" name="tanggal_akta" id="datepicker4" class="required" value="<?php echo $data_pt['TGPTIMSPTI']; ?>"></td>
						</tr>
						<tr valign="top">
							<td><label>Nomor Akta/SK Pendirian Terakhir <font color="red">*</font></label></td>
							<td><input type="text" class="required" name="nomskmspti" value="<?php echo $data_pt['NOMSKMSPTI']; ?>" size="40"></td>
						</tr>
						<tr valign="top">
							<td><label>Email</label></td>
							<td><input type="text" name="emailmspti" value="<?php echo $data_pt['EMAILMSPTI']; ?>" size="40"></td>
						</tr>
						<tr valign="top">
							<td><label>Website</label></td>
							<td><input type="text" name="hpagemspti" value="<?php echo $data_pt['HPAGEMSPTI']; ?>" size="40"></td>
						</tr>
						<tr valign="top">
							<td><label>Tanggal Awal Pendirian Perguruan Tinggi <font color="red">*</font></label></td>
							<td><input type="text" name="tanggal_pendirian" id="datepicker5" size="40" value="<?php echo $data_pt['TGAWLMSPTI']; ?>"></td>
						</tr>
						<tr valign="top">
							<td></td>
							<td><button type="submit" class="btn btn-primary"><i class="icon-save"></i> Simpan</button></td>
						</tr>
                    </table>
                    </form>
                </div>
            </div>
		</p>
	</div>
</div>