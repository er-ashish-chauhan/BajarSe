<?php
session_start();
require 'nagad_db.php';
$products=$_REQUEST["products"];
explode(",", $products);

for ($i=0; $i < sizeof($products); $i++) { 
  $sql="SELECT product_id FROM products WHERE order_id='$order_id' LIMIT 1";
  $exe = $db->query($sql);
}

$status=$_REQUEST["status"];
$search=$_REQUEST["search"];

$db=connect_db();
if($status==0){
  $sql="SELECT orders.id,orders.order_id,orders.no_items,orders.total_cost,orders.shop_id,orders.customer_id,orders.payment_type,orders.note,orders.additional_cost,orders.address,orders.status,orders.created_at,customers.name,customers.mobile,shop_setting.business_name FROM orders INNER JOIN customers ON (customers.id=orders.customer_id) INNER JOIN shop_setting ON (shop_setting.id=orders.shop_id) WHERE orders.customer_id='$cust_id' ORDER BY orders.created_at DESC";
}else{
  $sql="SELECT orders.id,orders.order_id,orders.no_items,orders.total_cost,orders.shop_id,orders.customer_id,orders.payment_type,orders.note,orders.additional_cost,orders.address,orders.status,orders.created_at,customers.name,customers.mobile,shop_setting.business_name FROM orders INNER JOIN customers ON (customers.id=orders.customer_id) INNER JOIN shop_setting ON (shop_setting.id=orders.shop_id) WHERE orders.customer_id='$cust_id' && status='$status' ORDER BY orders.created_at DESC";
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