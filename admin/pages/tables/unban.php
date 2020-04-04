<?php include("../../../connection.php");?>

<?php
	$get_id = $_GET['id'];

	mysqli_query($connect, "UPDATE login SET account_condition='0' WHERE user_id='$get_id'");
	
	header("Location: basic-table.php");
?>