
<?php
	$login = false; $msg = '';
	if(isset($_POST["login"])){
		$login = true;
		if($_POST["uid"] == "08390100041" && $_POST["pwd"] == "admin123"){
			$_SESSION["userlogin"] = $_POST["uid"];
			header('Location: '.$_SERVER['REQUEST_URI'].'dashboard');
			exit;
		}
		else{
			$msg = 'Maaf, username atau password anda salah.';
		}
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
		
		<title>PORTAL Sistem Informasi Manajemen Akademik</title>
		
		<style>
			
			.login-form {
				width:100%;
			}
			.login-form .form-control{
				width:100%; margin-bottom:3px;
			}
		</style>
	</head>	
	<body >
	<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
	<div class="form-group form-inline row ">
		<div class= "col-md-4"></div>
		<div class= "col-md-4 login" align="center">
			<div class="panel panel-primary menu "  >
				<div class="panel-heading"><h1><strong>Portal Area</strong></h1></div>
				<div class="panel-body" >
					<div align="left" class="form-group login-form">
						<input type="text" name="uid" value="" class="form-control" placeholder="USERNAME / NIM" />
						<input type="password" name="pwd" value="" class="form-control input-sm" placeholder="PASSWORD" />
						<input type="submit" name="login" value="login" style="display:none" />
						<button type="button" class="btn btn-warning " style="width:100px" onclick="$('input[name=login]').click()" >
							<span class="glyphicon glyphicon-user"></span> Masuk</button>
					</div>
					<!--<div class="login-form form-group col-md-12" style="width:100%">
						<div class="form-group"><input type="text" name="uid" value="" class="form-control input-sm" placeholder="USERNAME / NIM" /></div>
						<div class="form-group"><input type="password" name="pwd" value="" class="form-control input-sm" placeholder="PASSWORD" /></div>
						<div class="form-group">
							<input type="submit" name="login" value="login" style="display:none" />
							<button type="button" class="btn btn-warning " style="width:100px" onclick="$('input[name=login]').click()" ><span class="glyphicon glyphicon-user"></span> Masuk</button>
							<a href="#" ><i>Lupa Password</i></a>
						</div>
						<div class="form-group" style="color:yellow; font-weight:bold"><?php if($login){echo $msg;} ?></div>
					</div>-->
				</div>
			</div>
			
		</div>
		<div class= "col-md-4"></div>
	</div>
	
	</form>
	</body>
</html>