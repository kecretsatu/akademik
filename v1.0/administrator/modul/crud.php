<?php
	header('Content-type: application/json');

	include ('koneksi.php');
	$con=koneksi();
	$result;
	$query = '';
	$withCustomSave			= array("civitas_perwalian", "rencana_studi", "jadwal_kuliah", "civitas_absensi", "civitas_nilai", "perpustakaan_katalog");
	$withCustomSaveAfter	= array("kelas");
	
	try{
		if(isset($_POST['name'])){
			$tabel = getTableAlias(0, $_POST['name']);
			$columns = getColumns($tabel); $columnPrimary = '';
			
			if(in_array($tabel, $withCustomSave)){if(!custom_save($con, $tabel, $columns)){ exit; }}
			
			foreach ($columns as $col) {
				if(!$col[3]){}else{$columnPrimary = "".$col[0]." = '".$_POST["ctl_".$col[0]]."'";}
			}
			
			///// Update Log \\\\\\
			$isUpdate	= false; $isUpdateData = array();
			
			
			
			$isExist = execqueryreturn($_POST['name'], "select count(*) from ".$tabel." where ".$columnPrimary);
			
			if($isExist > 0){
				$query = build_update_query($con, $tabel, $columns);
				
				$isUpdate = true;
				$result		= mysqli_query($con, "select * from ".$tabel." where ".$columnPrimary);
				$rows 		= array();
				while($row	= mysqli_fetch_array($result, MYSQLI_ASSOC))
				{
					$rows[] = $row;
				}
				$isUpdateData = json_encode($rows);
				
			}
			else{
				$query = build_insert_query($con, $tabel, $columns);
				$isUpdate = false;
			}
			
			$state = execquery($tabel,$query);
			
			$custom_msg = '';
			
			//if(isset($_POST['import_index'])){$custom_msg = '"index":"'.$_POST['import_index'].'"';}
			
			if($state == 1){
				if($isUpdate){
					save_update_log($tabel, $isUpdateData);
				}
				if(in_array($tabel, $withCustomSaveAfter)){
					if(custom_save_after($con, $tabel, $columns)){
						//echo '[{"state":"1","msg":"success"'.$custom_msg.'}]';
					}
				}
				echo '[{"state":"1","msg":"success"'.$custom_msg.'}]';
			}
			else{
				echo '[{"state":"0","msg":"'.$state.'"'.$custom_msg.'}]';
			}
		}	
		
	}
	catch(Exception $e) {
		echo '[{"state":"0","msg":"'.$e->getMessage().'"}]';
	}
	
	function save_update_log($tabel, $data){
		$query		= "insert into z_log_update(user_id, table_name, data_remove, date_remove) values ('11111', '".$tabel."', '".$data."', now())";
		$state		= execquery($tabel,$query);
		if($state == 1){
			return true;
		}
		else{
			return false;
		}
	}
	
	function custom_save($con, $tabel, $columns){
		$hasil = true;
		if($tabel == 'civitas_perwalian'){
			$total_mk	= $_POST['ctl_total_mk'];
			$nim		= $_POST['ctl_nim'];
			$ajaran		= $_POST['ctl_kode_ajaran'];
			$prodi		= $_POST['ctl_kode_prodi'];
			$semester	= $_POST['ctl_semester'];
			
			execquery($tabel, "delete from civitas_perwalian where nim = '".$nim."' and kode_prodi = '".$prodi."' and kode_ajaran = '".$ajaran."' and semester = '".$semester."'");
			for($i = 1; $i <= $total_mk; $i++){
				if(isset($_POST['ctl_mk_'.$i])){				
					$kode_rs 		= $_POST['ctl_mk_'.$i];
					$kode_mk		= execqueryreturn("rencana_studi", "select kode_mk from rencana_studi where kode_rencana_studi = '".$kode_rs."' ");
					$kode_kelas		= execqueryreturn("kelas", "select kode_kelas from kelas where kode_ajaran = '".$ajaran."' 
										and kode_prodi = '".$prodi."' and kode_mk = '".$kode_mk."' limit 0, 1");
					
					$kode_perwalian	= $nim.$semester.$i;
					
					$query			= "insert into civitas_perwalian values ('".$kode_perwalian."', '".$nim."', '".$ajaran."', '".$prodi."', '".$semester."', 
											'".$kode_rs."', '".$kode_kelas."', now(), 1)";
					$state 			= execquery($tabel,$query);
				}
			}
			$hasil = false;
			echo '[{"state":"1","msg":"success"}]';
		}
		if($tabel == 'rencana_studi'){
			$kode_ajaran	= $_POST["ctl_kode_ajaran"];
			$kode_prodi		= $_POST["ctl_kode_prodi"];
			$kode_mk		= $_POST["ctl_kode_mk"];
			$nama_kelas		= "A";
			$keterangan		= "";
			
			$kode_kelas		= generatecode("kelas", $columns).$nama_kelas;
			
			$query = "insert into kelas values ('".$kode_kelas."', '".$kode_ajaran."', '".$kode_prodi."', '".$kode_mk."', '".$nama_kelas."', '".$keterangan."', now(), 1) ";
			execquery($tabel, $query);
			
		}
		if($tabel == 'jadwal_kuliah'){
			$kode_ajaran	= execqueryreturn("tahun_ajaran", "select kode_ajaran from tahun_ajaran where status = '1' ");
			$kode_prodi		= $_POST["ctl_kode_prodi"];
			$kode_mk		= $_POST["ctl_kode_mk"];
			$kode_ruang		= $_POST["ctl_kode_ruang"];
			
			$semester		= execqueryreturn("rencana_studi", "select semester from rencana_studi where kode_ajaran = '".$kode_ajaran."' 
								and kode_prodi = '".$kode_prodi."' and kode_mk = '".$kode_mk."' ");
						
			$hari			= $_POST["ctl_hari"];
			$mulai			= $_POST["ctl_mulai"];
			$selesai		= $_POST["ctl_selesai"];
			
			$jadwal_exist = execqueryreturn("jadwal_kuliah", "select count(*) from jadwal_kuliah where kode_ajaran = '".$kode_ajaran."' 
				and kode_prodi = '".$kode_prodi."' and hari = '".$hari."' and 
				(kode_ruang = '".$kode_ruang."' or kode_mk in (select kode_mk from rencana_studi where semester = ".$semester.") )
				and (('".$mulai."' >= mulai and '".$mulai."' <= selesai) or ('".$selesai."' >= mulai and '".$selesai."' <= selesai)) ");
				
			if($jadwal_exist > 0){
				$hasil = false;
				echo '[{"state":"0","msg":"Prodi dan Mata Kuliah telah terjadwal"}]';
			}
			else{
				$hasil = true;
			}
			
		}
		if($tabel == 'civitas_absensi'){
			$n		= $_POST["total"];
			
			for($i = 1; $i <= $n; $i++){
				$query	= "delete from civitas_absensi  where kode_ajaran = '".$_POST["f_kode_ajaran"]."' and 
							kode_prodi = '".$_POST["f_kode_prodi"]."' and kode_mk = '".$_POST["f_mata_kuliah"]."' 
							and nim = '".$_POST["ctl_nim_".$i]."' 
							and tanggal_absensi = '".$_POST["tanggal"]."' "; 
				execquery($tabel, $query);
							
				$tanggal = $_POST["tanggal"];
				$tanggal = date("dm", strtotime($tanggal));				
				$code	= $_POST["f_kode_ajaran"].$_POST["f_kode_prodi"].$_POST["ctl_nim_".$i].$_POST["f_mata_kuliah"].$tanggal;
				
				$query	= "insert into civitas_absensi values('".$code."', '".$_POST["f_kode_ajaran"]."', '".$_POST["f_kode_prodi"]."', 
							'".$_POST["ctl_nim_".$i]."', '".$_POST["f_mata_kuliah"]."', '".$_POST["tanggal"]."', '".$_POST["ctl_kehadiran_".$i]."',
							now(), 1)";
				execquery($tabel, $query);
			}
			echo '[{"state":"1","msg":"success"}]';
			$hasil	= false;
		}
		if($tabel == 'civitas_nilai'){
			$n		= $_POST["total"];
			
			for($i = 1; $i <= $n; $i++){
				$query	= "delete from civitas_nilai  where kode_ajaran = '".$_POST["f_kode_ajaran"]."' and 
							kode_prodi = '".$_POST["f_kode_prodi"]."' and kode_mk = '".$_POST["f_mata_kuliah"]."' 
							and nim = '".$_POST["ctl_nim_".$i]."' and jenis_nilai = '".$_POST["f_jenis_nilai"]."' and ke = '".$_POST["f_nilai_ke"]."' "; 
				
				execquery($tabel, $query);

				$code	= $_POST["f_kode_ajaran"].$_POST["f_kode_prodi"].$_POST["ctl_nim_".$i].$_POST["f_mata_kuliah"].$_POST["f_jenis_nilai"].$_POST["f_nilai_ke"];
				
				$query	= "insert into civitas_nilai values('".$code."', '".$_POST["f_kode_ajaran"]."', '".$_POST["f_kode_prodi"]."', 
							'".$_POST["ctl_nim_".$i]."', '".$_POST["f_mata_kuliah"]."', '".$_POST["f_jenis_nilai"]."', '".$_POST["f_nilai_ke"]."', 
							'".$_POST["ctl_nilai_".$i]."', now(), 1)";
				execquery($tabel, $query);
			}
			echo '[{"state":"1","msg":"success"}]';
			$hasil	= false;
		}
		if($tabel == 'perpustakaan_katalog'){
			if(isset($_POST["import"])){				
				if(isset($_FILES["file"])){
					$code			= execqueryreturn("table_alias", "select DATE_FORMAT(sysdate(1),'%d%m%Y%H%i%s%f') from table_alias limit 0, 1");
					$target_dir		= "temp/";
					$target_file	= $target_dir . $code . ".csv";
					try{
						move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
						echo '[{"state":"1","msg":"success"}]';
					}
					catch(Exception $e) {
						echo '[{"state":"0","msg":"'.$e->getMessage().'"}]';
					}
				}
				$hasil = false;
			}
			else{
				$hasil = true;
			}
		}
		return $hasil;
	}
	
	function custom_save_after($con, $tabel, $columns){
		$hasil = true;
		
		if($tabel == 'kelas'){
			$kode_ajaran	= $_POST["ctl_kode_ajaran"];
			$kode_prodi		= $_POST["ctl_kode_prodi"];
			$kode_mk		= $_POST["ctl_kode_mk"];
			$kode_rs		= execqueryreturn("rencana_studi", "select kode_rencana_studi from rencana_studi where kode_ajaran = '".$kode_ajaran."' 
								and kode_prodi = '".$kode_prodi."' and kode_mk = '".$kode_mk."'");
			
			$total_kelas	= execqueryreturn("kelas", "select count(*) from kelas where kode_ajaran = '".$kode_ajaran."' 
								and kode_prodi = '".$kode_prodi."' and kode_mk = '".$kode_mk."'");
			$total_peserta	= execqueryreturn("civitas_perwalian", "select count(*) from civitas_perwalian where kode_rencana_studi = '".$kode_rs."'");
								
			$total_bagi		= round($total_peserta / $total_kelas);
			
			$kelas	 		= mysqli_query($con, "select * from kelas where kode_ajaran = '".$kode_ajaran."' 
								and kode_prodi = '".$kode_prodi."' and kode_mk = '".$kode_mk."'");
								
			$n = 0; $limit = 0;
			while($row = mysqli_fetch_array($kelas, MYSQLI_ASSOC)){
				if($n == $total_kelas){$total_bagi = $total_peserta;}
				
				$kode_kelas	= $row["kode_kelas"];				
				$query		= "update civitas_perwalian set kode_kelas = '".$kode_kelas."' where kode_perwalian in (
								select * from (
									select kode_perwalian from civitas_perwalian where kode_rencana_studi = '".$kode_rs."' limit ".$limit.", ".$total_bagi." 
								) as t )";
				
				execquery("civitas_perwalian", $query);
				
				$limit 		= $limit + $total_bagi;
				$n++;
			}			
		}
		
		return $hasil;
	}
		
	function build_insert_query($con, $tabel, $columns){
		$columnQuery = ''; $valueQuery = '';
		foreach ($columns as $col) {
			if($col[0] == 'date_saved'){
				$columnQuery	.= "date_saved,";
				$valueQuery		.= "now(),";
			}
			elseif($col[0] == 'statue'){
				$columnQuery	.= "statue";
				$valueQuery		.= "1";
			}
			else{
				$columnQuery	.= "".$col[0].",";
				if($_POST["ctl_".$col[0]] == 'generatecode' || $_POST["ctl_".$col[0]] == ''){
					$valueQuery		.= "'".mysqli_real_escape_string($con,generatecode($tabel, $columns))."',";
				}
				else{
					$valueQuery		.= "'".mysqli_real_escape_string($con,$_POST["ctl_".$col[0]])."',";
				}
			}
		}
		$query = "insert into ".$tabel." (".$columnQuery.") values (".$valueQuery.")";
		
		return $query;
	}
	
	function build_update_query($con, $tabel, $columns){
		$columnPrimary = ''; $valueQuery = '';
		foreach ($columns as $col) {
			if(!$col[3]){
				if($col[0] == 'date_saved'){
					$valueQuery		.= "date_saved = now(),";
				}
				elseif($col[0] == 'statue'){
					$valueQuery		.= "statue = 1";
				}
				else{
					$valueQuery		.= "".$col[0]." = '".mysqli_real_escape_string($con,$_POST["ctl_".$col[0]])."',";
				}
			}
			else{
				$columnPrimary = "".$col[0]." = '".$_POST["ctl_".$col[0]]."'";
			}
		}
		$query = "update ".$tabel." set ".$valueQuery." where  ".$columnPrimary;
		
		return $query;
	}
	
	function generatecode($tabel, $columns){
		$code = "";
		if($tabel == 'fakultas'){
			$val	 = execqueryreturn($tabel,"select count(*) from ".$tabel); $val	+= 1;
			$code = build_number($tabel, $val, 2);
		}
		if($tabel == 'jurusan'){
			$val	 = execqueryreturn($tabel,"select count(*) from ".$tabel. " where kode_fakultas = '".$_POST['ctl_kode_fakultas']."'"); $val	+= 1;
			$code	 = $_POST['ctl_kode_fakultas'].build_number($tabel, $val, 2);
		}
		if($tabel == 'prodi_identitas'){
			$val	 = execqueryreturn($tabel,"select count(*) from ".$tabel. " where kode_jurusan = '".$_POST['ctl_kode_jurusan']."'"); $val	+= 1;
			$code	 = $_POST['ctl_kode_jurusan'].build_number($tabel, $val, 2);
		}
		if($tabel == 'mata_kuliah_jenis'){
			$val	 = execqueryreturn($tabel,"select count(*) from ".$tabel. ""); $val	+= 1;
			$code	 = build_number($tabel, $val, 2);
		}
		if($tabel == 'kelas'){
			$nama_kelas = '';
			if(isset($_POST["ctl_nama_kelas"])){
				$nama_kelas = $_POST["ctl_nama_kelas"];
			}
			$code	 = $_POST["ctl_kode_ajaran"].$_POST["ctl_kode_prodi"].$_POST["ctl_kode_mk"].$nama_kelas;
		}
		if($tabel == 'rencana_studi'){
			$code = $_POST["ctl_kode_ajaran"].$_POST["ctl_kode_prodi"].$_POST["ctl_kode_mk"];
		}
		if($tabel == 'jadwal_kuliah'){			
			$hari = array("senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu");
			$indexhari = array_search($_POST["ctl_hari"], $hari);
			$code = $_POST["ctl_kode_kelas"].($indexhari+1);
			
			$code = str_replace(':','', $code);
		}
		if($tabel == 'perwalian_jadwal'){
			$code = $_POST["ctl_kode_ajaran"].$_POST["ctl_kode_prodi"];
		}
		if($tabel == 'civitas_absensi'){
			$tanggal = $_POST["ctl_tanggal_absensi"];
			$tanggal = date("dm", strtotime($tanggal));
			
			$code	= $_POST["ctl_kode_ajaran"].$_POST["ctl_kode_prodi"].$_POST["ctl_nim"].$_POST["ctl_kode_mata_kuliah"].$tanggal;
		}		
		if($tabel == 'perpustakaan_group' || $tabel == 'perpustakaan_kategori' || $tabel == 'perpustakaan_katalog'){
			$tgl = execqueryreturn("table_alias", "select DATE_FORMAT(sysdate(1),'%d%m%Y%H%i%s%f') from table_alias limit 0, 1");
			$code = $tgl;
		}
		if($tabel == 'keuangan_jenis'){
			$tgl = execqueryreturn("table_alias", "select DATE_FORMAT(sysdate(1),'%d%m%Y%H%i%s%f') from table_alias limit 0, 1");
			$code = $tgl;
		}
		if($tabel == 'keuangan_nilai'){
			$tgl = execqueryreturn("table_alias", "select DATE_FORMAT(sysdate(1),'%d%m%Y%H%i%s%f') from table_alias limit 0, 1");
			$code = $tgl;
		}
		
		return $code;
	}
	
	function build_number($tabel, $val, $len){
		$number = '';
		
		for($i = 1; $i <= $len - (strlen($val)); $i++){
			$number .= '0';
		}
		$number .= $val;
		
		return $number;
	}

?>


