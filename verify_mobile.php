<?php
session_start();
require 'nagad_db.php';

if(isset($_SESSION['user_id']) && isset($_SESSION['mobile'])){
    header("Location: stores.php");
    die();
}


if(isset($_POST['mobile'])){
    $mobile=$_POST['mobile'];
    $signup_referral_code=$_POST['referral_code'];
    $referral_code="";

    if($mobile==""){
        $message = "Mobile number can not empty.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }else{
        $db=connect_db();
        $sql1 = "SELECT id,referral_code,signup_referral_code FROM customers WHERE mobile='$mobile'";
        $exe1 = $db->query($sql1);
        if($exe1->num_rows>0){
            $results_data = $exe1->fetch_all(MYSQLI_ASSOC);
            $user_id=$results_data[0]['id'];
            $referral_code=$results_data[0]['referral_code'];
            if($results_data[0]['signup_referral_code']!=""){
              $signup_referral_code=$results_data[0]['signup_referral_code'];
            }
            
        }else{
            $sql = "INSERT INTO customers(mobile,signup_referral_code,created_at)"." VALUES('".$mobile."','".$signup_referral_code."',now())";
            $exe = $db->query($sql);
            $user_id = $db->insert_id;
        }
        
        if($user_id!=0){
          if($referral_code==""){
            $referral_code=generateReferralCode($user_id);
          }
            $_SESSION['mobile'] = $mobile;
            $_SESSION['user_id'] = $user_id;
            header("Location: stores.php");
    die();
            // $otp = getOTP();
            // $sql1 = "UPDATE customers SET otp='$otp',referral_code='$referral_code',signup_referral_code='$signup_referral_code' WHERE id='$user_id'";
            // $exe1 = $db->query($sql1);

            // if($exe1==1){
            //     $message=$otp." is your Nagad OTP. Please enter the same to complete your mobile verification.";
            //     send_sms($mobile,$message);
            //     header("Location: verify_pin.php");
            //     die();
            // }
        }
    }
}

function getOTP(){
    $otp = rand(1111,9999);
    return $otp;
}

function generateReferralCode($userid){
  return strtoupper(substr(base_convert(sha1(uniqid($userid)), 16, 36), 0, 10));
}

function send_sms($mobile,$message){
  // Authorisation details.
  $username = "app.nagad@gmail.com";
  $hash = "c2d6fc2d05c5504ccc53aa48e19a2f492a3c57e1a1ab48dded66a87718bb0beb";

  // Config variables. Consult http://api.textlocal.in/docs for more info.
  $test = "0";

  // Data for text message. This is the text message data.
  $sender = "NGDAPP"; // This is who the message appears to be from.
  $numbers = "91".$mobile; // A single number or a comma-seperated list of numbers
  //$message = "1234 is your Nagad OTP. Please enter the same to complete your mobile verification.";
  // 612 chars or less
  // A single number or a comma-seperated list of numbers
  $message = urlencode($message);
  $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
  $ch = curl_init('http://api.textlocal.in/send/?');
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $result = curl_exec($ch); // This is the result from the API
  curl_close($ch);

  $json = json_decode($result);
  if($json->status=="success"){
    $data1= array('status'=>true, "message"=>"SMS has been sent.");
  }else{
    $data1= array('status'=>true, "message"=>"SMS did not send.");
  }
  echo json_encode($data1);
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
    <body class="overflow-hidden">
         <!-- title -->
        <div class="page-title text-center">
            Login
            <div class="sub-heading">Enter your Mobile Number to <br>access your account</div> 
        </div>

        <!-- mid-area -->
        <form action="verify_mobile.php" method="post">
        <div >
            <div class="text-center">
                <div class="container">
                    <div class="theme-form mt-per-20">
                        
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Enter your Mobile Number</label>
                                        <div class="code-country">+91</div>
                                        <input type="text" name="mobile" class="form-control pl-60" placeholder="9963105236">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label>Have a Referral Code?</label>
                                        <input type="text" name="referral_code" class="form-control" placeholder="Enter the Referral Code" >
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                </div>

            </div>
        </div>
        
         <!-- footer -->

        <div class="footer-part text-center  mb-4" >
            <input type="submit" class="btn btn-primary btn-block" value="Get Pin">
            <!-- <a href="verify_pin.html" class="btn btn-primary btn-block"> Get Pin </a> -->
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
