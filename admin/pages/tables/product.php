<?php 
  $host = "localhost";
  $username = "root";
  $password = "";
  $dbname = "lucena_salon";
  $connect = mysqli_connect($host, $username, $password, $dbname); 
?>

<?php
  session_start();
  $product_name = $quantity = $supplier = $category = $description = "";
  $product_nameErr = $quantityErr = $supplierErr = $categoryErr = $descriptionErr = "";
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

  }else{
    header('Location: ../../login.php');
  }

  if(isset($_POST['submit'])){
    if(empty($_POST['product_name'])){
      $product_nameErr = "Field Required";
    }
    else{
      $product_name = mysql_real_escape_string($_POST['product_name']);
    }

    if(empty($_POST['quantity'])){
      $quantityErr = "Field Required";
    }
    else{
      $quantity = $_POST['quantity'];
    }

    if(empty($_POST['supplier'])){
      $supplierErr = "Field Required";
    }
    else{
      $supplier = $_POST['supplier'];
    }

    if(empty($_POST['category'])){
      $categoryErr = "Field Required";
    }
    else{
      $category = $_POST['category'];
    }

    if(empty($_POST['description'])){
      $descriptionErr = "Field Required";
    }
    else{
      $description = $_POST['description'];
    }

    if($product_name && $supplier && $category && $description){

       //get value from supplier
      $supplier_value = mysqli_query($connect, "SELECT * FROM supplier WHERE supplier_id='$supplier'");
      $row2 = mysqli_fetch_assoc($supplier_value);
      $db_supplier_name = $row2['supplier_name'];

      //get valuie from category
      $category_value = mysqli_query($connect, "SELECT * FROM category WHERE category_id='$category'");
      $row3 = mysqli_fetch_assoc($category_value);
      $db_category_name = $row3['category_name'];
   

      //paglalagay na ng data 
      mysqli_query($connect, "INSERT INTO product (product_name, quantity, supplier_name, category_name, description) 
                              VALUES ('$product_name', '$quantity', '$db_supplier_name', '$db_category_name', '$description')");
      header("Location: product.php?010100110101=success");
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
          <?php echo $message;?>
            
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Product</h4>
                  
                  <div class="table-responsive pt-3">
                    <div class="col-12 grid-margin stretch-card">
                      <div class="card">
                        <div class="card-body">
                          
                          <form class="forms-sample" method="post">
                            <div class="form-group">
                              <label for="exampleInputName1">Product Name</label>
                              <input type="text" class="form-control" name="product_name" id="exampleInputName1" placeholder="Product Name"><span class="error"><?php echo $product_nameErr;?></span>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputName1">Quantity</label>
                              <input type="text" class="form-control" name="quantity" id="exampleInputName1" placeholder="Product Name"><span class="error"><?php echo $quantityErr;?></span>
                            </div>
                            <div class="form-group">
                              <label for="exampleSelectGender">Supplier</label>
                                <select class="form-control" name="supplier" id="exampleSelectGender">
                              <?php
                                while($row = mysqli_fetch_assoc($get_supplier_data)){
                                  $supplier_id = $row['supplier_id'];
                                  $supplier_name = $row['supplier_name'];
                              ?>    
                                  <option value="<?php echo $supplier_id;?>"><?php echo $supplier_name;?></option>
                              <?php
                                }
                              ?>
                                   
                                </select><span class="error"><?php echo $supplierErr;?></span>
                            </div>                           
                            <div class="form-group">
                              <label for="exampleSelectGender">Category</label>
                                <select class="form-control" name="category" id="exampleSelectGender">
                              <?php
                                while($row1 = mysqli_fetch_assoc($get_category_data)){
                                  $category_id = $row1['category_id'];
                                  $category_name = $row1['category_name'];
                              ?>    
                                  <option value="<?php echo $category_id?>"><?php echo $category_name;?></option>
                              <?php
                                }
                              ?>    
                                  
                                </select><span class="error"><?php echo $categoryErr;?></span>
                            </div>
                            <div class="form-group">
                              <label for="exampleTextarea1">Description</label>
                              <textarea class="form-control" id="exampleTextarea1" name="description" rows="4"></textarea><span class="error"><?php echo $descriptionErr;?></span>
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
                  <h4 class="card-title">Product List</h4>
                  
                  <div class="table-responsive pt-3">
                    <table class="table table-dark">
                      <thead>
                        <tr>
                          <th>
                            Product Id
                          </th>
                          <th>
                            Product Name
                          </th>
                          <th>
                            Quantity
                          </th>
                          <th>
                            Supplier
                          </th>
                          <th>
                            Category
                          </th>   
                          <th>
                            Description
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                    <?php
                      while($row4 = mysqli_fetch_assoc($get_product_data)){
                        $db_product_id = $row4['product_id'];
                        $db_product_name = $row4['product_name'];
                        $db_quantity = $row4['quantity'];
                        $db_product_supplier = $row4['supplier_name'];
                        $db_product_category = $row4['category_name'];
                        $db_product_description = $row4['description'];
                    ?>    
                        <tr>
                          <td>
                            <?php echo $db_product_id;?>
                          </td>
                          <td>
                            <?php echo $db_product_name;?>
                          </td>
                           <td>
                            <?php echo $db_quantity;?>
                          </td>
                          <td>
                            <?php echo $db_product_supplier;?>
                          </td>
                          <td>
                            <?php echo $db_product_category;?>
                          </td>
                           <td>
                            <?php echo $db_product_description;?>
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
