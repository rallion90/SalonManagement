<?php include('nav.php');?>
<br>
<?php
include('connection.php');
	$price = "";
	$cut = "";
	$fullname = "";
	$date = "";
	$fullnameErr = "";
	$dateErr = "";
	$reserved = "";
	$haircut = "";
	$barber = "";
	$barberErr = "";
	$haircutErr = "";
	$time = "";
	$timeErr = "";
	$rand_num = rand(111111, 999999);
	$messageReg = "Your Verification Code is $rand_num. Please show at the cashier. \n -Admin";
    $apicode = "TR-RLPHP294892_CC2G3";
    $get_mobile_number = "";
    $fullError = "";
    $session_id1 = $_SESSION['user_id'];

	//##########################################################################
	// ITEXMO SEND SMS API - PHP - CURL-LESS METHOD
	// Visit www.itexmo.com/developers.php for more info about this API
	//##########################################################################
	function itexmo($get_mobile_number,$messageReg,$apicode){
	    $url = 'https://www.itexmo.com/php_api/api.php';
	    $itexmo = array('1' => $get_mobile_number, '2' => $messageReg, '3' => $apicode);
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

	if(isset($_GET['services']) &&  $_GET['price']){
		$cut = base64_decode(urldecode($_GET['services']));
		$price = base64_decode(urldecode($_GET['price']));
	}
	

	if(isset($_GET['reserved']) == 'success'){
  		$reserved = "Succesfully Reserved";
 	}

	if(isset($_SESSION['user_id'])){
		$user_id = $_SESSION['user_id'];
		$get_record = mysqli_query($connect, "SELECT * FROM login WHERE user_id='$user_id'");
		$row = mysqli_fetch_assoc($get_record);
		$db_name = $row['fullname'];
	}else{
		header("Location: login.php?forbidden=not_allowed");
	}

	if(isset($_POST['submit'])){

		$session_id = $_SESSION['user_id'];
		$mobile_number = mysqli_query($connect, "SELECT * FROM login WHERE user_id='$session_id'");
		$fetch_number = mysqli_fetch_assoc($mobile_number);
		$get_mobile_number = $fetch_number['mobile_number'];

		//$rand_num = rand(111111, 999999);

		if(empty($_POST['fullname'])){
			$fullnameErr = "Field Required";
		}
		else{
			$fullname = $_POST['fullname'];
		}

		if(empty($_POST['date'])){
			$dateErr = "Field Required";
		}
		else{
			$date = $_POST['date'];
		}

		if(empty($_POST['time'])){
			$timeErr = "Field Required";
		}
		else{
			$time = $_POST['time'];
		}

		//if(empty($_POST['haircut'])){
		//	$haircutErr = "Field Required";
		//}
		

		


		if($fullname && $date && $time && $rand_num){
			
			
			$result = mysqli_query($connect, "INSERT INTO booking(user_id, fullname, service_name, not_pay_price, date_reserved, time_reserved, verification_code, booking_condition)
				VALUES ('$user_id', '$fullname', '$cut', '$price', '$date', time(STR_TO_DATE('$time', '%h:%i %p')), '$rand_num', '0')");

			if($result){
				$result = itexmo($get_mobile_number,$messageReg,$apicode);
                if ($result == ""){
                    echo "iTexMo: No response from server!!!
                        Please check the METHOD used (CURL or CURL-LESS). If you are using CURL then try CURL-LESS and vice versa.  
                        Please CONTACT US for help. ";  
                }
                else if ($result == 0){
                    echo '<script language="javascript">';
					echo 'alert("Your Reservation has been sent, Please check your phone and Save the verification code.")';
					echo '</script>';
					mysqli_query($connect, "UPDATE login SET reserved_pending='1' WHERE user_id='$session_id'");
					echo "<script>window.location.href='index.php';</script>";
                }
                else{   
                    echo "Error Num ". $result . " was encountered!";
                }
				
			}else{
				header("Location: haircut.php");
			}

		}

	}

?>
<style type="text/css">
	.error{
		color:red;
	}

	.success{
		color:grey;
	}
</style>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Haircut Reservation</div>
                <div class="card-body">
                	<span class="success"><?php echo $reserved;?></span>
                    <form method="post">
                    	<p style="color:red">Important!<br>* Please be at the salon 5-10 minutes before your scheduled appointment.<br>* Save the verification number and show it at the cashier.</p>

                   	
                   		<div class="form-group row">                             
                            <label for="full_name" class="col-md-4 col-form-label text-md-right">Full Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="fullname" value="<?php echo $db_name;?>">
                            </div><span class="error"><?php echo $fullnameErr;?></span>
                        </div>

                       <div class="form-group row">
					      <label for="sel1" class="col-md-4 col-form-label text-md-right">Price</label>
					      	<div class="col-md-6">
						      <input type="text" disabled class="form-control" name="fullname" value="<?php echo $price;?>">
						    </div>  
					    </div>
                        <!--<div class="form-group row">
						  <label for="full_name" class="col-md-4 col-form-label text-md-right">Barber Name</label>
						  &nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    Choose Barber
						  </button>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="#">Laynes</a>
						    <a class="dropdown-item" href="#">Caberto</a>
						    <a class="dropdown-item" href="#">Rosario</a>
						  </div>
						</div>-->
						

					    <div class="form-group row">                             
                            <label for="full_name" class="col-md-4 col-form-label text-md-right">Services</label>
                            <div class="col-md-6">
                                <input type="text" disabled class="form-control" name="haircut" value="<?php echo ucwords(mysql_real_escape_string($cut));?>">
                            </div><span class="error"><?php echo $haircutErr;?></span>
                        </div>

						
						
						
						<div class="form-group row">                             
                            <label for="date" class="col-md-4 col-form-label text-md-right">Date</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control datepicker" name="date">
                            </div><span class="error"><?php echo $dateErr;?></span>
                        </div>

                        <div class="form-group row">                             
                            <label for="sel1" class="col-md-4 col-form-label text-md-right">Select Employee</label>
					      	<div class="col-md-6">
						      <select class="form-control" name="time" id="sel1">
						      	<option>Select Time</option>
						        <option value="8:00 AM">8:00 AM</option>
						        <option value="8:30 AM">8:30 AM</option>
						        <option value="9:00 AM">9:00 AM</option>
						        <option value="9:30 AM">9:30 AM</option>
						        <option value="10:00 AM">10:00 AM</option>
						        <option value="10:30 AM">10:30 AM</option>
						        <option value="11:00 AM">11:00 AM</option>
						        <option value="11:30 AM">11:30 AM</option>
						        <option>--Lunch Break--</option>
						        <option value="1:00 PM">1:00 PM</option>
						        <option value="1:30 PM">1:30 PM</option>
						        <option value="2:00 PM">2:00 PM</option>
						        <option value="2:30 PM">2:30 PM</option>
						        <option value="3:00 PM">3:00 PM</option>
						        <option value="3:30 PM">3:30 PM</option>
						        <option value="4:00 PM">4:00 PM</option>
						        <option value="4:30 PM">4:30 PM</option>
						        <option value="5:00 PM">5:00 PM</option>
						   </select>
						    </div>  
                        </div>
					<?php 
						$check_pending = mysqli_query($connect, "SELECT * FROM login WHERE user_id='$session_id1'");
						$get_check = mysqli_fetch_assoc($check_pending);
						$get_pend = $get_check['reserved_pending'];
						if($get_pend == "1"){
					?>
					<script>
						alert("You have pending Reservation!");
					</script>
							<div class="col-md-6 offset-md-4">
	                            <button type="submit" disabled class="btn btn-primary">
	                                Reserved
	                            </button>

                        	</div>
					<?php
						}else{
					?>
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" name="submit" class="btn btn-primary">
                                Reserved
                            </button>
                        </div>
                    <?php
                    	}
                    ?>    
                        <br>
                        <div class="col-md-6 offset-md-4">
                            <a href='index.php' class='btn btn-primary'>Cancel</a>
                        </div>     	                               
                    </form>
                </div>            
            </div>
        </div>
    </div>
</div>

<?php include('footer.php');?>