<?php
 include('../connection.php');
 session_start();
if(isset($_SESSION['db_admin_id'])){
    $db_admin_id = $_SESSION['db_admin_id'];
    $get_dbrecord = mysqli_query($connect, "SELECT * FROM admin WHERE admin_id='$db_admin_id'");
    $row = mysqli_fetch_assoc($get_dbrecord);
    $db_aid = $row['admin_id'];
    $db_admin_name = ucfirst($row['username']);


}

$messageReg = "Your Earned 2 points. Please let us know your Feedback.\n-ADMIN";
$apicode = "TR-RALLI759946_F4ASR";
$mobile_number = "";

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

if(isset($_GET['haircut_id'])){
	$haircut_id = $_GET['haircut_id'];
	$pointsUp = 2;

	$get_rec = mysqli_query($connect, "SELECT  * FROM booking WHERE booking_id='$haircut_id'");
	$get_data = mysqli_fetch_assoc($get_rec);
	$db_user_id = $get_data['user_id'];
    $sales = $get_data['not_pay_price'];

	$result = mysqli_query($connect, "UPDATE login SET points = points + $pointsUp WHERE user_id='$db_user_id'");
	$get_data = mysqli_query($connect, "SELECT * FROM login WHERE user_id='$db_user_id'");
	$row1 = mysqli_fetch_assoc($get_data);
	$mobile_number = $row1['mobile_number'];
    $get_cust_id = $row1['user_id'];
    $add_sales = mysqli_query($connect, "UPDATE sales SET sales_amount = sales_amount + $sales");

    if($add_sales){
	   $trigger_with_delete = mysqli_query($connect, "DELETE FROM booking WHERE booking_id='$haircut_id'");
       if($trigger_with_delete){
            mysqli_query($connect, "UPDATE login SET reserved_pending='0' WHERE user_id='$get_cust_id'");
            $result = itexmo($mobile_number,$messageReg,$apicode);
            if ($result == ""){
                echo "iTexMo: No response from server!!!
                    Please check the METHOD used (CURL or CURL-LESS). If you are using CURL then try CURL-LESS and vice versa.  
                    Please CONTACT US for help. ";  
            }
            else if ($result == 0){
                header('Location: basic_table.php');
            }
            else{   
                echo "Error Num ". $result . " was encountered!";
            }
        }
    }

    	
}
