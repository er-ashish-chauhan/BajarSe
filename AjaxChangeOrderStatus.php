<?php
session_start();
require 'nagad_db.php';
$db=connect_db();
$order_id=$_REQUEST["order_id"];
$status=$_REQUEST["status"];

$sql="UPDATE orders SET status='$status' WHERE id='$order_id'";
$exe = $db->query($sql);
if($exe==1){
  $data = array('status'=>true,'message'=>"Order Updated.");
}else{
  $data = array('status'=>false,'message'=>"Order did not update.");
}
echo json_encode($data);
?>