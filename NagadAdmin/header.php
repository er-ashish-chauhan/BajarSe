<?php
require 'dbconfig.php';

ini_set("session.gc_maxlifetime", "3600");
ini_set("session.cookie_lifetime","3600");

session_start();
if($_SESSION['username']==""){
  echo "<script> window.location = 'login.php'</script>";
}
$db=db_connect();
?>

  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <!-- <span class="logo-mini"><b>A</b>LT</span> -->
      <!-- logo for regular state and mobile devices -->
     
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <!-- <span class="sr-only">Toggle navigation</span> -->
      </a>
      <div class="search-container" style="display: none;">

      <input type="text" class="search-input" placeholder="Search..."/>
      <span><button><i class="fa fa-search"></i></button></span>

      </div>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <li class="dropdown user user-menu pr-20 active">
          
            <a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  

      <style type="text/css">
.election-modal{
  background: #00000075;
    padding: 50px;
    position: absolute;
    height: 100%;
    width: 100%;
    z-index: 6000;
    display: none;
        top: 0px;
}

.election-modal-inner{

    background: white;
    padding: 10px;
    width: 30%;
    margin-left: 35%;
    margin-right: 35%;

}


</style>

  <!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>

<!-- ChartJS 1.0.1 -->
<script src="plugins/chartjs/Chart.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>