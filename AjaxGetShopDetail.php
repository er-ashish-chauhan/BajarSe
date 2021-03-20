<?php
session_start();
require 'nagad_db.php';
$shop_id=$_REQUEST["shop_id"];
$active_status=1;
$date=date('yy-m-d');

$db=connect_db();
$sql="SELECT * FROM shop_setting WHERE id='$shop_id'";
$exe = $db->query($sql);
if($exe->num_rows>0){
  $results = $exe->fetch_all(MYSQLI_ASSOC);
  $data = array('status'=>true,'message'=>"Shop found",'shop_name'=>$results[0]['business_name'],'shop_owner'=>$results[0]['shop_owner'],'tagline'=>$results[0]['tagline'],'category'=>$results[0]['category'],'shop_type'=>$results[0]['shop_type'],'shop_image'=>$results[0]['shop_image'],'shop_cover_image'=>$results[0]['shop_cover_image'],'delivery_mode'=>$results[0]['delivery_mode'],'delivery_free'=>$results[0]['delivery_free'],'delivery_charge'=>$results[0]['delivery_charge'],'min_order_value'=>$results[0]['min_order_value'],'max_delivery_distance'=>$results[0]['max_delivery_distance'],'delivery_time'=>$results[0]['delivery_time'],'payment_type'=>$results[0]['payment_type'],'shop_address'=>$results[0]['address'],'shop_mobile_no'=>$results[0]['mobile']);
}else{
  $data = array('status'=>false,'message'=>"Shop not found");
}

echo json_encode($data);
?>