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
			bentuk_jadwal_kolektif($con);
		}
	}
	
	function bentuk_jadwal_kolektif($con){
		try{
			$hari_arr	= array("senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu"); 
			$hari1		= array_search($_POST["ctl_hari_1"], $hari_arr); $hari2		= array_search($_POST["ctl_hari_2"], $hari_arr); $indexhari	= $hari1;
			
			$waktu1		= $_POST["ctl_mulai"]; $waktu2		= $_POST["ctl_selesai"];
			
			$query		= "SELECT kode_ajaran, kode_prodi, semester, kode_rencana_studi, kode_kelas, count(*) as 'peserta' FROM civitas_perwalian
							where kode_ajaran = '".$_POST["f_kode_ajaran"]."'
							group by kode_ajaran, kode_prodi, semester, kode_rencana_studi, kode_kelas
							order by kode_ajaran, kode_prodi, semester, kode_rencana_studi, kode_kelas ";
			
			$state 		= execquery("jadwal_kuliah","delete from jadwal_kuliah");
			
			$waktu		= $waktu1;
			$result		= mysqli_query($con, $query);
			while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
			{				
				$kode_ajaran	= $row["kode_ajaran"];
				$kode_prodi		= $row["kode_prodi"];
				$semester		= $row["semester"];
				$kode_rs		= $row["kode_rencana_studi"];
				$kode_kelas		= $row["kode_kelas"];
				$peserta		= $row["peserta"];
				
				$data			= array("indexhari"=>$indexhari,"hari1"=>$hari1,"hari2"=>$hari2, "waktu"=>$waktu, "waktu1"=>$waktu1, "waktu2"=>$waktu2, "kode_ajaran"=>$kode_ajaran, 
									"kode_prodi"=>$kode_prodi, "semester"=>$semester, "kode_rs"=>$kode_rs, "kode_kelas"=>$kode_kelas, "peserta"=>$peserta);
				$return			= bentuk_jadwal($data);
				
				$indexhari		= $return["indexhari"];
				$waktu			= $return["waktu"];
			}
			
			echo '[{"state":"1","msg":"success"}]';
		}
		catch(Exception $e) {
			echo '[{"state":"0","msg":"'.$e->getMessage().'"}]';
		}
	}
	
	function bentuk_jadwal($data){
		$hari_arr		= array("senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu"); 
		$indexhari		= $data["indexhari"];
		$hari1			= $data["hari1"];
		$hari2			= $data["hari2"];
		$waktu			= $data["waktu"];
		$waktu1			= $data["waktu1"];
		$waktu2			= $data["waktu2"];
		$kode_ajaran	= $data["kode_ajaran"];
		$kode_prodi		= $data["kode_prodi"];
		$semester		= $data["semester"];
		$kode_rs		= $data["kode_rs"];
		$kode_kelas		= $data["kode_kelas"];
		$peserta		= $data["peserta"];
		
		$jadwal_baru	= true;
				
		while($jadwal_baru){			
			$hari		= $hari_arr[$indexhari];
			
			$kode_mk	= execqueryreturn("rencana_studi", "select kode_mk from rencana_studi where kode_rencana_studi = '".$kode_rs."' ");
			$sks		= execqueryreturn("mata_kuliah", "select sks from mata_kuliah where kode_mk = '".$kode_mk."' ");
			$waktusks	= (execqueryreturn("waktu_per_sks", "select waktu from waktu_per_sks where id = '1' ")) * $sks;
			
			$mulai 		= $waktu;
			$selesai	= add_time($waktu, $waktusks);
			
			if(strtotime($selesai) <= strtotime($waktu2) || $indexhari > $hari2){
				
					// Cek Dosen yang tersedia antara jam mulai s/d jam selesai
					$dosen		= execqueryreturn("mata_kuliah_dosen", "select nidn from mata_kuliah_dosen where kode_mk = '".$kode_mk."' and nidn not in (select nidn from jadwal_kuliah 
									where hari = '".$hari."' and 
									(('".$mulai."' >= mulai and '".$mulai."' <= selesai) or ('".$selesai."' >= mulai and '".$selesai."' <= selesai))) limit 0, 1 ");
										
					if($dosen){
						// Cek Ruang yang tersedia antara jam mulai s/d jam selesai
						$kapasitas_ruang = 0;
						$ruang		= execqueryreturn("ruang", "select kode_ruang from ruang where kapasitas_kuliah >= ".$peserta."  and 
										kode_ruang not in (select kode_ruang from jadwal_kuliah where hari = '".$hari."' and 
										(('".$mulai."' >= mulai and '".$mulai."' <= selesai) or ('".$selesai."' >= mulai and '".$selesai."' <= selesai))) 
										order by kapasitas_kuliah limit 0, 1 ");
						if(!$ruang){
							/*$ruang		= execqueryreturn("ruang", "select kode_ruang from ruang where  
										kode_ruang not in (select kode_ruang from jadwal_kuliah where hari = '".$hari."' and 
										(('".$mulai."' >= mulai and '".$mulai."' <= selesai) or ('".$selesai."' >= mulai and '".$selesai."' <= selesai))) limit 0, 1 ");
							
							if(!$ruang){$ruang = 0;}*/
							$ruang = 0;
						}
						
						if($ruang != '0'){
							$jadwal_exist = execqueryreturn("jadwal_kuliah", "select count(*) from jadwal_kuliah where kode_ajaran = '".$kode_ajaran."' 
									and kode_prodi = '".$kode_prodi."' and hari = '".$hari."' and 
									(kode_ruang = '".$ruang."' or kode_mk in (select kode_mk from rencana_studi where semester = ".$semester.") )
									and (('".$mulai."' >= mulai and '".$mulai."' <= selesai) or ('".$selesai."' >= mulai and '".$selesai."' <= selesai)) ");
									
							if($jadwal_exist <= 0){
								$kode_jadwal 	= $kode_kelas.(array_search($hari, $hari_arr)+1);
								$query 			= "insert into jadwal_kuliah values('".$kode_jadwal."', '".$kode_ajaran."', '".$kode_prodi."', 
													'".$hari."', '".$mulai."', '".$selesai."', '".$kode_mk."', '".$dosen."', '".$kode_kelas."', '".$ruang."', 
													now(), 1 )";
								$state 			= execquery("jadwal_kuliah",$query);
								$waktu 			= add_time($selesai, 15);
								
								$jadwal_baru	= false;
							}
							else{
								$waktu = add_time($selesai, 15);
							}
						}
						else{
							$waktu = add_time($selesai, 15);
						}
						
					}
					else{
						$waktu = add_time($selesai, 15);
					}
			}
			else{
				$indexhari++;
				if($indexhari > $hari2){
					$indexhari		= $hari1;
					$jadwal_baru	= false;
				}					
				
				$waktu				= $waktu1;
			}
			
		}
		$return["indexhari"]	= $indexhari;
		$return["waktu"]		= $waktu;
		
		return $return;
	}
	
	function bentuk_kelas($kode_kelas){
		
	}
	
	function add_time($waktu, $minutes){
		$start		= strtotime($waktu);
		$end 		= strtotime('+'.$minutes.' minutes', $start);
		
		return date('H:i', $end);
	}
	
	function generate_code($h, $k){
		$hari 		= array("senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu");
		$indexhari	= array_search($h, $hari);
		$code 		= $k.($indexhari+1);
		
		return $code;
	}
	
?>




