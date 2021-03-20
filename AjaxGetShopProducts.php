<?php
session_start();
require 'nagad_db.php';
$shop_id=$_REQUEST["shop_id"];
$active_status=1;
$date=date('yy-m-d');

$db=connect_db();
$sql="SELECT products.id,catalogue_id,product_name,product_description,price,offer_available,products.created_at,products.active_status,offer_id,shop_setting.business_name as shop_name FROM products JOIN shop_setting ON shop_setting.id = products.shop_id WHERE shop_id='$shop_id' && products.active_status='$active_status' ORDER BY products.created_at DESC";
$exe= $db->query($sql);
  $results_array = array();
  if($exe->num_rows>0){
    while ($row = $exe->fetch_assoc()) {
      $dataArray = array();
      $dataArray['id'] = $row['id'];
      $dataArray['catalogue_id'] = $row['catalogue_id'];
      $dataArray['product_name'] = $row['product_name'];
      $dataArray['product_description'] = $row['product_description'];
      $dataArray['price'] = $row['price'];
      $dataArray['offer_available'] = $row['offer_available'];
      $dataArray['active_status'] = $row['active_status'];
      $dataArray['offer_id'] = $row['offer_id'];
      $dataArray['shop_name'] = $row['shop_name'];
      

      if($row['offer_available']==1){
        $sql1="SELECT id,offer_type,discount,other_detail,start_date,end_date FROM offers_new WHERE active_status='$active_status' && (end_date >= STR_TO_DATE('$date', '%Y-%m-%d') && start_date <= STR_TO_DATE('$date', '%Y-%m-%d')) && id='".$row['offer_id']."'";
        $exe1= $db->query($sql1);
        if($exe1->num_rows>0){
          $results_offer = $exe1->fetch_all(MYSQLI_ASSOC);
          $dataArray['offer_type'] = $results_offer[0]['offer_type'];
          $dataArray['discount'] = $results_offer[0]['discount'];
          $dataArray['other_detail'] = $results_offer[0]['other_detail'];
          $dataArray['start_date'] = $results_offer[0]['start_date'];
          $dataArray['end_date'] = $results_offer[0]['end_date'];
        }else{
          $dataArray['offer_type'] = 0;
          $dataArray['discount'] = 0;
          $dataArray['other_detail'] = "";
          $dataArray['start_date'] = '';
          $dataArray['end_date'] = '';
          $dataArray['offer_available'] = 0;
        }
        
      }else{
        $dataArray['offer_type'] = 0;
        $dataArray['discount'] = 0;
        $dataArray['other_detail'] = "";
        $dataArray['start_date'] = '';
        $dataArray['end_date'] = '';
      }

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