<?php
session_start();
require 'nagad_db.php';
$db=connect_db();
$cust_id=$_REQUEST["cust_id"];
$address=$_REQUEST["address"];

$sql="UPDATE customers SET address='$address' WHERE id='$cust_id'";
$exe = $db->query($sql);
if($exe==1){
  $data = array('status'=>true,'message'=>"Address Updated.");
}else{
  $data = array('status'=>false,'message'=>"Address did not update.");
}
echo json_encode($data);
?>