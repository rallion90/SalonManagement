<?php include('../connection.php');?>
<?php
session_start();

if(isset($_SESSION['employee_id'])){
  $employee_id = $_SESSION['employee_id'];
  $get_record = mysqli_query($connect, "SELECT * FROM employee WHERE employee_id='$employee_id'");
  $row1 = mysqli_fetch_assoc($get_record);
  $db_username = $row1['username'];

  echo "<script>window.location.href='index.php';</script>";
}

	$employee_username = $employee_password = "";
	$employee_usernameErr = $employee_passwordErr = "";

	if(isset($_POST['employee_submit'])){
		if(empty($_POST['employee_username'])){
			$employee_usernameErr = "This Field Required";
		}
		else{
			$employee_username = mysqli_real_escape_string($connect, $_POST['employee_username']);
		}

		if(empty($_POST['employee_password'])){
			$employee_passwordErr = "This Field Required";
		}
		else{
			$employee_password = $_POST['employee_password'];
		}

		if($employee_username && $employee_password){
			 $employe_usernameLen = strlen($employee_username);
			 if($employe_usernameLen < 5){
			 	$employee_usernameErr = "Username is too short";
			 }
			 else{
			 	$check_employee_username = mysqli_query($connect, "SELECT * FROM employee WHERE username='$employee_username'");
        		$check_employee_username_row = mysqli_num_rows($check_employee_username);

        		if($check_employee_username_row > 0){
        			$row = mysqli_fetch_assoc($check_employee_username);
          			$employee_id = $row['employee_id'];
          			$db_password = $row['password'];

          			if($employee_password == $db_password){
          				$_SESSION['employee_id'] = $employee_id;
          				header('Location: basic_table.php');
          			}
          			else{
          				$employee_passwordErr = "Invalid Password";
          			}

        		}
        		else{
        			$employee_usernameErr = "Employee Username is not Registered";
        		}

			 }

		}

	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Employee</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="post">
					
					<span class="login100-form-title">
						Employee Login
					</span>
					

					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="employee_username" placeholder="Username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div><span><?php echo $employee_usernameErr;?></span>

					<div class="wrap-input100 validate-input">
						
						<input class="input100" type="password" name="employee_password"  placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div><?php echo $employee_passwordErr;?></span>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="employee_submit">
							Login
						</button>
					</div>

					

					
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>