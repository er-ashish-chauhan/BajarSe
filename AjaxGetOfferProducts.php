<?php
session_start();
require 'nagad_db.php';
$offer_id=$_REQUEST["offer_id"];
$shop_id=$_REQUEST["shop_id"];
$active_status=1;
$date=date('yy-m-d');

$db=connect_db();

$sql="SELECT id,products,catalogues,discount,other_detail,offer_type,start_date,end_date FROM offers_new WHERE shop_id='$shop_id' && id='$offer_id'";
  $exe = $db->query($sql);
  $results_array = array();

  if($exe->num_rows>0){
    $results_offer = $exe->fetch_all(MYSQLI_ASSOC);
    $sql1="SELECT id,catalogue_id,product_name,product_description,price,offer_available,offer_id,created_at FROM products WHERE offer_id=$offer_id";
    $exe1 = $db->query($sql1);

    if($exe1->num_rows>0){
      while ($row = $exe1->fetch_assoc()) {
        $dataArray = array();
        $dataArray['id'] = $row['id'];
        $dataArray['catalogue_id'] = $row['catalogue_id'];
        $dataArray['product_name'] = $row['product_name'];
        $dataArray['product_description'] = $row['product_description'];
        $dataArray['price'] = $row['price'];
        $dataArray['offer_available'] = $row['offer_available'];

        $dataArray['discount'] = $results_offer[0]['discount'];
        $dataArray['other_detail'] = $results_offer[0]['other_detail'];
        $dataArray['offer_type'] = $results_offer[0]['offer_type'];
        $dataArray['start_date'] = $results_offer[0]['start_date'];
        $dataArray['end_date'] = $results_offer[0]['end_date'];
        


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
  }
  echo json_encode($results_array);
?>