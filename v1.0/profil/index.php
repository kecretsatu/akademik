
<?php
	session_start();
	//include 'modul/koneksi.php';
	//$con = koneksi();

	$BASE_URL	= 'http://localhost/simak/profil';
	$JS_URL		= '';
	
	$URL		= $_SERVER['REQUEST_URI'];
	$REQUEST_URI= strtok($URL,'?');
	
	/*if(!isset($_SESSION["login"])){
		include 'login.php';
		exit;
	}*/
	
	$pageURL	= str_replace('/simak/profil/','',$REQUEST_URI);
	
	$pageURL	= explode('/',$pageURL);
	$pageDir	= '';
	$pageREQ	= '';
	$pageForm	= '';
	if(count($pageURL) > 0){
		$pageDir = $pageURL[0];
		$JS_URL	 = '';
	}
	if(count($pageURL) > 1){
		$pageREQ = $pageURL[1];
		$JS_URL	 = '../';
	}
	if(count($pageURL) > 2){
		$pageForm = $pageURL[2];
		
		$JS_URL	 = '../../';
	}
	
	
	$paramsURL	= false;	
	if (strpos($URL,'?') !== false) {
		$pageFormSplit	= explode("?",$URL);
		$paramsURL		= $pageFormSplit[1];
	}
?>

<!DOCTYPE html>
<html lang="en">
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?php echo $BASE_URL ;?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $BASE_URL ;?>/css/style.css" rel="stylesheet">
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="<?php echo $BASE_URL ;?>/bootstrap/js/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="<?php echo $BASE_URL ;?>/bootstrap/js/bootstrap.min.js"></script>
				
		<link href="<?php echo $BASE_URL ;?>/bootstrap/css/bootstrap-timepicker.min.css" rel="stylesheet">
        <script src="<?php echo $BASE_URL ;?>/bootstrap/js/bootstrap-timepicker.js"></script>
		
		<link href="<?php echo $BASE_URL ;?>/bootstrap/css/datepicker.css" rel="stylesheet">
        <script src="<?php echo $BASE_URL ;?>/bootstrap/js/bootstrap-datepicker.js"></script>
		
		<script>var JS_URL = '<?php echo $JS_URL; ?>';</script>
		<script src="<?php echo $BASE_URL ;?>/js/script.js"></script>
		
		<title>Sistem Informasi Manajemen Akademik</title>
	</head>	
	<body>
		<div  class="body">
			<?php include "header.php"; ?>
			<?php include "banner.php"; ?>
			<?php include "content.php"; ?>
		</div>	
	</body>
</html>