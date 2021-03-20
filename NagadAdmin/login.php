<?php
require 'dbconfig.php';
session_start();
$db = db_connect();
if(isset($_POST["username"]) && $_POST["username"]!="" && isset($_POST["password"]) && $_POST["password"]!=""){



  if($_POST["username"]=="admin" && $_POST["password"]=="123456"){
    // $data = $exe->fetch_all(MYSQLI_ASSOC);
    $_SESSION["username"] = "admin";
    //$_SESSION["userid"] = $data[0]['id'];
    header('Location: user_list.php');
    
  }else{
    $message = "Username or Password is wrong.";
    echo "<script type='text/javascript'>alert('$message');</script>";
    header("Refresh:0");
  }

}
?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Nagad</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
  
  </div>

 

  <!-- /.login-logo -->
  <div class="login-box-body">
 <div class="mycompany-name">
  Nagad
  </div>
    <hr>
    <div class="theme-form">
    <form action="login.php" method="post">
          <div class="login-header" style="display:none">Sign in to Admin Panel</div>
          <div class="login-inner-box">
      <div class="form-group has-feedback">
      <label style="display:none">Username</label>
        <input type="text" class="form-control" placeholder="Username" name="username" required>
        <i class="fa fa-user login-inner-icon"></i>
     </div>
     
      <div class="form-group has-feedback">
      <label style="display:none">Password</label>
        <input type="password" class="form-control" placeholder="Password" name="password" autocomplete="off" required>
        <i class="fa fa-lock login-inner-icon"></i>
      </div>

      <div class="row">
        
        <!-- /.col -->
        <div class="col-xs-12">
        <center><input type="submit" class="btn theme-btn " value="Sign In" /></center>
          
        </div>
        <!-- /.col -->
      </div>
       </div>

      </div>
    </form>
    </div>
   
 <!-- <div class="designby-text">Designed By <a href="http://www.cresol.in/" target="blank">Cresol.in</a></div> -->
  </div>

 
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });


</script>
</body>
</html>
