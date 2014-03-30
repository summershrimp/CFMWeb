<?php
require "include/shop.class.php";
function check_accesscode($accesscode) {
	return true;
}
$content = json_decode($SERVER['HTTP_RAW_POST_DATA']);
$shop = new Shop();
switch ($content['act']) {
case "shop_login":
	$shop->shop_login($content['username'], $content['password']);
	$result['status'] = 0;
	$result['accesscode'] = "";
	$result['user_nick'] = "";
	$result['user_pic_url'] = "";
	break;
case "shop_static":
	$t = check_accesscode($content['accesscode']);
	$result['status'] = 0;
	$result['day_count'] = "";
	$result['day_amount'] = "";
	$result['week_count'] = "";
	$result['week_amount'] = "";
	$result['month_count'] = "";
	$result['month_amount'] = "";
	break;
case "shop_history":
	$t = check_accesscode($content['accesscode']);
	$result['status'] = 0;
	$result['orders']['order_id'] = "";
	$result['orders']['price'] = "";
	$result['orders']['time'] = "";
	$result['orders']['shop_name'] = "";
	$result['orders']['cust_name'] = "";
	break;
case "order_details":
	$t = check_accesscode($content['accesscode']);
	$result['status'] = 0;
	$result['order_id'] = 0;
	$result['shop_name'] = 0;
	$result['cust_name'] = 0;
	$result['price'] = 0;
	$result['time'] = 0;
	$result['order_stat'] = 0;
	$result['goods']['good_name'] = "";
	$result['goods']['good_desc'] = "";
	$result['goods']['good_price'] = "";
	$result['goods']['good_price'] = "";
	$result['goods']['good_amount'] = "";
	break;
case "shop_info":
	$t = check_accesscode($content['accesscode']);
	$result['status'] = 0;
	$result['order_id'] = 0;
	$result['shop_name'] = 0;
	$result['cust_name'] = 0;
	$result['price'] = 0;
	break;
case "switch_good_status":
	# code
	break;
case "accept_order":
	# code
	break;
case "get_good_menu":
	# code
	break;
}
return json_encode($result);
?>
