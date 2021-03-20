<?php
session_start();
require 'nagad_db.php';
$cust_id=$_REQUEST["cust_id"];
$status=$_REQUEST["status"];
$search=$_REQUEST["search"];
$search="%".$search."%";

if($search!=""){
  $search=" && (shop_setting.business_name LIKE '".$search."' OR orders.order_id LIKE '".$search."')";
}else{
  $search="";
}

$db=connect_db();
if($status==0){
  $sql="SELECT orders.id,orders.order_id,orders.no_items,orders.total_cost,orders.shop_id,orders.customer_id,orders.payment_type,orders.note,orders.delivery_charge,orders.discount_amount,orders.payment_amount,orders.additional_cost,orders.address,orders.status,orders.created_at,customers.name,customers.mobile,shop_setting.business_name FROM orders INNER JOIN customers ON (customers.id=orders.customer_id) INNER JOIN shop_setting ON (shop_setting.id=orders.shop_id) WHERE orders.customer_id='".$cust_id."' ".$search." ORDER BY orders.created_at DESC";
}else{
  $sql="SELECT orders.id,orders.order_id,orders.no_items,orders.total_cost,orders.shop_id,orders.customer_id,orders.payment_type,orders.note,orders.delivery_charge,orders.discount_amount,orders.payment_amount,orders.additional_cost,orders.address,orders.status,orders.created_at,customers.name,customers.mobile,shop_setting.business_name FROM orders INNER JOIN customers ON (customers.id=orders.customer_id) INNER JOIN shop_setting ON (shop_setting.id=orders.shop_id) WHERE orders.customer_id='".$cust_id."' ".$search." && status='$status' ORDER BY orders.created_at DESC";
}

$exe = $db->query($sql);
$results_orders = $exe->fetch_all(MYSQLI_ASSOC);
foreach ($results_orders as $key => $value) {
  $order_id=$value['id'];
  $sql_product="SELECT product_id FROM order_details WHERE order_id='$order_id' LIMIT 1";
  $exe_product = $db->query($sql_product);
  if($exe_product->num_rows>0){
    $results_product = $exe_product->fetch_all(MYSQLI_ASSOC);
    $product_id = $results_product[0]['product_id'];

    $sql_image="SELECT image FROM product_images WHERE product_id='$product_id' LIMIT 1";
    $exe_image = $db->query($sql_image);
    if($exe_image->num_rows>0){
      $results_image = $exe_image->fetch_all(MYSQLI_ASSOC);
      $results_orders[$key]['image'] = $results_image[0]['image'];
    }else{
      $results_orders[$key]['image'] = '';
    }
  }else{
    $results_orders[$key]['image'] = '';
  }
}
echo json_encode($results_orders);
?>