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
    $db_admin_id = $_SESSION['db_admin_id'];
    $get_dbrecord = mysqli_query($connect, "SELECT * FROM admin WHERE admin_id='$db_admin_id'");
    $row = mysqli_fetch_assoc($get_dbrecord);
    $db_aid = $row['admin_id'];
    $db_admin_name = ucfirst($row['username']);

    //get customer data
    $get_customer = mysqli_query($connect, "SELECT * FROM login");

    //get employee data
    $get_employee = mysqli_query($connect, "SELECT * FROM employee");

   


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
                  <h4 class="card-title">Customer</h4>
                  
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered" id="example2">
                      <thead>
                        <tr> 
                          <th>
                            #
                          </th>
                          <th>
                            Full Name
                          </th>
                          <th>
                            Points
                          </th>
                          <th>
                            Status
                          </th>
                          <th>
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                    <?php
                      while($row1 = mysqli_fetch_assoc($get_customer)){
                        $db_id = $row1['user_id'];
                        $db_fullname = $row1['fullname'];
                        $db_points = $row1['points'];
                    ?>
                        <tr>
                          <td>
                            <?php echo $db_id;?>
                          </td>
                          <td>
                            <?php echo ucwords($db_fullname);?>
                          </td>
                          <td>
                            <!--<div class="progress">
                              <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="<?php echo $db_points;?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>-->

                             <div class="progress">
                              <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $db_points?>%" aria-valuenow="<?php echo $db_points?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </td>

                          <?php 
                          $checker = mysqli_query($connect, "SELECT * FROM login WHERE user_id='$db_id'");
                          $get_booking_cond = mysqli_fetch_assoc($checker);
                          $get_reserved = $get_booking_cond['reserved_pending'];
                          if($get_reserved == "1"){
                             echo "
                                  <td style='width:30px;''>
                                    <label class='badge badge-warning'>Pending</label>
                                  </td>
                            ";
                            
                          }else{
                            echo "
                                 <td style='width:30px;''>
                                    <label class='badge badge-success'>No Reservation</label>
                                  </td>
                            ";
                          }

                          ?>


                         <!-- <td style="width:30px;">
                            <label class="badge badge-success">No Reservation</label>
                          </td>-->
                      

                          <td>
                           <center>
                          
                              <div class="btn-group">
                            <?php
                              $account_checking = mysqli_query($connect, "SELECT * FROM login WHERE user_id='$db_id'");
                              $row3 = mysqli_fetch_assoc($account_checking);
                              $get_account = $row3['account_condition'];
                              if($get_account == "1"){
                                
                                  echo "<a class='btn btn-primary' href='unban.php?id=$db_id'><i class='fas fa-unlock-alt' style='font-size:13px;''></i></a> &nbsp;
                                        <a class='btn btn-primary' href='delete.php?id=$db_id'><i class='far fa-trash-alt' style='font-size:13px;''></i></a>";
                              }else{
                                   echo "<a class='btn btn-primary' href='ban.php?id=$db_id'><i class='fa fa-ban' style='font-size:13px;''></i></a> &nbsp;
                                        <a class='btn btn-primary' href='delete.php?id=$db_id'><i class='far fa-trash-alt' style='font-size:13px;''></i></a>";
                              }
                            ?>    
                              </div>
                            
                          </center>
                          </td>    
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
