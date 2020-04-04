<?php session_start();?>

<?php
include('connection.php');

$messageReg ="Your points reach 100 show this code to get discount";
$mobile_number = "";
$apicode = "TR-RALLI605221_K56DA";
$message = "";
$reserved = "";

$get_all_services_hc = mysqli_query($connect, "SELECT * FROM services WHERE service_category='1'");
$get_all_services_r = mysqli_query($connect, "SELECT * FROM services WHERE service_category='2'");
$get_all_services_atl = mysqli_query($connect, "SELECT * FROM services WHERE service_category='3'");
$get_all_services_faas = mysqli_query($connect, "SELECT * FROM services WHERE service_category='4'");
$get_all_services_lot = mysqli_query($connect, "SELECT * FROM services WHERE service_category='5'");
$get_all_services_ot = mysqli_query($connect, "SELECT * FROM services WHERE service_category='6'");

	/*function itexmo($mobile_number,$messageReg,$apicode){
		$url = 'https://www.itexmo.com/php_api/api.php';
		$itexmo = array('1' => $mobile_number, '2' => $messageReg, '3' => $apicode);
		$param = array(
		            'http' => array(
		            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		            'method'  => 'POST',
		            'content' => http_build_query($itexmo),
		        ),
		);
		$context  = stream_context_create($param);
		return file_get_contents($url, false, $context);
	}*/

	if(isset($_POST['send'])){
		$name = $_POST['name'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$message = $_POST['message'];
		$emailError = "";

		if($name){
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$emailError = "Invalid Email Address";
			}
			else{
				$insert_message = mysqli_query($connect, "INSERT INTO message (name, email, phone, message) VALUES ('$name', '$email', '$phone', '$message')");
				if($insert_message){
					header("Location: about.php?send=succesfully");
				}
				else{
					echo "Error";
				}
			}
		}
	}

	if(isset($_SESSION['user_id'])){
		$user_id = $_SESSION['user_id'];
		$check_account = mysqli_query($connect, "SELECT * FROM login WHERE user_id='$user_id'");
		$row2 = mysqli_fetch_assoc($check_account);
		$db_account_condition = $row2['account_condition'];
		$mobile_number = $row2['mobile_number'];
		
		if($db_account_condition === "1"){
			unset($_SESSION['user_id']);
			header("Location: login.php?account=banned");
		}
	}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Gleam and Glam Salon!</title>
	<!-- CSS-->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

	<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
	<script src="js/jquery-1.12.4.js"></script>
  	<script src="js/jquery-ui.js"></script>
	<style type="text/css">
		.ml-auto .dropdown-menu {
		    left: auto !important;
		    right: 0px;
		}
	</style>
	<script>
	 jQuery(function($){ // wait until the DOM is ready
        $(".datepicker").datepicker({
        	dateFormat: 'yy-mm-dd'
        });

        $('.timepicker').timepicker({
		    timeFormat: 'h:mm p',
		    interval: 60,
		    minTime: '10',
		    maxTime: '6:00pm',
		    defaultTime: '11',
		    startTime: '10:00',
		    dynamic: false,
		    dropdown: true,
		    scrollbar: true
		});
     });


	</script>


</head>
<body>
	
	<nav class="navbar navbar-expand-md navbar-light bg-light">
    	<div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
    		<!--<img src="images/brand.jpg" class="navbar-brand" width="80" height="80">-->
	        <ul class="navbar-nav mr-auto">
	            <li class="nav-item active">
	                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
	            </li>
	            <li class="nav-item">
	                 <a class="nav-link" href="about.php">About Us</a>
	            </li>
	            <li class="nav-item">
	                 <a class="nav-link" href="haircut.php">Booking</a>
	            </li>
	        </ul>
	    </div>
	    <?php 
	      	include('connection.php');
	      	if(isset($_SESSION['user_id'])){
	      		$user_id = $_SESSION['user_id'];
				$get_record = mysqli_query($connect, "SELECT * FROM login WHERE user_id='$user_id'");
				$row = mysqli_fetch_assoc($get_record);
				$db_username = ucfirst($row['fullname']);
				$db_points = $row['points'];

				
			  	echo "<div class='mx-auto order-0'> 
			  					        			
		    			</div>
		    			<div class='navbar-collapse collapse w-100 order-3 dual-collapse2'>
		    			<div title='Note: If you reach 100 points you will be discounted'>Points: &nbsp;<b>$db_points </b></div>
			        		<ul class='navbar-nav ml-auto'>
						       <li class='nav-item dropdown'>
							        <a class='nav-link dropdown-toggle' href='#'' id='navbarDropdownMenuLink' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
							          <i class='fas fa-user'></i>&nbsp;$db_username
							        </a>
							        <div class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'>
							          <a class='dropdown-item' href='profile.php'>Profile</a>
							          <a class='dropdown-item' href='user_dashboard.php'>My Booking</a>
							          <a class='dropdown-item' href='logout.php'>Logout</a>
							        </div>
							    </li>
						    </ul>
					    </div>";
	  	    }else{
	  	    	echo "<div class='mx-auto order-0'>
	  	    			<div class'navbar-collapse collapse w-100 order-3 dual-collapse2'>
		  	    			<ul class='navbar-nav ml-auto'>
			  	    		  <li class='nav-item'>
				        		<a class='nav-link'  href='login.php'>Login</a>
				      		  </li>
				      		</ul>
				      	</div>  
			      	  </div>";
	  	    }
	      ?>
	</nav>






