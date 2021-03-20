<?php
session_start();
require 'nagad_db.php';
$db=connect_db();
$mobile=$_REQUEST["mobile"];
$otp="0000";

$sql1 = "SELECT otp FROM customers WHERE mobile='$mobile'";
$exe1 = $db->query($sql1);
if($exe1->num_rows>0){
	$results_data = $exe1->fetch_all(MYSQLI_ASSOC);
    $otp=$results_data[0]['otp'];
}
$message=$otp." is your Nagad OTP. Please enter the same to complete your mobile verification.";


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
?>