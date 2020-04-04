<?php include('nav.php');?>

<?php
include('connection.php'); 
	if(isset($_SESSION['user_id'])){
		 $check_date = mysqli_query($connect, "SELECT * FROM booking where date_reserved < CURDATE()");
    
    
	    while($row_bin = mysqli_fetch_assoc($check_date)){
	      $cust_fullname = $row_bin['fullname'];
	      $employ_fullname = $row_bin['employee_name'];
	      $services = $row_bin['employee_name'];
	     
	      $insert_cur_date = mysqli_query($connect, "INSERT INTO bin (cust_fullname, employ_fullname, services, reserved_condition) VALUES('$cust_fullname', '$employ_fullname', '$services', '1')");

	      if($insert_cur_date){
	        mysqli_query($connect, "DELETE FROM booking WHERE date_reserved < CURDATE()");
	      }
	    }

		$user_id = $_SESSION['user_id'];
		$per_page = 5;
		$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
		$start = ($page - 1) * $per_page;
		$page_query = mysqli_query($connect, "SELECT COUNT(user_id) FROM booking");
		$get_record = mysqli_query($connect, "SELECT * FROM booking WHERE user_id='$user_id' AND booking_condition='0' ORDER BY date_reserved ASC LIMIT $start, $per_page");
		$row = mysqli_fetch_array($page_query);
		$pages = ceil($row['0'] / $per_page);
		//$row = mysqli_fetch_assoc($get_record);
		//$db_barber_id = $row['barber_id'];
		//$db_fullname = $row['fullname'];
		//$db_barber_name = $row['barber_name'];
		//$db_date = $row['date_reserved'];
?>	

<div class="container">
  <h2>My Booking</h2>
              
  <table class="table">
    <thead>
      <tr>
        
        <th>Full Name</th>
       
        <th>Haircut</th>
        <th>Reservation Date</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
		<?php while($row = mysqli_fetch_assoc($get_record)){
			$db_booking_id = $row['booking_id'];
			//$db_barber_id = $row['employee_id'];
	  		$db_fullname = $row['fullname'];
	  		//$db_barber_name = $row['employee_name'];
	  		$db_haircut = $row['service_name'];
	  		$db_date = $row['date_reserved'];
	  	?>	

	  		<tr>
				
				<td><?php echo $db_fullname;?></td>
				<!--<td></td>-->
				<td><?php echo ucwords($db_haircut);?></td>
				<td><?php echo date('F j, Y D', strtotime($db_date));?></td>
				<td><a href="delete.php?id=<?php echo $db_booking_id;?>" class="btn btn-danger">Cancel Booking</a></td>
			</tr>
	  		

		  
		<?php   
     		}

     		$prev = $page - 1;
     		$next = $page + 1;
   
		?>
 	</tbody>
  </table>
  <hr>
  

<nav>
	<ul class='pagination pagination-sm'>
<?php	
	if(!($page<=$pages)){
			
		echo		"<li class='page-item'>
							<a href='?page=$prev#here' class='page-link' aria-label='Previous'>
								<span aria-hidden='true'>&laquo;</span>
							</a>
					 </li>";
	}				
?>					
<?php	
	if(!($page>=$pages)){

		echo	"<li class='page-item'><a href='#' class='page-link'></a></li>
					<li class='page-item'>	
						<a href='?page=$next#here' class='page-link' aria-label='Next'>
							<span aria-hidden='true'>&raquo;</span>
						</a>	
				</li>";
	}	
?>	
	</ul>
</nav>
</div>	

<?php include('footer.php');?>

<?php
	}
	else{
		header("Location: login.php?forbidden=not_allowed");
	}
?>
<br>



