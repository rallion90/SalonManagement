<?php session_start();?>
<?php include('../connection.php');?>

<?php 

  if(isset($_SESSION['employee_id'])){
    $verify_customer = "";
    $verify_customerErr = "";
    $pointsUp = 2;
    mysqli_query($connect, "DELETE FROM booking WHERE date_reserved < CURDATE()");
    $employee_id = $_SESSION['employee_id'];
    $get_record = mysqli_query($connect, "SELECT * FROM employee WHERE employee_id='$employee_id'");
    $row = mysqli_fetch_assoc($get_record);
    $db_username = ucfirst($row['employee_name']); 

    $populatedatatotable = mysqli_query($connect, "SELECT * FROM booking WHERE employee_id='$employee_id' AND booking_condition='1' ORDER BY date_reserved");

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
            $get_user_id = $fetch_customer_id['user_id'];
            $result = mysqli_query($connect, "UPDATE login SET points = points + $pointsUp WHERE user_id='$get_user_id'");

            
            
          }
          else{
            echo "Invalid Verification Number";
          }
        }
        else{
          $verify_customerErr = "This must be Number!";
        }
      }

    }else{

    }
    
  }
  else{
    header('Location: login.php');
  }
?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
  <meta name="author" content="GeeksLabs">
  <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
  <link rel="shortcut icon" href="img/favicon.png">

  <title>Employee's Dashboard</title>

  <!-- Bootstrap CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="css/bootstrap-theme.css" rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="css/elegant-icons-style.css" rel="stylesheet" />
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <!-- Custom styles -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet" />

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
  <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <script src="js/lte-ie7.js"></script>
    <![endif]-->

    <!-- =======================================================
      Theme Name: NiceAdmin
      Theme URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
      Author: BootstrapMade
      Author URL: https://bootstrapmade.com
    ======================================================= -->
</head>

<body>
  <!-- container section start -->
  <section id="container" class="">
    <!--header start-->
    <header class="header dark-bg">
      <div class="toggle-nav">
        <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
      </div>

      <!--logo start-->
      <a href="index.html" class="logo">Employee's <span class="lite">Dashboard</span></a>
      <!--logo end-->

      <div class="nav search-row" id="top_menu">
        <!--  search form start -->
        <ul class="nav top-menu">
          <li>
            <form class="navbar-form">
              <input class="form-control" placeholder="Search" type="text">
            </form>
          </li>
        </ul>
        <!--  search form end -->
      </div>

      <div class="top-nav notification-row">
        <!-- notificatoin dropdown start-->
        <ul class="nav pull-right top-menu">

          <!-- task notificatoin start -->
          <li id="task_notificatoin_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon-task-l"></i>
                            <span class="badge bg-important">1</span>
                        </a>
            <ul class="dropdown-menu extended tasks-bar">
              <div class="notify-arrow notify-arrow-blue"></div>
              <li>
                <p class="blue">You have 1 pending tasks</p>
              </li>
              <li>
                <a href="#">
                  <div class="task-info">
                    <div class="desc">Design PSD </div>
                    <div class="percent">90%</div>
                  </div>
                  <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%">
                      <span class="sr-only">90% Complete (success)</span>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a href="#">
                  <div class="task-info">
                    <div class="desc">
                      Project 1
                    </div>
                    <div class="percent">30%</div>
                  </div>
                  <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%">
                      <span class="sr-only">30% Complete (warning)</span>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a href="#">
                  <div class="task-info">
                    <div class="desc">Digital Marketing</div>
                    <div class="percent">80%</div>
                  </div>
                  <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                      <span class="sr-only">80% Complete</span>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a href="#">
                  <div class="task-info">
                    <div class="desc">Logo Designing</div>
                    <div class="percent">78%</div>
                  </div>
                  <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 78%">
                      <span class="sr-only">78% Complete (danger)</span>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a href="#">
                  <div class="task-info">
                    <div class="desc">Mobile App</div>
                    <div class="percent">50%</div>
                  </div>
                  <div class="progress progress-striped active">
                    <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                      <span class="sr-only">50% Complete</span>
                    </div>
                  </div>

                </a>
              </li>
              <li class="external">
                <a href="#">See All Tasks</a>
              </li>
            </ul>
          </li>
          <!-- task notificatoin end -->
          <!-- inbox notificatoin start-->
          <li id="mail_notificatoin_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon-envelope-l"></i>
                            <span class="badge bg-important">5</span>
                        </a>
            <ul class="dropdown-menu extended inbox">
              <div class="notify-arrow notify-arrow-blue"></div>
              <li>
                <p class="blue">You have 5 new messages</p>
              </li>
              <li>
                <a href="#">
                                    <span class="photo"><img alt="avatar" src="./img/avatar-mini.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Greg  Martin</span>
                                    <span class="time">1 min</span>
                                    </span>
                                    <span class="message">
                                        I really like this admin panel.
                                    </span>
                                </a>
              </li>
              <li>
                <a href="#">
                                    <span class="photo"><img alt="avatar" src="./img/avatar-mini2.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Bob   Mckenzie</span>
                                    <span class="time">5 mins</span>
                                    </span>
                                    <span class="message">
                                     Hi, What is next project plan?
                                    </span>
                                </a>
              </li>
              <li>
                <a href="#">
                                    <span class="photo"><img alt="avatar" src="./img/avatar-mini3.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Phillip   Park</span>
                                    <span class="time">2 hrs</span>
                                    </span>
                                    <span class="message">
                                        I am like to buy this Admin Template.
                                    </span>
                                </a>
              </li>
              <li>
                <a href="#">
                                    <span class="photo"><img alt="avatar" src="./img/avatar-mini4.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Ray   Munoz</span>
                                    <span class="time">1 day</span>
                                    </span>
                                    <span class="message">
                                        Icon fonts are great.
                                    </span>
                                </a>
              </li>
              <li>
                <a href="#">See all messages</a>
              </li>
            </ul>
          </li>
          <!-- inbox notificatoin end -->
          <!-- alert notification start-->
          <li id="alert_notificatoin_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                            <i class="icon-bell-l"></i>
                            <span class="badge bg-important">7</span>
                        </a>
            <ul class="dropdown-menu extended notification">
              <div class="notify-arrow notify-arrow-blue"></div>
              <li>
                <p class="blue">You have 4 new notifications</p>
              </li>
              <li>
                <a href="#">
                                    <span class="label label-primary"><i class="icon_profile"></i></span>
                                    Friend Request
                                    <span class="small italic pull-right">5 mins</span>
                                </a>
              </li>
              <li>
                <a href="#">
                                    <span class="label label-warning"><i class="icon_pin"></i></span>
                                    John location.
                                    <span class="small italic pull-right">50 mins</span>
                                </a>
              </li>
              <li>
                <a href="#">
                                    <span class="label label-danger"><i class="icon_book_alt"></i></span>
                                    Project 3 Completed.
                                    <span class="small italic pull-right">1 hr</span>
                                </a>
              </li>
              <li>
                <a href="#">
                                    <span class="label label-success"><i class="icon_like"></i></span>
                                    Mick appreciated your work.
                                    <span class="small italic pull-right"> Today</span>
                                </a>
              </li>
              <li>
                <a href="#">See all notifications</a>
              </li>
            </ul>
          </li>
          <!-- alert notification end-->
          <!-- user login dropdown start-->
          <li class="dropdown">
        <?php

            //if(isset($_SESSION['barber_id'])){ 
              //$barber_id = $_SESSION['barber_id'];
              //$get_record = mysqli_query($connect, "SELECT * FROM barber_haircut WHERE barber_id='$barber_id'");
              //$row = mysqli_fetch_assoc($get_record);
              //$db_username = ucfirst($row['barber_name']); 

              echo "<a data-toggle='dropdown' class='dropdown-toggle' href='#'>
                    <span class='username'>$db_username</span>
                      <b class='caret'></b>
                    </a>
                <ul class='dropdown-menu extended logout'>
                  <div class='log-arrow-up'></div>
                  <li class='eborder-top'>
                    <a href='#'><i class='icon_profile'></i> My Profile</a>
                  </li>
                  <li>
                    <a href='#'><i class='icon_mail_alt'></i> My Inbox</a>
                  </li>
                 
                  <li>
                    <a href='#'><i class='icon_chat_alt'></i> Chats</a>
                  </li>
                  <li>
                    <a href='logout.php'><i class='icon_key_alt'></i> Log Out</a>
                  </li>
                </ul>";
            //}    
        ?>    
          </li>
          <!-- user login dropdown end -->
        </ul>
        <!-- notificatoin dropdown end-->
      </div>
    </header>
    <!--header end-->

    <!--sidebar start-->
    <aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
          
          
          
          
          

          <li class="sub-menu">
            <a href="javascript:;" class="">
                          <i class="icon_table"></i>
                          <span>Customer</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <li><a class="active" href="basic_table.php">Pending</a></li>
              <li><a class="active" href="accepted.php">Accepted</a></li>
              <li><a class="active" href="#">Users</a></li>
            </ul>
          </li>

         

        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-table"></i> Table</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
              <li><i class="fa fa-table"></i>Table</li>
              <li><i class="fa fa-th-list"></i>Basic Table</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
          
        
        
          <br>
          <div class="col-lg-12">

            <section class="panel">
              
              <header class="panel-heading">
                Accepted Customer
              </header>


  
              <table class="table table-striped table-advance table-hover">
                <tbody>
                  <tr>
                    
                    <th><i class="fas fa-user-tie"></i>Full Name</th>
                    <th><i class="fas fa-concierge-bell"></i>Service</th>
                    <th><i class="fas fa-calendar-day"></i>Date Reserved</th>
                    <th>Time</th>
                    
                  </tr>
                  
              <?php
                while($row = mysqli_fetch_assoc($populatedatatotable)){
                 
                  $db_fullname = $row['fullname'];
                  $db_haircut = $row['service_name'];
                  $db_date_reserved = $row['date_reserved'];
                  $db_time_reserved = $row['time_reserved'];
                  $db_haircut_id = $row['booking_id'];       
              ?> 
              <tr>
                    
                    <td><?php echo $db_fullname;?></td>
                    <td><?php echo ucwords($db_haircut);?></td>
                    <td><?php echo $db_date_reserved;?></td>
                    <td><?php echo $db_time_reserved;?></td>
                    
                  </tr>  
              <?php
                }
              ?>      
                  
                  
                </tbody>
              </table>
            </section>
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>
    <!--main content end-->
    <div class="text-right">
      <div class="credits">
          <!--
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
          -->
         <a href="#">Rowelyn Caberto | Kim Daryll Malabanan | Troi Decuzar</a>
        </div>
    </div>
  </section>
  <!-- container section end -->
  <!-- javascripts -->

  <script type="text/javascript">
   
  </script>

  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- nicescroll -->
  <script src="js/jquery.scrollTo.min.js"></script>
  <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
  <!--custome script for all page-->
  <script src="js/scripts.js"></script>
<script src="https://kit.fontawesome.com/ff1f1d4454.js"></script>

</body>

</html>