<?php
session_start();
require 'nagad_db.php';

$mobile = $_SESSION['mobile'];
//$user_id = $_SESSION['user_id'];
$otp="";


if(isset($_POST['pin'])){
    $pin=$_POST['pin'];
    if($pin==""){
        $message = "OTP can not empty.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }else{
        $db=connect_db();
        $sql1 = "SELECT otp,id FROM customers WHERE mobile='$mobile'";
        $exe1 = $db->query($sql1);
        if($exe1->num_rows>0){
            $results_data = $exe1->fetch_all(MYSQLI_ASSOC);
            $otp=$results_data[0]['otp'];
            if($otp==$pin){
                $_SESSION['user_id'] = $results_data[0]['id'];
                header("Location: personal_detail.php");
                die();
            }else{
                $message = "PIN is not correct.";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
        }else{
            $message = "PIN not found.";
                echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Bajarse</title>
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.12.1/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body class="height-auto">
         <!-- title -->
        <div class="page-title text-center">
            Verify your Mobile Number
            <div class="sub-heading">Enter verification code which has been <br>sent on below mobile number </div> 

            <div class="user-number">+91 <?php echo $_SESSION['mobile'];?></div>
        </div>

        <!-- mid-area -->
        <form action="verify_pin.php" method="post">
        <div >
            <div class="text-center">
                <div class="container">
                    <div class="theme-form mt-per-25">
                        
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Enter your 4 digit Pin Number</label>
                                        <input type="number" name="pin" class="form-control pin" maxlength="4" onkeyup="if(this.value.length == 4) this.blur()" pattern="[0-9]*">
                                        <div class="text-center small-note mt-3" >Code not received yet? <a onclick="sendSms('<?php echo $mobile; ?>');" href="#" class="color-secondary font-weight-bold"><u>Retry?</u></b></a></div>
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                </div>

            </div>
        </div>
        
         <!-- footer -->

        <div class="footer-part text-center mb-4 " >
            <input type="submit" class="btn btn-primary btn-block" value="Submit">
             <!-- <a href="personal_detail.html" class="btn btn-primary btn-block"> Submit </a> -->
        </div>
        </form>

      

     


       


        
        
        
    
        <!-- Bootstrap core JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <!-- Contact form JS-->
        <script src="assets/mail/jqBootstrapValidation.js"></script>
        <script src="assets/mail/contact_me.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>

<script type="text/javascript">
    
function sendSms(mobile){
  //alert(mobile);
  $.ajax({
    url:"AjaxSendSms.php",
    data:{mobile:mobile},
    type:'post',
    dataType: 'json',
    success:function(response){
      console.log(response);
      alert(response['message']);
      if(response['status']){

      }
      
    }
  });
}
</script>
