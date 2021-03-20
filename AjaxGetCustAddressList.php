<?php
session_start();
require 'nagad_db.php';
$cust_id=$_REQUEST["cust_id"];
$db=connect_db();
$sql="SELECT id,house_no,address,area,landmark,lat,lon FROM customer_address WHERE cust_id='$cust_id'";
$exe = $db->query($sql);
$dataArray = array();
if($exe->num_rows>0){
  $results = $exe->fetch_all(MYSQLI_ASSOC);
  foreach ($results as $key => $value) {
    $address = $value['house_no'].",".$value['area'].",".$value['address'];
    array_push($dataArray, array('id'=>$value['id'],'address'=>$address,'lat'=>$value['lat'],'lon'=>$value['lon']));
  }
}
echo json_encode($dataArray);
?>