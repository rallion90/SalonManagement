<?php 
  $host = "localhost";
  $username = "root";
  $password = "";
  $dbname = "lucena_salon";
  $connect = mysqli_connect($host, $username, $password, $dbname); 
?>

<?php
  session_start();

  $supplier_name = $supplier_address = $supplier_contact = $supplier_email = "";
  $supplier_nameErr = $supplier_addressErr = $supplier_contactErr = $supplier_emailErr = "";
  $supplier_added = "";

  if(isset($_GET['0100001000110000']) == 'success'){
      $supplier_added = "<span class='alert alert-success' role='alert'>Succesfully Added</span>";
  }

  if(isset($_SESSION['db_admin_id'])){
    $db_admin_id = $_SESSION['db_admin_id'];
    $get_dbrecord = mysqli_query($connect, "SELECT * FROM admin WHERE admin_id='$db_admin_id'");
    $row = mysqli_fetch_assoc($get_dbrecord);
    $db_aid = $row['admin_id'];
    $db_admin_name = ucfirst($row['username']);

    //get Supplier data
    $supplier_data = mysqli_query($connect, "SELECT * FROM supplier");

    if(isset($_POST['submit'])){
      if(empty($_POST['supplier_name'])){
        $supplier_nameErr = "Field Required";
      }
      else{
        $supplier_name = $_POST['supplier_name'];
      }

      if(empty($_POST['supplier_address'])){
        $supplier_addressErr = "Field Required";
      }
      else{
        $supplier_address = $_POST['supplier_address'];
      }

      if(empty($_POST['supplier_contact'])){
        $supplier_contactErr = "Field Required";
      }
      else{
        $supplier_contact = $_POST['supplier_contact'];
      }

      if(empty($_POST['supplier_email'])){
        $supplier_emailErr = "Field Required";
      }
      else{
        $supplier_email = $_POST['supplier_email'];
      }

      if($supplier_name && $supplier_address && $supplier_contact && $supplier_email){
        $supplier_nameLen = strlen($supplier_name);
        if($supplier_nameLen < 2){
          $supplier_nameErr = "Supplier Name is too short";
        }else{
          $supplier_addressLen = strlen($supplier_address);
          if($supplier_addressLen < 5){
            $supplier_addressErr = "Too short for address";
          }else{
            $supplier_contactLen = strlen($supplier_contact);
            if($supplier_contactLen < 10){
              $supplier_contactErr = "Too short for Valid Philippine Contact Number";
            }else{
              if(!filter_var($supplier_email, FILTER_VALIDATE_EMAIL)){
                $supplier_emailErr = "Invalid Email Format";
              }else{
                mysqli_query($connect, "INSERT INTO supplier (supplier_name,supplier_address,supplier_contact,supplier_email) VALUES ('$supplier_name', '$supplier_address', '$supplier_contact', '$supplier_email')");

                header("Location: supplier.php?0100001000110000=success");
              }
            }
          }
        }
      }
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

  <style type="text/css">
    .error{
      color:red;
    }

    .alert{
      width: 100%;
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
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="ti-palette menu-icon"></i>
              <span class="menu-title">Inventory</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="product.php">Product</a></li>
                <li class="nav-item"><a class="nav-link" href="supplier.php">Supplier</a></li>
                <li class="nav-item"><a class="nav-link" href="category.php">Category</a></li>
              </ul>
            </div>
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
            
             <?php echo $supplier_added;?>
            <div class="col-lg-12 grid-margin stretch-card">

              <div class="card">
                <div class="card-body col-md-12">
                  <h4 class="card-title col-md-12">Supplier</h4>
                  
                  <div class="table-responsive pt-3">

                    <div class="col-12 grid-margin stretch-card">

                      <div class="card">
                        <div class="card-body">
                          
                          <form class="forms-sample" method="post">

                            <div class="form-group">
                              <label for="exampleInputName1">Supplier Name</label>
                              <input type="text" class="form-control" name="supplier_name" id="exampleInputName1" placeholder="Supplier Name"><span class="error"><?php echo $supplier_nameErr;?></span>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputEmail3">Address</label>
                              <input type="text" class="form-control" name="supplier_address" id="exampleInputEmail3" placeholder="Address"><span class="error"><?php echo $supplier_addressErr;?></span>
                            </div>
                           
                            
                            <div class="form-group">
                              <label for="exampleInputCity1">Contact</label>
                              <input type="text" class="form-control" name="supplier_contact" id="exampleInputCity1" placeholder="Contact"><span class="error"><?php echo $supplier_contactErr;?></span>
                            </div>
                            <div class="form-group">
                              <label for="exampleTextarea1">Email Address</label>
                              <input type="text" class="form-control" name="supplier_email" id="exampleInputEmail3" placeholder="Email Address"><span class="error"><?php echo $supplier_emailErr; ?></span>
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
                  <h4 class="card-title">Supplier List</h4>
                  
                  <div class="table-responsive pt-3">
                    <table class="table table-dark">
                      <thead>
                        <tr>
                          <th>
                            Supplier Id
                          </th>
                          <th>
                            Supplier Name
                          </th>
                          <th>
                            Address
                          </th>
                          <th>
                            Contact
                          </th>
                          <th>
                            Email Address
                          </th>
                          
                        </tr>
                      </thead>
                      <tbody>
                    <?php 
                      while($row = mysqli_fetch_assoc($supplier_data)){
                        $db_supplier_id = $row['supplier_id'];
                        $db_supplier_name = $row['supplier_name'];
                        $db_supplier_address = $row['supplier_address'];
                        $db_supplier_contact = $row['supplier_contact'];
                        $db_supplier_email = $row['supplier_email'];
                    ?>    
                        <tr>
                          <td>
                            <?php echo $db_supplier_id;?>
                          </td>
                          <td>
                            <?php echo $db_supplier_name;?>
                          </td>
                          <td>
                            <?php echo $db_supplier_address;?>
                          </td>
                          <td>
                            <?php echo $db_supplier_contact;?>
                          </td>
                          <td>
                            <?php echo $db_supplier_email;?>
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
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
</body>

</html>
