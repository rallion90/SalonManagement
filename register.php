<?php
include('connection.php');
	$fullname = $mobile_number = $username = $password = $retype_password = $permanent_address = "";
	$fullnameErr = $mobile_numberErr = $usernameErr = $passwordErr = $retype_passwordErr = $permanent_addressErr = "";
    $messageReg = "Your point is 0. Every Succesful Register will add 2 points. Always check for announcement \n -Admin";
    $apicode = "TR-RLPHP294892_CC2G3";
    $fullError = "";

    //##########################################################################
    // ITEXMO SEND SMS API - PHP - CURL-LESS METHOD
    // Visit www.itexmo.com/developers.php for more info about this API
    //##########################################################################
    function itexmo($mobile_number,$messageReg,$apicode){
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
    }
    //##########################################################################
    
	if(isset($_POST['register'])){
		if(empty($_POST['fullname'])){
			$fullnameErr = "Field Required";
		}
		else{
			$fullname = $_POST['fullname'];
		}

		if(empty($_POST['mobile_number'])){
			$mobile_numberErr = "Field Required";
		}
		else{
			$mobile_number = $_POST['mobile_number'];
		}

		if(empty($_POST['username'])){
			$usernameErr = "Field Required";
		}
		else{
			$username = $_POST['username'];
		}

		if(empty($_POST['password'])){
			$passwordErr = "Field Required";
		}
		else{
			$password = md5($_POST['password']);
		}

		if(empty($_POST['retype_password'])){
			$retype_passwordErr = "Field Required";
		}
		else{
			$retype_password = md5($_POST['retype_password']);
		}

		if(empty($_POST['permanent_address'])){
			$permanent_addressErr = "Field Required";
		}
		else{
			$permanent_address = $_POST['permanent_address'];
		}

		if($fullname && $mobile_number && $username && $password && $retype_password && $permanent_address){
			if($retype_password != $password){
				$retype_passwordErr = "Password not match";
			}
			else{

                $account_check = mysqli_query($connect, "SELECT fullname, mobile_number, username FROM login WHERE (fullname='$fullname' OR mobile_number='$mobile_number' OR username='$username')");
                $check_count = mysqli_num_rows($account_check);

                if($check_count > 0){
                    $fullError = "Account Name or Username or Password is already Existed!";
                   
                }
                else{                  
                    $registration = mysqli_query($connect, "INSERT INTO login(fullname, mobile_number, username, password, permanent_address) VALUES ('$fullname', '$mobile_number', '$username', '$password', '$permanent_address')");

                    if($registration){    
                        $result = itexmo($mobile_number,$messageReg,$apicode);
                        if ($result == ""){
                            echo "iTexMo: No response from server!!!
                            Please check the METHOD used (CURL or CURL-LESS). If you are using CURL then try CURL-LESS and vice versa.  
                            Please CONTACT US for help. ";  
                        }
                        else if ($result == 0){
                            header("Location: login.php?status=success");
                        }
                        else{   
                            echo "Error Num ". $result . " was encountered!";
                        }
                    }  

                }
			}
		}
	}
?>
<?php include("nav.php");?>
<!DOCTYPE html>
<html>
<head>
  <title>Please Login</title>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link rel="stylesheet" type="text/css" href="css/login.css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<style type="text/css">
	.error{
		color:red;
	}
</style>
</head>
<body>
	<br>
	<main class="my-form">
    <div class="cotainer">
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                    <div class="card">
                        <center><span class="error"><?php echo $fullError;?></span></center>
                        <div class="card-header">Register</div>
                        <div class="card-body">
                            <form method="post">
                                <div class="form-group row">                             
                                    <label for="full_name" class="col-md-4 col-form-label text-md-right">Full Name</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="fullname">
                                    </div><span class="error"><?php echo $fullnameErr;?></span>
                                </div>

                                <div class="form-group row">
                                    <label for="email_address" class="col-md-4 col-form-label text-md-right">Mobile Number (+63)</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Ex. 09929186019" name="mobile_number">
                                    </div><span class="error"><?php echo $mobile_numberErr;?></span>
                                </div>

                                <div class="form-group row">
                                    <label for="user_name" class="col-md-4 col-form-label text-md-right">User Name</label>
                                    <div class="col-md-6">
                                        <input type="text"  class="form-control" name="username">
                                    </div><span class="error"><?php echo $usernameErr;?></span>
                                </div>

                                <div class="form-group row">
                                    <label for="user_name" class="col-md-4 col-form-label text-md-right">Password</label>
                                    <div class="col-md-6">
                                        <input type="password"   class="form-control" name="password">
                                    </div><span class="error"><?php echo $passwordErr;?></span>
                                </div>

                                <div class="form-group row">
                                    <label for="user_name" class="col-md-4 col-form-label text-md-right">Re-type Password</label>
                                    <div class="col-md-6">
                                        <input type="password"   class="form-control" name="retype_password">
                                    </div><span class="error"><?php echo $retype_passwordErr;?></span>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="permanent_address" class="col-md-4 col-form-label text-md-right">Permanent Address</label>
                                    <div class="col-md-6">
                                        <input type="text"  class="form-control" name="permanent_address">
                                    </div><span class="error"><?php echo $permanent_addressErr;?></span>
                                </div>

                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" name="register" class="btn btn-primary">
                                        Register
                                        </button>
                                    </div>
                                    <br>
                                    <div class="col-md-6 offset-md-4">
                                    	<a href="login.php" class="btn btn-primary">Cancel</a>
                                    </div>	
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>

</main>	

	
</body>
</html>