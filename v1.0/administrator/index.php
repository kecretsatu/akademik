
<?php
	session_start();
	include 'modul/koneksi.php';
	$con = koneksi();

	$BASE_URL	= 'http://localhost/simak/administrator';
	$JS_URL		= '';
	
	$URL		= $_SERVER['REQUEST_URI'];
	$REQUEST_URI= strtok($URL,'?');
	
	if(!isset($_SESSION["userlogin"])){
		include 'login.php';
		exit;
	}
	
	$pageURL	= str_replace('/simak/administrator/','',$REQUEST_URI);
	
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
		<script src="<?php echo $BASE_URL ;?>/js/datacrud.js"></script>
		<script src="<?php echo $BASE_URL ;?>/js/dataview.js"></script>
		
		<title>Sistem Informasi Manajemen Akademik</title>
	</head>	
	<body id="body">
	
	<?php include "views/header.php"; ?>
	
	<?php
		if($pageDir == 'dashboard'){
			include "views/".$pageDir.".php";
		}
		else{
			if ($pageForm != ''){
				include "form/".$pageDir."/m_".$pageREQ.".php";
			}
			else{
				try{
					include "views/".$pageDir."/".$pageREQ.".php";
				}
				catch(Exception $e) {
					echo '';
				}
			}
		}
	?>
	
	<?php include "modal/formCari.php"; ?>
	<?php include "modal/formModalPage.php"; ?>
	
	</body>
</html>