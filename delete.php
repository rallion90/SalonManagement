<?php include('connection.php');
	$id = $_GET['id'];
	//$deletion = mysqli_query($connect, "DELETE * FROM booking WHERE booking_id='$id'");

	$get_bin = mysqli_query($connect, "SELECT * FROM booking WHERE booking_id='$id'");
	$fetch_get_bin = mysqli_fetch_assoc($get_bin);

	if($get_bin){
		$raw_cust_id = $fetch_get_bin['user_id'];
		$raw_cust_full_name = $fetch_get_bin['fullname'];
		$raw_cust_services = $fetch_get_bin['service_name'];

		$insert_into_bin = mysqli_query($connect, "INSERT INTO bin (cust_id, cust_fullname, employ_fullname, services, reserved_condition) VALUES ('$raw_cust_id', '$raw_cust_full_name', '', '$raw_cust_services', '3')");

		if($insert_into_bin){
			$delete_booking = mysqli_query($connect, "DELETE FROM booking WHERE booking_id='$id'");

			if($delete_booking){
				echo "<script>window.location.href='user_dashboard.php?cancelled=succesfully';</script>";
			}
		}
	}
?>