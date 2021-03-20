<?php
session_start();
require 'nagad_db.php';
$db=connect_db();

$shop_id=$_REQUEST["shop_id"];
$cust_id=$_REQUEST["cust_id"];

$sql="SELECT id FROM cust_fav_stores WHERE shop_id=$shop_id && cust_id=$cust_id";
$exe = $db->query($sql);
if($exe->num_rows>0){
	$results = $exe->fetch_all(MYSQLI_ASSOC);
	$id = $results[0]['id'];
	$sql="DELETE FROM cust_fav_stores WHERE id=$id";
	$exe = $db->query($sql);
	if($exe==1){
		$data = array('status'=>true,'message'=>'Shop removed from favourite list.');	
	}else{
		$data = array('status'=>true,'message'=>'Shop did not remove from favourite list.');
	}
	
}else{
  $sql = "INSERT INTO cust_fav_stores(shop_id,cust_id,created_at)"." VALUES('$shop_id','$cust_id',now())";
  $exe = $db->query($sql);
  $fav_store_id = $db->insert_id;
  if(!empty($fav_store_id)){
    $data = array('status'=>true,'message'=>'Shop added to favourite list.');
  }else{
    $data = array('status'=>false,'message'=>'Shop did not add to favourite list.');
  }
}

echo json_encode($data);
?>