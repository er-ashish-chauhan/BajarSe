<?php
session_start();
require 'nagad_db.php';
$db=connect_db();

$shop_id=$_REQUEST["shop_id"];
$total_cost=$_REQUEST["total_cost"];
$total_payment_amount=$_REQUEST["total_payment_amount"];
$cust_id=$_REQUEST["cust_id"];
$note=$_REQUEST["note"];
$delivery_address=$_REQUEST["delivery_address"];
$products=$_REQUEST["products"];
$delivery_mode=$_REQUEST["delivery_mode"];
$discount_amount=$_REQUEST["discount_amount"];
$delivery_charge=$_REQUEST["delivery_charge"];
$no_contact=$_REQUEST["no_contact"];

$json_products = json_decode($products);
$num_items = sizeof($json_products);


$sql = "INSERT INTO orders(no_items,total_cost,shop_id,customer_id,note,address,delivery_type,discount_amount,payment_amount,delivery_charge,no_contact,created_at)"." VALUES('$num_items','$total_cost','$shop_id','$cust_id','$note','$delivery_address','$delivery_mode','$discount_amount','$total_payment_amount','$delivery_charge','$no_contact',now())";
$exe = $db->query($sql);
$order_id = $db->insert_id;
if(!empty($order_id)){
  $ord_id = "NGD".$order_id;
  $sql1 = "UPDATE orders SET order_id='$ord_id' WHERE id=$order_id";
  $exe1 = $db->query($sql1);

  foreach ($json_products as $key => $value) {
    $id = $value->id;
    $quantity = $value->quantity;
    $buying_price = $value->buying_price;
    $sql = "INSERT INTO order_details(order_id,product_id,quantity,price,created_at)"." VALUES('$order_id','$id','$quantity','$buying_price',now())";
    $exe = $db->query($sql);
  }
  $data = array('status'=>true,'message'=>'Do you want to place order? Payment Mode will be Cash or UPI on delivery/pickup');
}else{
  $data = array('status'=>false,'message'=>'Order did not create');
}
echo json_encode($data);
?>