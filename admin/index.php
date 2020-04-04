<?php include('../connection.php');?>
<?php
  session_start();

  if(isset($_SESSION['db_admin_id'])){
    $db_admin_id = $_SESSION['db_admin_id'];
    $get_dbrecord = mysqli_query($connect, "SELECT * FROM admin WHERE admin_id='$db_admin_id'");
    $row = mysqli_fetch_assoc($get_dbrecord);
    $db_aid = $row['admin_id'];
    $db_admin_name = ucfirst($row['username']);
    $get_sales = mysqli_query($connect, "SELECT * FROM sales");
    $get_sales_data = mysqli_fetch_assoc($get_sales);
    $sales_record = $get_sales_data['sales_amount'];

    $count_employee = mysqli_query($connect, "SELECT COUNT(*) FROM services");
    $count_user = mysqli_query($connect, "SELECT COUNT(*) FROM login");
    $get_bin = mysqli_query($connect, "SELECT * FROM bin");

    if(isset($_POST['delete_table'])){
      $delete_records = mysqli_query($connect, "DELETE FROM bin");
      if($delete_records){
        echo "<script>window.location.href='index.php';</script>";
      }
    }

  }
  else{
    header("Location: login.php");
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
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
       <a href="#"><h1 class="navbar-brand brand-logo mr-5">Admin Pane</h1></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="ti-view-list"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
          <li class="nav-item nav-search d-none d-lg-block">
            <div class="input-group">
              <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                <span class="input-group-text" id="search">
                  <i class="ti-search"></i>
                </span>
              </div>
              <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
            </div>
          </li>
        </ul>
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
              <a class="dropdown-item">
                <i class="ti-settings text-primary"></i>
                Settings
              </a>
              <a class="dropdown-item" href="logout.php">
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
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="ti-shield menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          
         
          <li class="nav-item">
            <a class="nav-link" href="pages/tables/basic-table.php">
              <i class="ti-view-list-alt menu-icon"></i>
              <span class="menu-title">Customers Table</span>
            </a>
          </li>

          

          <li class="nav-item">
            <a class="nav-link" href="pages/tables/services.php">
              <i class="ti-view-list-alt menu-icon"></i>
              <span class="menu-title">Services</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="pages/tables/reservation.php">
              <i class="ti-calendar menu-icon"></i>
              <span class="menu-title">Appointment</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="pages/tables/message.php">
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
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title text-md-center text-xl-left">Sales</p>
                    <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                      <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0 count">₱ <?php echo number_format($sales_record);?></h3>
                      <i class="ti-wallet icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                    </div>  
                    <p class="mb-0 mt-2 text-danger"><span class="text-black ml-1"><small>Every Succesful Reservation</small></span></p>
                </div>
              </div>
            </div>

            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title text-md-center text-xl-left">Services</p>
                    <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                  <?php
                    while($row1 = mysqli_fetch_array($count_employee)){
                  ?>    
                      <center><h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?php echo $row1['COUNT(*)'];?></h3></center>
                  <?php
                    }
                  ?>    
                      <i class="ti-eye icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                    </div>  
                    <p class="mb-0 mt-2 text-danger"><span class="text-black ml-1"><small>No. of Services</small></span></p>
                </div>
              </div>
            </div>

            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title text-md-center text-xl-left">User</p>
                    <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                  <?php
                    while($row3 = mysqli_fetch_array($count_user)){
                  ?>    
                      <center><h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?php echo $row3['COUNT(*)'];?></h3></center>
                  <?php
                    }
                  ?>    
                      <i class="ti-user icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                    </div>  
                    <p class="mb-0 mt-2 text-danger"><span class="text-black ml-1"><small>No. of Users</small></span></p>
                </div>
              </div>
            </div>

            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Customer History</h4>
                  <form method="post">
                    <button class="btn btn-danger float-right" name="delete_table">Clear Table</button>
                  </form>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered" id="example2">
                      <thead>
                        <tr> 
                          <th>
                            Customer Full Name
                          </th>
                         
                          <th>
                            Services
                          </th>
                          <th>
                            Condition
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                <?php 
                  while($row5 = mysqli_fetch_assoc($get_bin)){
                    $get_custname = $row5['cust_fullname'];
                   
                    $get_services = $row5['services'];
                    $get_reserved_condition = $row5['reserved_condition'];
                    $reserved_cond = "";
                    

                    if($get_reserved_condition == 2){
                      $reserved_cond = "
                                  
                                    <label class='badge badge-success'>Succesful</label>
                                  
                                  ";
                    }elseif($get_reserved_condition == 1){
                      $reserved_cond = "
                                  
                                    <label class='badge badge-warning'>Lapsed</label>
                                  
                                ";
                    }else{
                      $reserved_cond = "
                                  
                                    <label class='badge badge-warning'>Cancelled</label>
                                  
                                ";
                    }

                ?>        
                    
                        <tr>
                          <td>
                            <?php echo $get_custname;?>
                          </td>

                          <td>
                            <?php echo $get_services;?>
                          </td>

                          <td>
                            <?php echo $reserved_cond;?>
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
          </div>
        </div>  
      </div>


      
      
          
          
          
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
       
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  
   

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- plugins:js -->
  <script src="vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="vendors/chart.js/Chart.min.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>

</html>

