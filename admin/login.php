<?php include('../connection.php');?>
<?php
	session_start();
	$myip = $_SERVER['SERVER_ADDR'];
	$localIP = getHostByName(getHostName());

	//if($localIP != "192.168.1.10"){
	//	header("Location: forbidden.php");
	//}

	if(isset($_SESSION['db_admin_id'])){
	  $db_admin_id = $_SESSION['db_admin_id'];
	  $get_record = mysqli_query($connect, "SELECT * FROM admin WHERE admin_id='$db_admin_id'");
	  $row = mysqli_fetch_assoc($get_record);
	  $db_username = $row['username'];

	  echo "<script>window.location.href='index.php';</script>";
	}

	$usernameErr = $passwordErr = $username_or_passwordErr = "";

	if(isset($_POST['login_admin'])){
		$username = mysqli_real_escape_string($connect, $_POST['username']);
		$password = $_POST['password'];

		$userLen = strlen($username);
		if($userLen < 2){
			$usernameErr = "Your Username is too short";
		}else{
			$get_result = mysqli_query($connect, "SELECT * FROM admin");
			$result = mysqli_num_rows($get_result);

			if($result){
				$row = mysqli_fetch_assoc($get_result);
				$db_admin_id = $row['admin_id'];
				$db_username = $row['username'];
				$db_password = $row['password'];

				if($username == $db_username){
					if($password == $db_password){
						$_SESSION['db_admin_id'] = $db_admin_id;
						header("Location: index.php");
					}else{
						$username_or_passwordErr = "Username or Password Error";
					}
				}else{
					$username_or_passwordErr = "Username or Password Error";
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin Pane</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->

<style type="text/css">
	.error{
		color:red;
	}
</style>
</head>
<body>

	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-50 p-b-90">
				<form class="login100-form validate-form flex-sb flex-w" method="post">
					<span class="login100-form-title p-b-51">
						Login
					</span>
					<span class="error"><?php echo $username_or_passwordErr;?></span>
					<span class="error "><?php echo $usernameErr;?></span>
					<div class="wrap-input100 validate-input m-b-16" data-validate = "Username is required">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100"></span>
					</div>
					
					
					<div class="wrap-input100 validate-input m-b-16" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
					</div>
					
					

					<div class="container-login100-form-btn m-t-17">
						<button class="login100-form-btn" name="login_admin">
							Login
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>