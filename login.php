<?php include('connection.php');?>
<?php
session_start();

if(isset($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];
  $get_record = mysqli_query($connect, "SELECT * FROM login WHERE user_id='$user_id'");
  $row = mysqli_fetch_assoc($get_record);
  $db_username = $row['username'];

  echo "<script>window.location.href='index.php';</script>";
}

  $uname = $pword = "";
  $usernameErr = $passwordErr = "";
  $message = "";
  $not_allowed = "";
  $login = "";
  $banned = "";
 if(isset($_GET['status']) == 'success'){
  $message = "Your Account is Succesfully Created. Check your phone for promos.";
 }
 if(isset($_GET['forbidden']) == 'not_allowed'){
  $not_allowed = "You are not allowed to access this page";
 }
 if(isset($_GET['login']) == 'error'){
  $login = "You must login first";
 }

 if(isset($_GET['account']) == 'banned'){
  $banned = "Your Account is Banned";
 }
 
  if(isset($_POST['submit'])){
    $uname = mysqli_real_escape_string($connect, $_POST['username']);
    $pword = md5($_POST['password']);
    if($uname && $pword){
      $unamelen = strlen($uname);
      if($unamelen < 5){
        $usernameErr = "Username is Too Short";
      }
      else{
        $check_username = mysqli_query($connect, "SELECT * FROM login WHERE username='$uname'");
        $check_username_row = mysqli_num_rows($check_username);
        if($check_username_row > 0){
          $row = mysqli_fetch_assoc($check_username);
          $user_id = $row['user_id'];
          $db_password = $row['password'];
          if($pword == $db_password){
            $_SESSION['user_id'] = $user_id;
            header('Location: index');
          }
          else{
            $passwordErr = "Invalid Password";
          }
        }
        else{
          $usernameErr = "Username is not Registered";
        }
      } 
    }  
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Please Login</title>
  <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link rel="stylesheet" type="text/css" href="css/login.css">
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style type="text/css">
  .error{
    color:red;
  }
  .success{
    color:grey;
  }
</style>
</head>
<body>
<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->
    <!-- Icon -->
    <div class="fadeIn first">
      <img src="https://img.icons8.com/ios/100/000000/user-filled.png">
    </div>
    <!-- Login Form -->
    <form method="post">
      <span class="error"><?php echo $banned;?></span>
      <span class="error"><?php echo $login;?></span>
      <span class="error"><?php echo $not_allowed;?></span>
      <span class="success"><?php echo $message;?></span>
      <span class="error"><?php echo $usernameErr;?></span>
      <span class="error"><?php echo $passwordErr;?></span>
      <input type="text" id="login" class="fadeIn second" name="username" placeholder="Enter Username" required>
      <input type="password" id="password" class="fadeIn third" name="password"  placeholder="Enter Password" required><span class="error">
      <input type="submit" class="fadeIn fourth" name="submit" value="Log In">
    </form>
    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="register.php">Don't have an account? Click here</a><br>
      <a href="index.php">Go back to Home</a>
    </div>
  </div>
</div>
</body>
</html>