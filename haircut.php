<?php include('nav.php');?>
<br>

<div class="container pane">
  <div class="row">
    <div class="col-md-6">
      <div class="container-fluid">
        <div class="container">
          <h3>Haircut Service</h3>
      <?php
        while($row = mysqli_fetch_assoc($get_all_services_hc)){
          if(isset($_SESSION['user_id'])){
      ?>
          <a href="reservation.php?services=<?php echo urlencode(base64_encode($row['service_name']));?>&price=<?php echo urlencode(base64_encode($row['service_price']));?>"><p style="font-size: 15px; font-family: Times New Roman;"> <?php echo $row['service_name'];?>  <?php echo $row['service_price'];?></p></a>
      <?php
          }else{
      ?>
          <a href="login.php?login=error"><p style="font-size: 15px; font-family: Times New Roman;"> <?php echo $row['service_name'];?>  <?php echo $row['service_price'];?></p></a>

      <?php      
          }
        }
      ?>
      
        </div>
      </div>

      <div class="container-fluid">
        <div class="container">
          <h3>Rebond</h3>
      <?php
        while($row = mysqli_fetch_assoc($get_all_services_r)){
          if(isset($_SESSION['user_id'])){
      ?>
          <a href="reservation.php?services=<?php echo urlencode(base64_encode($row['service_name']));?>&price=<?php echo urlencode(base64_encode($row['service_price']));?>"><p style="font-size: 15px; font-family: Times New Roman;"> <?php echo $row['service_name'];?>  <?php echo $row['service_price'];?></p></a>
      <?php
          }else{
      ?>
          <a href="login.php?login=error"><p style="font-size: 15px; font-family: Times New Roman;"> <?php echo $row['service_name'];?>  <?php echo $row['service_price'];?></p></a>

      <?php      
          }
        }
      ?>
 
        </div>
      </div>

      <div class="container-fluid">
        <div class="container">
          <h3>According to Length</h3>
      
      <?php
        while($row = mysqli_fetch_assoc($get_all_services_atl)){
          if(isset($_SESSION['user_id'])){
      ?>
          <a href="reservation.php?services=<?php echo urlencode(base64_encode($row['service_name']));?>&price=<?php echo urlencode(base64_encode($row['service_price']));?>"><p style="font-size: 15px; font-family: Times New Roman;"> <?php echo $row['service_name'];?>  <?php echo $row['service_price'];?></p></a>
      <?php
          }else{
      ?>
          <a href="login.php?login=error"><p style="font-size: 15px; font-family: Times New Roman;"> <?php echo $row['service_name'];?>  <?php echo $row['service_price'];?></p></a>

      <?php      
          }
        }
      ?>   
        </div>
      </div>

      <div class="container-fluid">
        <div class="container">
          <h3>Facial and Aesthetic Services</h3>

      <?php
        while($row = mysqli_fetch_assoc($get_all_services_faas)){
          if(isset($_SESSION['user_id'])){
      ?>
          <a href="reservation.php?services=<?php echo urlencode(base64_encode($row['service_name']));?>&price=<?php echo urlencode(base64_encode($row['service_price']));?>"><p style="font-size: 15px; font-family: Times New Roman;"> <?php echo $row['service_name'];?>  <?php echo $row['service_price'];?></p></a>
      <?php
          }else{
      ?>
          <a href="login.php?login=error"><p style="font-size: 15px; font-family: Times New Roman;"> <?php echo $row['service_name'];?>  <?php echo $row['service_price'];?></p></a>

      <?php      
          }
        }
      ?>       
         
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="container-fluid">
        <div class="container">
          <h3>L'Oreal Treatment</h3>

      <?php
        while($row = mysqli_fetch_assoc($get_all_services_lot)){
          if(isset($_SESSION['user_id'])){
      ?>
          <a href="reservation.php?services=<?php echo urlencode(base64_encode($row['service_name']));?>&price=<?php echo urlencode(base64_encode($row['service_price']));?>"><p style="font-size: 15px; font-family: Times New Roman;"> <?php echo $row['service_name'];?>  <?php echo $row['service_price'];?></p></a>
      <?php
          }else{
      ?>
          <a href="login.php?login=error"><p style="font-size: 15px; font-family: Times New Roman;"> <?php echo $row['service_name'];?>  <?php echo $row['service_price'];?></p></a>

      <?php      
          }
        }
      ?>    
       
        </div>


        <div class="container">
          <h3>Other Treatment</h3>

      <?php
        while($row = mysqli_fetch_assoc($get_all_services_ot)){
          if(isset($_SESSION['user_id'])){
      ?>
          <a href="reservation.php?services=<?php echo urlencode(base64_encode($row['service_name']));?>&price=<?php echo urlencode(base64_encode($row['service_price']));?>"><p style="font-size: 15px; font-family: Times New Roman;"> <?php echo $row['service_name'];?>  <?php echo $row['service_price'];?></p></a>
      <?php
          }else{
      ?>
          <a href="login.php?login=error"><p style="font-size: 15px; font-family: Times New Roman;"> <?php echo $row['service_name'];?>  <?php echo $row['service_price'];?></p></a>

      <?php      
          }
        }
      ?>        
       
        </div>
      </div>
    </div>

    
  </div>
</div>  
  

  

<?php include('footer.php');?>