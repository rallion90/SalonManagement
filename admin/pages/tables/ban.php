<?php include("../../../connection.php");?>

<?php
	$get_id = $_GET['id'];
	$messageReg = "Your Gleam and Glam Account has been Banned by the admin because of malicious activity";
    $apicode = "TR-RALLI759946_F4ASR";

    $get_record = mysqli_query($connect, "SELECT * FROM login WHERE user_id='$get_id'");
    $fetch_record = mysqli_fetch_assoc($get_record);
    $db_number = $fetch_record['mobile_number'];

    function itexmo($db_number,$messageReg,$apicode){
        $url = 'https://www.itexmo.com/php_api/api.php';
        $itexmo = array('1' => $db_number, '2' => $messageReg, '3' => $apicode);
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

   

	$banAlert = mysqli_query($connect, "UPDATE login SET account_condition='1' WHERE user_id='$get_id'");

	if($banAlert){
		$result = itexmo($db_number,$messageReg,$apicode);
	    if ($result == ""){
	        echo "iTexMo: No response from server!!!
	              Please check the METHOD used (CURL or CURL-LESS). If you are using CURL then try CURL-LESS and vice versa.  
	              Please CONTACT US for help. ";  
	    }
	    else if ($result == 0){
	        header("Location: basic-table.php");
	    }
	    else{   
	        echo "Error Num ". $result . " was encountered!";
	    }
	}
	
	
?>