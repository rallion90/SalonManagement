<?php include('connection.php');?>
<?php include('nav.php');?>
<?php 
	if(isset($_SESSION['user_id'])){
	}else{		
		header("Location: login.php?forbidden=not_allowed");
	}
?>
<?php include('footer.php');?>