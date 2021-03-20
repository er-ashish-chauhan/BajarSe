<?php
session_start();
require 'nagad_db.php';
$order_id=$_REQUEST["order_id"];
$active_status=1;
$date=date('yy-m-d');

$db=connect_db();
$sql="SELECT order_details.quantity,order_details.price,order_details.additional_item,products.id,products.product_name FROM order_details INNER JOIN products ON (products.id=order_details.product_id) WHERE order_details.order_id='$order_id'";

$exe= $db->query($sql);
  $results_array = array();
  if($exe->num_rows>0){
    while ($row = $exe->fetch_assoc()) {
      $dataArray = array();
      $dataArray['id'] = $row['id'];
      $dataArray['quantity'] = $row['quantity'];
      $dataArray['product_name'] = $row['product_name'];
      $dataArray['price'] = $row['price'];
      $dataArray['additional_item'] = $row['additional_item'];
      
      $sql2="SELECT id,image FROM product_images WHERE product_id='".$row['id']."'";
      $exe2= $db->query($sql2);
      if($exe2->num_rows>0){
        $results_images = $exe2->fetch_all(MYSQLI_ASSOC);
        $dataArray['image'] = $results_images[0]['image'];
      }else{
        $dataArray['image'] = "";
      }

      $results_array[] = $dataArray;
    }
  }
  echo json_encode($results_array);
?>