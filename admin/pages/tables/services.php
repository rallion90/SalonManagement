<?php 
  $host = "localhost";
  $username = "root";
  $password = "";
  $dbname = "lucena_salon";
  $connect = mysqli_connect($host, $username, $password, $dbname); 
?>

<?php
  session_start();
  $service_name = $service_price = "";
  $service_nameErr = $service_priceErr =  "";

  $message = "";
  
  if(isset($_GET['010100110101']) == 'success'){
    $message = "<span class='alert alert-success col-md-12' role='alert'>Succesfully Added</span>";
  }

  if(isset($_SESSION['db_admin_id'])){
    $db_admin_id = $_SESSION['db_admin_id'];
    $get_dbrecord = mysqli_query($connect, "SELECT * FROM admin WHERE admin_id='$db_admin_id'");
    $row = mysqli_fetch_assoc($get_dbrecord);
    $db_aid = $row['admin_id'];
    $db_admin_name = ucfirst($row['username']);

    //get supplier data
    $get_supplier_data = mysqli_query($connect, "SELECT * FROM supplier");

    //get category data
    $get_category_data = mysqli_query($connect, "SELECT * FROM category");

    //get product data 
    $get_product_data = mysqli_query($connect, "SELECT * FROM product");

    //get service category
    $get_service_category = mysqli_query($connect, "SELECT * FROM service_category");

    //get service promo
    $get_service_promo = mysqli_query($connect, "SELECT * FROM service_promo");

    //get services
    $get_services = mysqli_query($connect, "SELECT * FROM services");

  }else{
    header('Location: ../../login.php');
  }

  if(isset($_POST['submit'])){
    $service_category = $_POST['service_category'];
    $service_promo = $_POST['service_promo'];

    if(empty($_POST['service_name'])){
      $service_nameErr = "Field Required";
    }
    else{
      $service_name = $_POST['service_name'];
    }

    if(empty($_POST['service_price'])){
      $service_priceErr = "Field Required";
    }
    else{
      $service_price = $_POST['service_price'];
    }


    if($service_name && $service_price && $service_category && $service_promo){
      if(is_numeric($service_price)){
        $service_allout_price = $service_price * $service_promo;

        $insert_service = mysqli_query($connect, "INSERT INTO services (service_name, service_price, service_category, service_promo) VALUES ('$service_name', '$service_allout_price', '$service_category', '$service_promo')");

        if($insert_service){
          header("Location: services.php?services=added");
        }
      }
      else{
        $service_priceErr = "Field must be Numeric";
      }
    }


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

  <style type="text/css">
    .error{
      color:red;
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
              <a class="dropdown-item">
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
                  <h4 class="card-title">Services</h4>
                  
                  <div class="table-responsive pt-3">
                    <div class="col-12 grid-margin stretch-card">
                      <div class="card">
                        <div class="card-body">
                          
                          <form class="forms-sample" method="post">
                            <span class="error"><?php echo $service_nameErr;?></span>
                            <div class="form-group">
                              <label for="exampleInputName1">Service Name</label>
                              <input type="text" class="form-control" name="service_name" id="exampleInputName1" placeholder="Product Name"><span class="error"></span>
                            </div>
                            <span class="error"><?php echo $service_priceErr;?></span>
                            <div class="form-group">
                              <label for="exampleInputName1">Service Price</label>
                              <input type="text" class="form-control" name="service_price" id="exampleInputName1" placeholder="Product Name"><span class="error"></span>
                            </div>
                                                  
                            <div class="form-group">
                              <label for="exampleSelectGender">Service Category</label>
                                <select class="form-control" name="service_category" id="exampleSelectGender">
                                  
                              <?php
                                while($row = mysqli_fetch_assoc($get_service_category)){
                              ?> 
                                  <option value="<?php echo $row['service_category_id']?>"><?php echo $row['service_category_name']?></option>
                              <?php
                                }
                              ?>
                                </select><span class="error"></span>
                            </div>
                            
                            <div class="form-group">
                              <label for="exampleSelectGender">Service Promo</label>
                                <select class="form-control" name="service_promo" id="exampleSelectGender">
                                
                                  <option value="1">Default</option>
                              <?php
                                while($row = mysqli_fetch_assoc($get_service_promo)){
                              ?>  
                                  <option value="<?php echo $row['service_promo_discount'];?>"><?php echo $row['service_promo_name'];?></option>
                              <?php
                                }
                              ?>        
                              
                                   
                                </select><span class="error"></span>
                            </div>  
                           
                            <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                            <button class="btn btn-light">Cancel</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Service List</h4>
                  
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered" id="example4">
                      <thead>
                        <tr>
                          <th>
                            Service Name
                          </th>
                          <th>
                            Service Price
                          </th>
                          <th>
                            Service Promo
                          </th>
                          <th>
                            Action
                          </th>         
                        </tr>
                      </thead>
                      <tbody>
                  <?php
                    while($row = mysqli_fetch_assoc($get_services)){
                      $promo = "";
                      if($row['service_promo'] == "1"){
                        $promo = "Default";
                      }
                      elseif($row['service_promo'] == "0.5"){
                        $promo = "Christmas Promo";
                      }
                      else{
                        $promo = "Summer Promo";
                      }
                  ?>      
                        <tr>
                          <td>
                            <?php echo $row['service_name'];?>
                          </td>
                          <td>
                            <?php echo $row['service_price'];?>
                          </td>
                           <td>
                            <?php echo $promo;?>
                          </td>
                          <td>
                            <a href="edit_services.php?service_id=<?php echo $row['service_id'];?>"><i class="fas fa-edit"></i></a> | <a href="delete_services.php?service_id=<?php echo $row['service_id'];?>"><i class="fas fa-trash-alt"></i></a>
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
  <script src="https://kit.fontawesome.com/ff1f1d4454.js"></script>
  <script src="../../js/datatables/jquery.dataTables.js"></script>
<script src="../../js/datatables/dataTables.bootstrap4.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
</body>

</html>

<script>
  $(function () {
    $("#example4").DataTable({
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
