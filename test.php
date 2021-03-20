<?php
$products='[{"id":38,"quantity":1,"name":"Product112","detail":"KmkProduct detal","price":"150","buying_price":"150"}]';
$json_products = json_decode($products);

foreach ($json_products as $key => $value) {
    print_r($value);
    echo $value->id;
    // $json_obj = json_decode($value);
    // $id = $json_obj->id;
    // $quantity = $json_obj->quantity;
    // $buying_price = $json_obj->buying_price;
    // $sql = "INSERT INTO order_details(order_id,product_id,quantity,price,created_at)"." VALUES('$order_id','$id','$quantity','$buying_price',now())";
    // $exe = $db->query($sql);
  }

?>
