<?php
session_start();
require 'nagad_db.php';
$product_id=$_REQUEST["product_id"];


$db=connect_db();
mysqli_set_charset($db, 'utf8');
$result_data = array();
$sql="SELECT product_name,product_description,price,active_status,offer_available,offer_id FROM products WHERE id='$product_id'";
$exe = $db->query($sql);
if($exe->num_rows>0){
  $results_product = $exe->fetch_all(MYSQLI_ASSOC);
  $result_data['product_name']=$results_product[0]['product_name'];
  $result_data['product_description']=$results_product[0]['product_description'];
  $result_data['price']=$results_product[0]['price'];
  $result_data['active_status']=$results_product[0]['active_status'];
  $result_data['offer_available']=$results_product[0]['offer_available'];
  $result_data['offer_id']=$results_product[0]['offer_id'];
  $result_data['status']=true;
  $result_data['message']="Data fetched.";
}

if($result_data['offer_available']==1){
  $sql1="SELECT id,offer_type,discount,other_detail,start_date,end_date FROM offers_new WHERE id='".$result_data['offer_id']."'";
  $exe1= $db->query($sql1);
  if($exe1->num_rows>0){
    $results_offer = $exe1->fetch_all(MYSQLI_ASSOC);
    $result_data['offer_type'] = $results_offer[0]['offer_type'];
    $result_data['discount'] = $results_offer[0]['discount'];
    $result_data['other_detail'] = $results_offer[0]['other_detail'];
    $result_data['start_date'] = $results_offer[0]['start_date'];
    $result_data['end_date'] = $results_offer[0]['end_date'];
  }else{
    $result_data['offer_type'] = 0;
    $result_data['discount'] = 0;
    $result_data['other_detail'] = "";
    $result_data['start_date'] = '';
    $result_data['end_date'] = '';
  }
  
}else{
  $dataArray['offer_type'] = 0;
  $dataArray['discount'] = 0;
  $dataArray['other_detail'] = "";
  $dataArray['start_date'] = '';
  $dataArray['end_date'] = '';
}

$sql2="SELECT id,image FROM product_images WHERE product_id='".$product_id."'";
$exe2= $db->query($sql2);
if($exe2->num_rows>0){
  $results_images = $exe2->fetch_all(MYSQLI_ASSOC);
  $result_data['images'] = $results_images;
}else{
  $result_data['images'] = array();
}

echo json_encode($result_data);

?>