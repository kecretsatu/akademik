
<?php
	include ('koneksi.php');
	$con=koneksi();
	
	$query	= "select * from information_schema.tables where table_schema = 'simak'";
	
	$result	= mysqli_query($con, $query);
	execquery('table_alias', 'delete from table_alias');
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		if($row["TABLE_NAME"] != 'table_alias'){
			execquery("table_alias", "insert into table_alias values ('".$row["TABLE_NAME"]."','".md5($row["TABLE_NAME"])."')");
		}
	}
	echo 'ok';
?>