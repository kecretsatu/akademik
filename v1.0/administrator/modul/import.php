<?php
	header('Content-type: application/json');

	include ('koneksi.php');
	$con=koneksi();
	$result;
	$query = '';
	
	try{
		if(isset($_POST['name'])){
			$name = $_POST['name'];
			if($name == 'perpustakaan'){import_perpustakaan($con);}
		}	
		
	}
	catch(Exception $e) {
		echo '[{"state":"0","msg":"'.$e->getMessage().'"}]';
	}
	
	function import_mahasiswa(){
			
	}
	
	function import_perpustakaan($con){
		if(isset($_FILES["file"])){
			$data = csv_to_array($_FILES["file"]);
			if(!$data){
				echo '[{"state":"0","msg":""}]';
				exit;
			}
			
			$code	= execqueryreturn("table_alias", "select DATE_FORMAT(sysdate(1),'%d%m%Y%H%i%s') from table_alias limit 0, 1");
			$n = 0;
			foreach($data as $row){				
				$prime	= $code . build_number($n, 3);
				$query	= "insert into perpustakaan_katalog values ('".$prime."', '".$_POST["ctl_kode_group"]."', '".$_POST["ctl_kode_kategori"]."', 
							'".mysqli_real_escape_string($con, $row[0])."', '".mysqli_real_escape_string($con, $row[1])."', 
							'".mysqli_real_escape_string($con, $row[2])."', '', '".mysqli_real_escape_string($con, $row[3])."', now(), 1)";
				execquery("perpustakaan_katalog", $query);
				$n++;
			}
			
			echo json_encode($data[0]);
		}
	}
	
	function csv_to_array($file){
		$code			= execqueryreturn("table_alias", "select DATE_FORMAT(sysdate(1),'%d%m%Y%H%i%s%f') from table_alias limit 0, 1");
		$target_dir		= "temp/";
		$target_file	= $target_dir . $code . ".csv";
		try{
			move_uploaded_file($file["tmp_name"], $target_file);
			$handle = fopen($target_file, "r");
			if ($handle) {
				$data = array(); $header = array(); $row = 0;
				while (($lines = fgets($handle)) !== false) {
					if($row > 0){
						$line = explode(";", $lines);
						$data[]		= $line;
					}
					$row++;
				}

				fclose($handle);
				return $data;
			} else {
				return false;
			} 
			
		}
		catch(Exception $e) {
			return false;
		}
	}
	
	function build_number($val, $len){
		$number = '';
		
		for($i = 1; $i <= $len - (strlen($val)); $i++){
			$number .= '0';
		}
		$number .= $val;
		
		return $number;
	}

?>











