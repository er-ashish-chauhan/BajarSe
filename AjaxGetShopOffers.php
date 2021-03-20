<?php
session_start();
require 'nagad_db.php';
$shop_id=$_REQUEST["shop_id"];
$active_status=1;
$date=date('yy-m-d');

$db=connect_db();
$sql="SELECT id,products,catalogues,offer_name,offer_type,discount,other_detail,start_date,end_date,active_status,created_at FROM offers_new WHERE shop_id='$shop_id' && active_status='$active_status' && (end_date >= STR_TO_DATE('$date', '%Y-%m-%d') && start_date <= STR_TO_DATE('$date', '%Y-%m-%d')) ORDER BY offer_mode ASC, created_at DESC";

$exe = $db->query($sql);
  $results_array = array();
  if($exe->num_rows>0){
    while ($row = $exe->fetch_assoc()) {
      $dataArray = array();
      $dataArray['id'] = $row['id'];
      $dataArray['products'] = $row['products'];
      $dataArray['catalogues'] = $row['catalogues'];
      $dataArray['offer_name'] = $row['offer_name'];
      $dataArray['offer_type'] = $row['offer_type'];
      $dataArray['discount'] = $row['discount'];
      $dataArray['other_detail'] = $row['other_detail'];
      $dataArray['start_date'] = $row['start_date'];
      $dataArray['end_date'] = $row['end_date'];
      $dataArray['active_status'] = $row['active_status'];


      $sql_products="SELECT id FROM products WHERE offer_id='".$row['id']."'";
      $exe_products = $db->query($sql_products);
      $dataArray['num_products'] = $exe_products->num_rows;
      

      $sql2="SELECT id,image FROM offer_images WHERE offer_id='".$row['id']."'";
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