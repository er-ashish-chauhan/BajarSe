<?php
session_start();
require 'nagad_db.php';
$cust_id=$_REQUEST["cust_id"];
$search=$_REQUEST["search"];
$lat=$_REQUEST["lat"];
$lon=$_REQUEST["lon"];

$active_status=1;
$date=date('yy-m-d');
$db=connect_db();


if($search!=""){
	$search="'%".$search."%'";
  	$search=" && shop_setting.business_name LIKE ".$search;
}else{
	$search="";
}


$sql1 = "SELECT shop_setting.id,shop_setting.business_name,shop_setting.tagline,shop_setting.category,shop_setting.shop_type,shop_setting.shop_image,shop_setting.shop_cover_image,shop_setting.payment_type,shop_setting.delivery_mode,shop_setting.delivery_free,shop_setting.delivery_charge,shop_setting.min_order_value,shop_setting.max_delivery_distance,shop_setting.delivery_time,shop_setting.active_status,shop_setting.address,shop_setting.mobile,cust_fav_stores.id as fav,shop_setting.latitude,shop_setting.longitude FROM shop_setting LEFT JOIN cust_fav_stores ON (shop_setting.id=cust_fav_stores.shop_id && cust_fav_stores.cust_id='$cust_id') WHERE shop_setting.active_status=1 && shop_setting.approve_status=1".$search;
$exe1 = $db->query($sql1);
$results_data = $exe1->fetch_all(MYSQLI_ASSOC);

foreach ($results_data as $key => $value) {
	$distance = distance($value['latitude'], $value['longitude'], $lat, $lon, "K");
	$results_data[$key]['distance']= round($distance);
}

echo json_encode($results_data);


function distance($lat1, $lon1, $lat2, $lon2, $unit) {
  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    return 0;
  }
  else {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
      return $miles;
    }
  }
}

?>