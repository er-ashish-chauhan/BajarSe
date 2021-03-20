<?php
session_start();
require 'nagad_db.php';
$shop_id=$_REQUEST["shop_id"];
$active_status=1;
$date=date('yy-m-d');

$db=connect_db();
$sql="SELECT id,catalog_name,catalog_detail,products,user_id,active_status,created_at FROM catalogs WHERE shop_id='$shop_id' && active_status='$active_status' ORDER BY created_at DESC";

$exe = $db->query($sql);
  $results_array = array();
  if($exe->num_rows>0){
    while ($row = $exe->fetch_assoc()) {
      $dataArray = array();
      $dataArray['id'] = $row['id'];
      $dataArray['catalog_name'] = $row['catalog_name'];
      $dataArray['catalog_detail'] = $row['catalog_detail'];
      $dataArray['products'] = $row['products'];
      $dataArray['user_id'] = $row['user_id'];
      $dataArray['active_status'] = $row['active_status'];
      $dataArray['views'] = 25;
      

      $sql2="SELECT image FROM catalog_images WHERE catalogue_id='".$row['id']."'";
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