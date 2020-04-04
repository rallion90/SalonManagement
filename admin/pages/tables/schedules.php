<?php 
  $host = "localhost";
  $username = "root";
  $password = "";
  $dbname = "lucena_salon";
  $connect = mysqli_connect($host, $username, $password, $dbname); 
?>

<?php
	$values = mysqli_query($connect, "SELECT * FROM booking");
	//$fetch_booking = mysqli_fetch_assoc($get_date_and_time);
	$array_data = array();

	foreach($values as $value => $key){
		$array_data[] = array('title' => $key['service_name'],
							  'start' => $key['date_reserved'].'T'.$key['time_reserved']
					  );
	}


	echo json_encode($array_data);
?>