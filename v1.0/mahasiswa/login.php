
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
		
		<title>Sistem Informasi Manajemen Akademik</title>
		
		<style>
			.login{
				background:rgba(51,122,183,0.9) ; color:white;
				position:fixed;
				top:10%; left:2%; padding:2%;
				width:25%; height:80%;
				border-radius: 10px 10px 10px 10px;
				-moz-border-radius: 10px 10px 10px 10px;
				-webkit-border-radius: 10px 10px 10px 10px;
			}
			.login-form{
				background:rgba(16,91,156,1);
				position:absolute; width:110%;
				top:60%; left:5%;
				padding:10%;
				border-radius: 0px 10px 0px 10px;
				-moz-border-radius: 0px 10px 0px 10px;
				-webkit-border-radius: 0px 40px 0px 40px;
			}
			.login-form button{
				font-weight:bold; 
			}
			.login-form a{
				color:white; font-weight:bold; font-size:12px; margin-left:20px;
			}
			.login-form a:hover{
				text-decoration:underline;
			}
		</style>
	</head>	
	<body id="body" style="background:url('images/mahasiswa.jpg') no-repeat center center fixed; -webkit-background-size: cover;">
	<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
	<div class="login">
		<h1><strong>MAHASISWA</strong></h1>
		<div class="login-form">
			<div class="form-group"><input type="text" name="uid" value="" class="form-control input-sm" placeholder="USERNAME / NIM" /></div>
			<div class="form-group"><input type="password" name="pwd" value="" class="form-control input-sm" placeholder="PASSWORD" /></div>
			<div class="form-group">
				<input type="submit" name="login" value="login" style="display:none" />
				<button type="button" class="btn btn-warning " style="width:100px" onclick="$('input[name=login]').click()" ><span class="glyphicon glyphicon-user"></span> Masuk</button>
				<a href="#" ><i>Lupa Password</i></a>
			</div>
			<div class="form-group" style="color:yellow; font-weight:bold"><?php if($login){echo $msg;} ?></div>
		</div>
	</div>
	</form>
	</body>
</html>