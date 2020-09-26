<?php
	header('Content-type: application/json');

	include ('koneksi.php');
	$con=koneksi();
	$result;
	$query = '';
	
	if(isset($_POST['name'])){
		if($_POST['name'] == 'get'){
			get_data_mahasiswa($con);
		}
		if($_POST['name'] == 'post'){
			post_data_perwalian($con);
		}
	}
	
	function get_data_mahasiswa($con){
		$query		= "SELECT '1' as 'no', 
				upper(m.nim) as 'nim', 
				upper(m.nama_mahasiswa) as 'nama'
				from mahasiswa_biodata m, civitas_mahasiswa c
				where m.nim = c.nim and c.ajaran_aktif = '".$_POST['ctl_ajaran_aktif']."' and c.kode_prodi = '".$_POST['ctl_kode_prodi']."' 
					and c.semester_aktif = '".$_POST['ctl_semester_aktif']."'
				and c.nim not in (select nim from civitas_perwalian where  kode_ajaran = '".$_POST['ctl_ajaran_aktif']."' and kode_prodi = '".$_POST['ctl_kode_prodi']."' 
					and semester = '".$_POST['ctl_semester_aktif']."' ) " ;
				
		$result = mysqli_query($con, $query);
		$rows = array();
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			$rows[] = $row;
		}
		$data = json_encode($rows);

		echo $data;
	}
	
	function post_data_perwalian($con){
		try{
			$data_rencana_studi = get_data_rencana_studi($con); $i = 1;
			$nim				= $_POST['ctl_nim'];
			execquery("civitas_perwalian", "delete from civitas_perwalian where nim = '".$nim."' kode_ajaran = '".$_POST['ctl_ajaran_aktif']."' and kode_prodi = '".$_POST['ctl_kode_prodi']."' 
								and semester = '".$_POST['ctl_semester_aktif']."'");

			while($row = mysqli_fetch_array($data_rencana_studi, MYSQLI_ASSOC))
			{
				$ajaran			= $row['kode_ajaran'];
				$prodi			= $row['kode_prodi'];
				$semester		= $row['semester'];				
				
				$kode_rs 		= $row['kode_rencana_studi'];
				$kode_mk		= execqueryreturn("rencana_studi", "select kode_mk from rencana_studi where kode_rencana_studi = '".$kode_rs."' ");
				$kode_kelas		= execqueryreturn("kelas", "select kode_kelas from kelas where kode_ajaran = '".$ajaran."' 
									and kode_prodi = '".$prodi."' and kode_mk = '".$kode_mk."' limit 0, 1");
				
				$kode_perwalian	= $nim.$semester.$i;
				
				$query			= "insert into civitas_perwalian values ('".$kode_perwalian."', '".$nim."', '".$ajaran."', '".$prodi."', '".$semester."', 
										'".$kode_rs."', '".$kode_kelas."', now(), 1)";
				$state 			= execquery("civitas_perwalian",$query);
				
				$i++;
			}
			
			echo '[{"state":"1","msg":"success"}]';
		}
		catch(Exception $e) {
			echo '[{"state":"0","msg":"'.$e->getMessage().'"}]';
		}
	}
	
	function get_data_rencana_studi($con){
		$query		= "SELECT  
						upper(r.kode_rencana_studi) as 'kode_rencana_studi', 
						upper(r.kode_ajaran) as 'kode_ajaran', 
						upper(r.kode_prodi) as 'kode_prodi', 
						upper(r.semester) as 'semester', 
						upper(r.kode_mk) as 'kode_mk',
						upper(r.kode_mk) as 'kode_mk',
						upper(r.kode_mk_syarat) as 'kode_mk_syarat'
						from rencana_studi r where r.kode_ajaran = '".$_POST['ctl_ajaran_aktif']."' and r.kode_prodi = '".$_POST['ctl_kode_prodi']."' 
						and r.semester = '".$_POST['ctl_semester_aktif']."' ";
		
		$result = mysqli_query($con, $query);
		return $result;
	}
	
?>