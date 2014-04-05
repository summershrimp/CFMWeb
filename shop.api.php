<?php
require "include/shop.class.php";
$content = json_decode($SERVER['HTTP_RAW_POST_DATA']);
$shop = new Shop();
switch ($content['act']) {
case "shop_login":
	$t = $shop->shop_login($content['username'], $content['password']);
	if ($t == false) {
		$result['status'] = UNAVAIL_USER;
	}
	else {
		$result['accesscode'] = $t;
		$t = $shop->get_info($t, Role_Shop);
		$result['user_nick'] = $t['provider_name'];
		//$result['user_pic_url'] = $t[''];
		$result['status'] = STATUS_SUCCESS;
	}
	break;
case "shop_static":
	$t = $shop->check_access_code($content['accesscode']);
	if ($t == false) {
		$result['status'] = ILLIGAL_ACCESSTOKEN;
	}
	else {
		$result = $shop->get_shop_info($t['id']);
		$result['status'] = STATUS_SUCCESS;
	}
	break;
case "shop_history":
	$t = $shop->check_access_code($content['accesscode']);
	if ($t == false) {
		$result['status'] = ILLIGAL_ACCESSTOKEN;
	}
	else {
		$result['orders'] = $shop->shop_history($t['id'], $content['periodstart'], $content['periodend']);
		$result['status'] = STATUS_SUCCESS;
	}
	break;
case "order_details":
	$t = $shop->check_access_code($content['accesscode']);
	if ($t == false) {
		$result['stauts'] = ILLIGAL_ACCESSTOKEN;
	}
	else {
		$result = $shop->order_details($content['order_sn'], $content['order_detail']);
		$result['status'] = STATUS_SUCCESS;
	}
	break;
case "shop_info":
	$t = $shop->check_access_code($content['accesscode']);
	if ($t == false) {
		$result['status'] = ILLIGAL_ACCESSTOKEN;
	}
	else {
		$result = $shop->shop_info($t['id']);
		$result['status'] = STATUS_SUCCESS;
	}
	break;
case "switch_good_status":
	$t = $shop->check_access_code($content['accesscode']);
	if ($t == false) {
		$result['status'] = ILLIGAL_ACCESSTOKEN;
	}
	else {
		$result['good_id'] = $content['good_id'];
		$result['ant_status'] = $shop->switch_good_status($content['good_id'], $content['good_status']);
		$result['status'] = STATUS_SUCCESS;
	}
	break;
case "accept_order":
	$t = $shop->check_access_code($content['accesscode']);
	if ($t == false) {
		$result['status'] = ILLIGAL_ACCESSTOKEN;
	}
	else {
		#######################################################
		# unfinished
		#######################################################
		$result['status'] = STATUS_SUCCESS;
	}
	break;
case "get_food_menu":
	$t = $shop->check_access_code($content['accesscode']);
	if ($t == false) {
		$result['status'] = ILLIGAL_ACCESSTOKEN;
	}
	else {
		$result = $shop->get_food_menu($t['id']);
		$result['status'] = STATUS_SUCCESS;
	}
	break;
default:
	$result['status'] = ERROR_CONTENT;
	break;
}
return json_encode($result);
?>
