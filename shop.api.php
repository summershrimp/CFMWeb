<?php
require "include/shop.class.php";

$content = json_decode($SERVER['HTTP_RAW_POST_DATA']);
$shop = new Shop();

if ($content['act'] == "shop_login") {
	$t = $shop->shop_login($content['username'], $content['password']);
	if ($t == false) {
		$result['status'] = UNAVAIL_USER;
	}
	else {
		$result['accesscode'] = $t;
		$t = $shop->get_info($t, Role_Shop);
		$result['user_nick'] = $t['provider_name'];
		$result['user_pic_url'] = $t['user_pic_url'];
		$result['status'] = STATUS_SUCCESS;
	}
}
else {
	if (!isset($content['accesscode'])) {
		$result['status'] = ILLIGAL_ACCESSTOKEN;
	}
	$t = $shop->check_access_code($content['accesscode']);
	if ($t == false) {
		$result['status'] = ILLIGAL_ACCESSTOKEN;
	}
	else {
		$id = $t['id'];
		switch ($content['act']) {
		case "shop_static":
			$result = $shop->get_shop_info($id);
			$result['status'] = STATUS_SUCCESS;
			break;
		case "shop_history":
			$result['orders'] = $shop->shop_history($id, $content['periodstart'], $content['periodend']);
			$result['status'] = STATUS_SUCCESS;
			break;
		case "order_details":
			$result = $shop->order_details($content['order_id'], $content['order_detail']);
			$result['status'] = STATUS_SUCCESS;
			break;
		case "shop_info":
			$result = $shop->shop_info($id);
			$result['status'] = STATUS_SUCCESS;
			break;
		case "switch_good_status":
			$result['ant_status'] = $shop->switch_good_status($content['good_id'], $content['good_status']);
			$result['status'] = STATUS_SUCCESS;
			break;
		case "accept_order":
			$result['take_status'] = $shop->accept_order($content['order_id']);
			$result['status'] = STATUS_SUCCESS;
			break;
		case "get_food_menu":
			$result = $shop->get_food_menu($id);
			$result['status'] = STATUS_SUCCESS;
			break;
		default:
			$result['status'] = ERROR_CONTENT;
			break;
		}
	}
}
return json_encode($result);
?>
