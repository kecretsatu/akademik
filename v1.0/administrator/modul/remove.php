<?php
	header('Content-type: application/json');

	include ('koneksi.php');
	$con=koneksi();
	$result;
	$query = '';
	
	try{
		if(isset($_POST['name'])){
			$tabel = getTableAlias(0, $_POST['name']);
			$columns = getColumns($tabel); $columnPrimary = '';
			foreach ($columns as $col) {
				if(!$col[3]){}else{$columnPrimary = "".$col[0]." = '".$_POST["ctl_".$col[0]]."'";}
			}
			//$isExist 	= execqueryreturn($_POST['name'], "select count(*) from ".$tabel." where ".$columnPrimary);
			
			$result		= mysqli_query($con, "select * from ".$tabel." where ".$columnPrimary);
			$rows 		= array();
			while($row	= mysqli_fetch_array($result, MYSQLI_ASSOC))
			{
				$rows[] = $row;
			}
			$data = json_encode($rows);
			
			$query		= "delete from ".$tabel." where ".$columnPrimary;						
			$state		= execquery($tabel,$query);
			if($state == 1){				
				$query		= "insert into z_log_remove(user_id, table_name, data_remove, date_remove) values ('11111', '".$tabel."', '".$data."', now())";
				$state2		= execquery($tabel,$query);
				if($state2 == 1){
					echo '[{"state":"1","msg":"success"}]';
				}
				else{
					echo '[{"state":"0","msg":"'.$state.'"}]';
				}
			}
			else{
				echo '[{"state":"0","msg":"'.$state.'"}]';
			}
		}	
		
	}
	catch(Exception $e) {
		echo '[{"state":"0","msg":"'.$e->getMessage().'"}]';
	}

?>