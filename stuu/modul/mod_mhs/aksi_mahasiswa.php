<?php
error_reporting(0);
ini_set('max_execution_time', 300);
session_start();
include "../../../config/class_database.php";
include "../../../config/serverconfig.php";
include "../../../config/debug.php";
include "../../../fungsi/PHPExcel.php";

function mysql_escape($str){
	if(get_magic_quotes_gpc()){
		$str= stripslashes($str);
	}
	return str_replace("'", "''", $str);
}

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
	header("Location: ../../../index.php?code=2");
}

else{
	if ($_GET['mod'] == 'mhs' && $_GET['act'] == 'input'){
		$created_date = date('Y-m-d H:i:s');
		$tgl_lahir = $_POST['tgl_lahir'];
		$tgl_masuk = $_POST['tgl_masuk_mhs'];
		$tgl_lulus = $_POST['tgl_lulus'];
		$tgl_yudisium = $_POST['tgl_yudisium'];
		$password = md5(123456);
		
		if ($_POST['filename'] != ''){
			$file = "../../foto/mahasiswa/".$_POST['filename'];
			$gbr_asli = imagecreatefromjpeg($file);
			$lebar = imagesx($gbr_asli);
			$tinggi = imagesy($gbr_asli);
			
			$tum_lebar = 252;
			$tum_tinggi = 310;
			
			$gbr_thumb = imagecreatetruecolor($tum_lebar, $tum_tinggi);
			imagecopyresampled($gbr_thumb, $gbr_asli, 0, 0, 0, 0, $tum_lebar, $tum_tinggi, $lebar, $tinggi);
			
			imagejpeg($gbr_thumb, "../../foto/mahasiswa/thumb/small_".$_POST['filename']);
			
			imagedestroy($gbr_asli);
			imagedestroy($gbr_thumb);
		}
		
		$db->database_prepare("INSERT INTO as_mahasiswa ( 	kode_program_studi,
															NIM,
															ktp,
															nama_mahasiswa,
															inisial,
															tempat_lahir,
															tanggal_lahir,
															jenis_kelamin,
															golongan_darah,
															status_kawin,
															angkatan_id,
															Kelas,
															email,
															alamat,
															hobi,
															negara,
															telepon,
															hp,
															agama,
															foto,
															gelar_depan,
															gelar_belakang,
															status_mahasiswa,
															semester_masuk,
															tahun_masuk,
															tanggal_masuk,
															nilun,
															semester_lulus,
															tahun_lulus,
															tanggal_lulus,
															nomor_sk_yudisium,
															tanggal_sk_yudisium,
															judul_skripsi,
															jalur_skripsi,
															penyusunan_skripsi,
															awal_bimbingan,
															akhir_bimbingan,
															nomor_seri_ijazah,
															propinsi_asal_pendidikan,
															status_awal_mahasiswa,
															SKS_diakui,
															perguruan_tinggi_asal,
															program_studi_asal,
															jenjang_pendidikan_sebelumnya,
															NIM_asal,
															kode_biaya_studi,
															kode_pekerjaan,
															nama_tempat_pekerjaan,
															kode_pt_bekerja,
															kode_ps_bekerja,
															NIDN_kopromotor1,
															NIDN_kopromotor2,
															NIDN_kopromotor3,
															NIDN_kopromotor4,
															password,
															last_login,
															ip,
															created_date,
															created_userid,
															modified_date,
															modified_userid
															)
													VALUES (?,?,?,?,?,?,?,?,?,?,
															?,?,?,?,?,?,?,?,?,?,
															?,?,?,?,?,?,?,?,?,?,
															?,?,?,?,?,?,?,?,?,?,
															?,?,?,?,?,?,?,?,?,?,
															?,?,?,?,?,?,?,?,?,?,
															?)")
												->execute( 	$_POST["kode_program_studi"],
															$_POST["nim"],
															$_POST["ktp"],
															$_POST["nama_mahasiswa"],
															$_POST["inisial"],
															$_POST["tempat_lahir"],
															$tgl_lahir,
															$_POST["jenis_kelamin"],
															$_POST["darah"],
															$_POST["kawin"],
															$_POST["angkatan_id"],
															$_POST["kelas"],
															$_POST["email"],
															$_POST["alamat"],
															$_POST["hobi"],
															$_POST["negara"],
															$_POST["telepon"],
															$_POST["hp"],
															$_POST["agama"],
															$_POST["filename"],
															$_POST["gelar_depan"],
															$_POST["gelar_belakang"],
															$_POST["status_mahasiswa"],
															$_POST["semester_masuk"],
															$_POST["tahun_masuk"],
															$tgl_masuk,
															"",
															"",
															"",
															"",
															"",
															"",
															"",
															"",
															"",
															"",
															"",
															"",
															"",
															$_POST["status_awal_mahasiswa"],
															"",
															"",
															"",
															"",
															"",
															"",
															"",
															"",
															"",
															"",
															"",
															"",
															"",
															"",
															$password,
															"",
															"",
															$created_date,
															$_SESSION["userid"],
															"",
															"");
															
		header("Location: ../../index.php?mod=mhs&code=1");
	} 
	
	elseif($_GET['mod'] == 'mhs' && $_GET['act'] == 'upload'){
		$F1		= $_FILES['file'];
		$F1_name= $F1['name'];
		$F1_type= $F1['type'];
		$F1_size= $F1['size'];
		$dir	= "../../../uploads/";
		$timenow = time();
		$created_date = date('Y-m-d H:i:s');
		if(copy($F1['tmp_name'],$dir.$timenow."_".$F1_name)){
			$inputFileType = 'Excel2007';
			$inputFileName = $dir.$timenow."_".$F1_name;   
			$sheetname = 'Sheet1';
			
			class chunkReadFilter implements PHPExcel_Reader_IReadFilter {
			    private $_startRow = 0;
			    private $_endRow = 0;
			
			    /**  Set the list of rows that we want to read  */ 
			    public function setRows($startRow, $chunkSize) { 
			        $this->_startRow    = $startRow; 
			        $this->_endRow      = $startRow + $chunkSize;
			    } 
			
			    public function readCell($column, $row, $worksheetName = '') {
			        //  Only read the heading row, and the rows that are configured in $this->_startRow and $this->_endRow 
			        if (($row >= $this->_startRow && $row < $this->_endRow)) { 
			           return true;
			        }
			        return false;
			    } 
			}
			
			/**  Create a new Reader of the type defined in $inputFileType  **/
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			/**  Define how many rows we want to read for each "chunk"  **/ 
			$chunkSize = 500;
			/**  Create a new Instance of our Read Filter  **/ 
			$chunkFilter = new chunkReadFilter(); 
			/**  Tell the Reader that we want to use the Read Filter that we've Instantiated  **/ 
			$objReader->setReadFilter($chunkFilter); 
			
			for ($startRow = 1; ($startRow <= 1265536); $startRow += $chunkSize) 
			{
				/**  Tell the Read Filter, the limits on which rows we want to read this iteration  **/ 
			    $chunkFilter->setRows($startRow,$chunkSize); 
				/** Advise the Reader that we only want to load cell data, not formatting **/ 
				$objReader->setReadDataOnly(true);
			    /**  Load only the rows that match our filter from $inputFileName to a PHPExcel Object  **/ 
			    $objPHPExcel = $objReader->load($inputFileName); 
			    //    Do some processing here
			    $worksheet = null; 
				$worksheet = $objPHPExcel->getActiveSheet();
				
				//break the loop when there are 5 blank row in column A
				$numofblankrow = 0;
				$error_message = "";
				
				//Check excel format, are the first cell is "ID NUMBER"?, if not, then will be upload fail
				if($startRow == 1 && $worksheet->getCellByColumnAndRow(0, 1)->getValue() != "No.")
				{
					$processdone = 1; 
					$error_message = "Invalid import file format";
					break;
				}
				
				for($i = 0;$i<$chunkSize;$i++)
				{
					//Set $rowdata to be array variable 
					$rowdata=array();
					//Get the value from cell in excel file
					$rowdata[] 	= $worksheet->getCellByColumnAndRow(0, $i+$startRow)->getValue();
					$nim	 	= mysql_escape($worksheet->getCellByColumnAndRow(1, $i+$startRow)->getValue());
					$id_prodi 	= mysql_escape($worksheet->getCellByColumnAndRow(2, $i+$startRow)->getValue());
					$nama_mhs 	= mysql_escape($worksheet->getCellByColumnAndRow(3, $i+$startRow)->getValue());
					$inisial_mhs= mysql_escape($worksheet->getCellByColumnAndRow(4, $i+$startRow)->getValue());
					$jk			= mysql_escape($worksheet->getCellByColumnAndRow(5, $i+$startRow)->getValue());
					$program	= mysql_escape($worksheet->getCellByColumnAndRow(6, $i+$startRow)->getValue());
					$status_mhs	= mysql_escape($worksheet->getCellByColumnAndRow(7, $i+$startRow)->getValue());
					$status_awal= mysql_escape($worksheet->getCellByColumnAndRow(8, $i+$startRow)->getValue());
					$thn_angkatan = mysql_escape($worksheet->getCellByColumnAndRow(9, $i+$startRow)->getValue());
					$semester_masuk	= mysql_escape($worksheet->getCellByColumnAndRow(10, $i+$startRow)->getValue());
					$tahun_masuk= mysql_escape($worksheet->getCellByColumnAndRow(11, $i+$startRow)->getValue());
					
					$abc = (string)$rowdata[0];
					//echo "Processing excel row  : " . ($i+$startRow)  .", id : " . $abc . "<br>"; 
					
				  	//break the loop when there are 5 sequential blank row in column A
				    if($rowdata[0] == "" || $rowdata[0]==NULL || !$rowdata[0] || $rowdata[0]=="END")
				    {
						$numofblankrow++;  
						if($numofblankrow >= 5 || (string)$rowdata[0]=="END")
						{
							$processdone = 1;
							break;
						}
						else
						{
							continue;	
						}
						
				    }
					else 
					{
						$numofblankrow = 0;
					}
					if($i+$startRow > 1 && !empty($rowdata))
					{
						if($nim != "" && $nama_mhs !=""){
							$db->database_prepare("INSERT INTO as_mahasiswa ( 	kode_program_studi,
																				NIM,
																				ktp,
																				nama_mahasiswa,
																				inisial,
																				tempat_lahir,
																				tanggal_lahir,
																				jenis_kelamin,
																				golongan_darah,
																				status_kawin,
																				angkatan_id,
																				Kelas,
																				email,
																				alamat,
																				hobi,
																				negara,
																				telepon,
																				hp,
																				agama,
																				foto,
																				gelar_depan,
																				gelar_belakang,
																				status_mahasiswa,
																				semester_masuk,
																				tahun_masuk,
																				tanggal_masuk,
																				nilun,
																				semester_lulus,
																				tahun_lulus,
																				tanggal_lulus,
																				nomor_sk_yudisium,
																				tanggal_sk_yudisium,
																				judul_skripsi,
																				jalur_skripsi,
																				penyusunan_skripsi,
																				awal_bimbingan,
																				akhir_bimbingan,
																				nomor_seri_ijazah,
																				propinsi_asal_pendidikan,
																				status_awal_mahasiswa,
																				SKS_diakui,
																				perguruan_tinggi_asal,
																				program_studi_asal,
																				jenjang_pendidikan_sebelumnya,
																				NIM_asal,
																				kode_biaya_studi,
																				kode_pekerjaan,
																				nama_tempat_pekerjaan,
																				kode_pt_bekerja,
																				kode_ps_bekerja,
																				NIDN_kopromotor1,
																				NIDN_kopromotor2,
																				NIDN_kopromotor3,
																				NIDN_kopromotor4,
																				created_date,
																				created_userid,
																				modified_date,
																				modified_userid
																				)
																		VALUES (?,?,?,?,?,?,?,?,?,?,
																				?,?,?,?,?,?,?,?,?,?,
																				?,?,?,?,?,?,?,?,?,?,
																				?,?,?,?,?,?,?,?,?,?,
																				?,?,?,?,?,?,?,?,?,?,
																				?,?,?,?,?,?,?,?)")
																	->execute( 	$id_prodi,
																				$nim,
																				"",
																				$nama_mhs,
																				$inisial_mhs,
																				"",
																				"0000-00-00",
																				$jk,
																				"",
																				"",
																				$thn_angkatan,
																				$program,
																				"",
																				"",
																				"",
																				"",
																				"",
																				"",
																				"",
																				"",
																				"",
																				"",
																				$status_mhs,
																				$semester_masuk,
																				$tahun_masuk,
																				"0000-00-00",
																				"",
																				"",
																				"",
																				"0000-00-00",
																				"",
																				"0000-00-00",
																				"",
																				"",
																				"",
																				"",
																				"",
																				"",
																				"",
																				$status_awal,
																				"",
																				"",
																				"",
																				"",
																				"",
																				"",
																				"",
																				"",
																				"",
																				"",
																				"",
																				"",
																				"",
																				"",
																				$created_date,
																				$_SESSION["userid"],
																				"",
																				"");	
						}
					} //close bracket if($i+$startRow > 1 && !empty($rowdata))
				    //    Free up some of the memory 
				    
				}//close bracket for
				$objPHPExcel->disconnectWorksheets(); 
			    unset($objPHPExcel);		
			}
			header("Location: ../../index.php?mod=mhs&code=4");
		} 
		else{
			header("Location: ../../index.php?mod=mhs&code=5");
		}
	}

	elseif($_GET['mod'] == 'mhs' && $_GET['act'] == 'update'){
		$modified_date = date('Y-m-d H:i:s');
		$tgl_lahir = $_POST['tgl_lahir'];
		$tgl_masuk = $_POST['tgl_masuk_mhs'];
		$tgl_lulus = $_POST['tgl_lulus'];
		$tgl_yudisium = $_POST['tgl_yudisium'];
		
		if ($_POST['filename'] != ''){
			$file = "../../foto/mahasiswa/".$_POST['filename'];
			$gbr_asli = imagecreatefromjpeg($file);
			$lebar = imagesx($gbr_asli);
			$tinggi = imagesy($gbr_asli);
			
			$tum_lebar = 252;
			$tum_tinggi = 310;
			
			$gbr_thumb = imagecreatetruecolor($tum_lebar, $tum_tinggi);
			imagecopyresampled($gbr_thumb, $gbr_asli, 0, 0, 0, 0, $tum_lebar, $tum_tinggi, $lebar, $tinggi);
			
			imagejpeg($gbr_thumb, "../../foto/mahasiswa/thumb/small_".$_POST['filename']);
			
			imagedestroy($gbr_asli);
			imagedestroy($gbr_thumb);
		}
		
		$db->database_prepare("UPDATE as_mahasiswa SET 	ktp = ?,
														nama_mahasiswa = ?,
														inisial = ?,
														tempat_lahir = ?,
														tanggal_lahir = ?,
														jenis_kelamin = ?,
														golongan_darah = ?,
														status_kawin = ?,
														angkatan_id = ?,
														Kelas = ?,
														email = ?,
														alamat = ?,
														hobi = ?,
														negara = ?,
														telepon = ?,
														hp = ?,
														agama = ?,
														foto = ?,
														gelar_depan = ?,
														gelar_belakang = ?,
														status_mahasiswa = ?,
														semester_masuk = ?,
														tahun_masuk = ?,
														tanggal_masuk = ?,
														propinsi_asal_pendidikan = ?,
														status_awal_mahasiswa = ?,
														SKS_diakui = ?,
														perguruan_tinggi_asal = ?,
														program_studi_asal = ?,
														jenjang_pendidikan_sebelumnya = ?,
														NIM_asal = ?,
														kode_biaya_studi = ?,
														kode_pekerjaan = ?,
														nama_tempat_pekerjaan = ?,
														kode_pt_bekerja = ?,
														kode_ps_bekerja = ?,
														modified_date = ?,
														modified_userid = ?
														WHERE id_mhs = ?")
											->execute(	$_POST["ktp"],
														$_POST["nama_mahasiswa"],
														$_POST["inisial"],
														$_POST["tempat_lahir"],
														$tgl_lahir,
														$_POST["jenis_kelamin"],
														$_POST["darah"],
														$_POST["kawin"],
														$_POST["angkatan_id"],
														$_POST["kelas"],
														$_POST["email"],
														$_POST["alamat"],
														$_POST["hobi"],
														$_POST["negara"],
														$_POST["telepon"],
														$_POST["hp"],
														$_POST["agama"],
														$_POST["filename"],
														$_POST["gelar_depan"],
														$_POST["gelar_belakang"],
														$_POST["status_mahasiswa"],
														$_POST["semester_masuk"],
														$_POST["tahun_masuk"],
														$tgl_masuk,
														"",
														$_POST["status_awal_mahasiswa"],
														"",
														"",
														"",
														"",
														"",
														"",
														"",
														"",
														"",
														"",
														$modified_date,
														$_SESSION["userid"],
														$_POST["id"]);

		header("Location: ../../index.php?mod=mhs&code=2&act=biodata&program_studi=".$_POST['program_studi']."&nim=".$_POST['nim']);
	}

	elseif ($_GET['mod'] == 'mhs' && $_GET['act'] == 'delete'){
		$dataimage = $db->database_fetch_array($db->database_prepare("SELECT foto FROM as_mahasiswa WHERE id_mhs = ?")->execute($_GET["id"]));
		if ($dataimage['foto'] != ''){
			$del_image = unlink("../../foto/mahasiswa/".$dataimage['foto']);
		}
		
		$db->database_prepare("DELETE FROM as_mahasiswa WHERE id_mhs = ?")->execute($_GET["id"]);
		header("Location: ../../index.php?mod=mhs&code=3&act=biodata&program_studi=".$_GET['program_studi']."&nim=".$_GET['nim']);
	}
}
?>