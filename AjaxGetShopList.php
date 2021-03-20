<?php
session_start();
require 'nagad_db.php';
$cust_id=$_REQUEST["cust_id"];
$lat=$_REQUEST["lat"];
$lon=$_REQUEST["lon"];
$delivery_charge=$_REQUEST["delivery_charge"];
$distance_filter=$_REQUEST["distance_filter"];
$payment_type=$_REQUEST["payment_type"];
$delivery_type=$_REQUEST["delivery_type"];
$shop_category_filter=$_REQUEST["shop_category_filter"];
$shop_type_filter=$_REQUEST["shop_type_filter"];


$active_status=1;
$date=date('yy-m-d');
$db=connect_db();

if($delivery_charge!=0){
  $delivery_charge=" && (shop_setting.delivery_free=1 OR shop_setting.delivery_charge<".$delivery_charge.")";
}else{
  $delivery_charge="";
}

if($payment_type==3){
  $payment_type=" && shop_setting.payment_type!=0";
}else{
  $payment_type=" && shop_setting.payment_type=".$payment_type;
}

if($delivery_type==3){
  $delivery_type=" && shop_setting.delivery_mode!=0";
}else{
  $delivery_type=" && shop_setting.delivery_mode=".$delivery_type;
}

if($shop_category_filter!='all'){
  $shop_category_filter=" && shop_setting.category='".$shop_category_filter."'";
}else{
  $shop_category_filter="";
}

if($shop_type_filter!='all'){
  $shop_type_filter=" && shop_setting.shop_type=".$shop_type_filter;
}else{
  $shop_type_filter="";
}



// if($distance_filter!=0){
//   $distance_filter=" && (shop_setting.delivery_free=1 OR shop_setting.delivery_charge<".$delivery_charge.")";
// }

$sql1 = "SELECT shop_setting.id,shop_setting.business_name,shop_setting.tagline,shop_setting.category,shop_setting.shop_type,shop_setting.shop_image,shop_setting.shop_cover_image,shop_setting.payment_type,shop_setting.delivery_mode,shop_setting.delivery_free,shop_setting.delivery_charge,shop_setting.min_order_value,shop_setting.max_delivery_distance,shop_setting.delivery_time,shop_setting.active_status,shop_setting.address,shop_setting.mobile,cust_fav_stores.id as fav, shop_setting.latitude,shop_setting.longitude FROM shop_setting LEFT JOIN cust_fav_stores ON (shop_setting.id=cust_fav_stores.shop_id && cust_fav_stores.cust_id='$cust_id') WHERE shop_setting.active_status=1 && shop_setting.approve_status=1".$payment_type.$delivery_type.$delivery_charge.$shop_type_filter.$shop_category_filter;
$exe1 = $db->query($sql1);
$results_data = $exe1->fetch_all(MYSQLI_ASSOC);

foreach ($results_data as $key => $value) {
	$distance = distance($value['latitude'], $value['longitude'], $lat, $lon, "K");
	if($distance_filter<$distance){
		unset($results_data[$key]);
	}else{
		$results_data[$key]['distance']= round($distance);
	}

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