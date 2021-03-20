<?php
include("dbconfig.php");
session_start();

$title=$_REQUEST["title"];
$message=$_REQUEST["message"];
$db = db_connect();


  $sql_firebase = "SELECT firebase_token FROM users WHERE firebase_token!=''";
  $result_firebase = $db->query($sql_firebase);
  if($result_firebase->num_rows>0){
    $myTokenArray = array();
    while ($row = $result_firebase->fetch_assoc()) {
      // $dataResultFirebase['firebase_token'] = $row['firebase_token'];
      array_push($myTokenArray, $row['firebase_token']);
    }
    //$dataResultFirebase = $result_firebase->fetch_all(MYSQLI_ASSOC);
    //$myTokenArray = array();
    // array_push($myTokenArray, $dataResultFirebase['firebase_token']);
    $notification_result = sendNotification($message,$title,$myTokenArray);

    $success = explode("-", $notification_result)[0];
    $failure = explode("-", $notification_result)[1];

    $sql = "INSERT INTO notifications(title,message,success,failure,created_at)"." VALUES('".$title."','".$message."','".$success."','".$failure."',now())";
    $exe = $db->query($sql);
    $last_id = $db->insert_id;
    if(!empty($last_id)){
      $data1= array('status'=>true, 'message'=>"Notification sent.");
      echo json_encode($data1);
    }else{
      $data1= array('status'=>false, 'message'=>"Notification did not send.");
      echo json_encode($data1);
    }      
  }else{
    $data1= array('status'=>false, 'message'=>"User not found.");
    echo json_encode($data1);
  }



function sendNotification($message_body,$title,$tokens){
$success=0;
$failure=0;

$currentDateTime = date('Y-m-d H:i:s');
$DEFAULT_URL = 'https://fcm.googleapis.com/fcm/send';

$registrationIds = $tokens;
$message = array
       (
        'message'   => $message_body,
        'title'     => $title ,
        'vibrate'   => 1,
        'sound'     => 1,
        'priority'  =>'high'  
        );

$serverKey = "AAAA6PKFXcM:APA91bH-Qk7UgBUu3rbk2e8mlajSYTAH4CgAXpf4wZ3CMF-5kaG6g3lbQq9O_PnPheWiklMTfRnO4mALdAmuQuc5-8lW9MUe8LZ_7atBD8dEj71wO_CfB0oRpwPNHmE9A0QppcWV36rI";

$headers = array(
    'Authorization:key='.$serverKey,
    'Content-Type:application/json');

    $fields = array('registration_ids'=>$registrationIds,
        'data'=>$message);
    $payload = json_encode($fields);
    $curl_session = curl_init();
    curl_setopt($curl_session, CURLOPT_URL, $DEFAULT_URL);
    curl_setopt($curl_session, CURLOPT_POST, true);
    curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_session, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($curl_session, CURLOPT_POSTFIELDS,$payload);

    $result = curl_exec($curl_session);
    //echo $result;
    $result = json_decode($result);
    
    if($result === FALSE){
      $success=0;
      $failure=0;
            //die('Curl failed: ' . curl_error($curl_session));
    }else{
      $success=$result->success;
      $failure=$result->failure;
    }
    curl_close($curl_session);
    //echo $result;
    return $success."-".$failure;
}
?>