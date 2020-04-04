<?php 
  $host = "localhost";
  $username = "root";
  $password = "";
  $dbname = "lucena_salon";
  $connect = mysqli_connect($host, $username, $password, $dbname); 
?>

<?php
  session_start();

  if(isset($_SESSION['db_admin_id'])){
    $verify_customer = "";
    $verify_customerErr = "";
    $pointsUp = 2;
    $db_admin_id = $_SESSION['db_admin_id'];
    $get_dbrecord = mysqli_query($connect, "SELECT * FROM admin WHERE admin_id='$db_admin_id'");
    $row = mysqli_fetch_assoc($get_dbrecord);
    $db_aid = $row['admin_id'];
    $db_admin_name = ucfirst($row['username']);
    $get_booking = mysqli_query($connect, "SELECT * FROM booking");

    //get customer data
    $get_customer = mysqli_query($connect, "SELECT * FROM login");

    

    if(isset($_POST['accept'])){
      if(empty($_POST['verify_customer'])){
        $verify_customerErr = "Empty Fields";
      }
      else{
        $verify_customer = $_POST['verify_customer'];
      }

      if($verify_customer){
        if(is_numeric($verify_customer)){
          $check = mysqli_query($connect, "UPDATE booking SET booking_condition='1' WHERE verification_code='$verify_customer'");
          if($check){
            //$result = mysqli_query($connect, "UPDATE login SET points = points + $pointsUp WHERE ");
            $get_customer_id = mysqli_query($connect, "SELECT * FROM booking WHERE verification_code='$verify_customer'");
            $fetch_customer_id = mysqli_fetch_assoc($get_customer_id);
            $get_fullname = $fetch_customer_id['fullname'];
            
            $get_services = $fetch_customer_id['service_name'];
            $fetch_pay_price = $fetch_customer_id['not_pay_price'];
            $get_user_id = $fetch_customer_id['user_id'];
            $result = mysqli_query($connect, "UPDATE login SET points = points + $pointsUp WHERE user_id='$get_user_id'");
            $add_sales = mysqli_query($connect, "UPDATE sales SET sales_amount = sales_amount + $fetch_pay_price");
            if($add_sales && $result){

              $succes_bin = mysqli_query($connect, "INSERT INTO bin (cust_id, cust_fullname, services, reserved_condition) VALUES ('$get_user_id', '$get_fullname', '$get_services', '2')");
              if($succes_bin){
                $updated = mysqli_query($connect, "UPDATE login SET reserved_pending='0' WHERE user_id='$get_user_id'");
                if($updated){
                  $deleted = mysqli_query($connect, "DELETE FROM booking WHERE user_id='$get_user_id'");
                  if($deleted){
                    echo "<script>window.location.href='reservation.php?reserved=succesfully';</script>";
                  }
                  else{
                    echo "error";
                  }
                }
                else{
                  echo "error";
                }
           
              }
              else{
                echo "error";
              }
             
            }
            else{
              echo "<script>window.location.href='reservation.php?invalid=failed';</script>";
            }



            
          }
          else{
            $verify_customerErr = "Invalid Verification Number";
          }
        }
        else{
          $verify_customerErr = "This must be Number!";
        }
      }

    }else{

    }

   


  }else{
    header('Location: ../../login.php');
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />

  <!-- Full Calendar-->
  <link href='../../fullcalendar/packages/core/main.css' rel='stylesheet' />
  <link href='../../fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
  <link href='../../fullcalendar/packages/timegrid/main.css' rel='stylesheet' />
  <link href='../../fullcalendar/packages/list/main.css' rel='stylesheet' />
  <script src='../../fullcalendar/packages/core/main.js'></script>
  <script src='../../fullcalendar/packages/interaction/main.js'></script>
  <script src='../../fullcalendar/packages/daygrid/main.js'></script>
  <script src='../../fullcalendar/packages/timegrid/main.js'></script>
  <script src='../../fullcalendar/packages/list/main.js'></script>
  <script>

    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        defaultDate: '<?php echo date('Y-m-d');?>',
        navLinks: true, // can click day/week names to navigate views
        businessHours: true, // display business hours
        editable: false,
        events: 'schedules.php'
      });

      calendar.render();
    });

  </script>
  <style>

    

    #calendar {
      max-width: 900px;
      margin: 0 auto;
    }

  </style>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a href="#"><h1 class="navbar-brand brand-logo mr-5">Admin Pane</h1></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="ti-view-list"></span>
        </button>
       
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="ti-bell mx-0"></i>
              <span class="count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="notificationDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
              <a class="dropdown-item">
                <div class="item-content">
                  <h6 class="font-weight-normal">New Pending Reservation</h6>
                  <p class="font-weight-light small-text mb-0 text-muted">
                    Just now
                  </p>
                </div>
              </a>
            </div>
          </li>
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <?php echo $db_admin_name?>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="setting.php">
                <i class="ti-settings text-primary"></i>
                Settings
              </a>
              <a class="dropdown-item" href="/gleam and glam/admin/logout.php">
                <i class="ti-power-off text-primary"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="ti-view-list"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../../partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="../../index.php">
              <i class="ti-shield menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
           
          <li class="nav-item">
            <a class="nav-link" href="../../pages/tables/basic-table.php">
              <i class="ti-view-list-alt menu-icon"></i>
              <span class="menu-title">Customers Table</span>
            </a>
          </li>

          

          <li class="nav-item">
            <a class="nav-link" href="services.php">
              <i class="ti-view-list-alt menu-icon"></i>
              <span class="menu-title">Services</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="reservation.php">
              <i class="ti-calendar menu-icon"></i>
              <span class="menu-title">Appointment</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="message.php">
              <i class="ti-view-list-alt menu-icon"></i>
              <span class="menu-title">Messages</span>
            </a>
          </li>
          
          
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            
            
            

            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Employee</h4>
                  
                  <div class="table-responsive pt-3">
                    
                    <table class="table table-bordered" id="example3">
                      <form method="post">
                        <div class="form-group">
                            <div class="col-lg-10">
                              <div class="row">
                                <div class="col-lg-3">
                                  <input type="text" name="verify_customer" class="form-control" placeholder="Enter Verification Number">
                                </div>
                                <button class="btn btn-primary" name="accept">Accept</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                      <tbody>
                        <tr>
                          
                          <th><i class="fas fa-user-tie"></i>Full Name</th>
                          <th><i class="fas fa-concierge-bell"></i>Service</th>
                          <th><i class="fas fa-calendar-day"></i>Date Reserved</th>
                          <th>Time</th>
                          
                        </tr>
                        
                    <?php
                      while($row = mysqli_fetch_assoc($get_booking)){
                    ?>
                        <tr>
                          
                          <td><?php echo ucwords($row['fullname']);?></td>
                          <td><?php echo $row['service_name'];?></td>
                          <td><?php echo $row['date_reserved'];?></td>
                          <td><?php echo $row['time_reserved'];?></td>  
                        </tr> 
                    <?php
                      }
                    ?>     
                          
                        
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Schedules</h4>
                  <div id='calendar'></div>
                  
                </div>
              </div>
            </div>
            
            
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Rowelyn Caberto | Kim Daryll Malabanan | Troi Decuzar. All rights reserved.</span>
           
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../../vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../js/todolist.js"></script>
  
  <script src="../../js/datatables/jquery.dataTables.js"></script>
<script src="../../js/datatables/dataTables.bootstrap4.js"></script>
<script src="../../js/font-awesome.min.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
</body>

</html>

<script>
  $(function () {
    $("#example3").DataTable({
      "paging": true,
      "pageLength": 5,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
    
    $('#example2').DataTable({
      "paging": true,
      "pageLength": 5,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>
