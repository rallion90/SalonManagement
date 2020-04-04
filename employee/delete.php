 <?php
 include('../connection.php');

if(isset($_GET['user_id'])){
    $id = $_GET['user_id'];
    $result = mysqli_query($connect, "DELETE FROM booking WHERE booking_id='$id'");
    if($result){
    	mysqli_query($connect, "UPDATE login SET reserved_pending='0' WHERE user_id='$id'");
    	header("location: basic_table.php");
    } 
	
	else{ 
		echo "GET NOT SET";
	}	
}
?>    