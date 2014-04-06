<?php
if (!defined('IN_CFM')) {
	die('Hacking attempt');
}

require "init.inc.php";
require "include/defines.inc.php";
require "include/common.class.php";

class Shop extends apicommon {
	function get_amount($r) {
		$result = 0;
		foreach ($r as $item) {
			$t = $this->order_details($item['order_sn']));
			$result += $t['goods_price'];
		}
		return $result;
	}
	function get_shop_info($id) {
		$cur_date = $GLOBALS['db']->getRow("SELECT CURDATE() result");
		$cur_date = $cur_date['result'];
		$r = $this->history($id, Role_Shop, $cur_date, $cur_date);
		$result['day_count'] = count($r);
		$result['day_amount'] = $this->get_amount($r);
		$first_day = $GLOBALS['db']->getRow("SELECT DATE_ADD(CURDATE(),INTERVAL -WEEKDAY(CURDATE()) DAY) result");
		$first_day = $first_day['result'];
		$r = $this->history($id, Role_Shop, $first_day, $cur_date);
		$result['week_count'] = count($r);
		$result['week_amount'] = $this->get_amount($r);
		$first_day = $GLOBALS['db']->getRow("SELECT DATE_ADD(DATE_ADD(LAST_DAY(CURDATE()),INTERVAL 1 DAY),INTERVAL -1 MONTH) result");
		$first_day = $first_day['result'];
		$r = $this->history($id, Role_Shop, $first_day, $cur_date);
		$result['month_count'] = count($r);
		$result['month_amount'] = $this->get_amount($r);
		return $result;
	}
	function shop_history($id, $start, $end) {
		$r = $this->history($id, Role_Shop, $start, $end);
		$result = array();
		foreach ($r as $item) {
			$t = $this->order_details($item['order_sn']);
			$temp['order_id'] = $t['order_id'];
			$temp['price'] = $t['goods_price'];
			$temp['time'] = $item['pay_time'];
			$sql = "SELECT `ant_name` FROM " . $GLOBALS['cfm']->table("providers") . "WHERE `provider_id` = $item['user_id'] LIMIT 1";
			$t = $GLOBALS['db']->getRow($sql);
			$temp['shop_name'] = $t['provider_name'];
			$sql = "SELECT `ant_name` FROM " . $GLOBALS['cfm']->table("ants") . "WHERE `ant_id` = $item['ant_id'] LIMIT 1";
			$t = $GLOBALS['db']->getRow($sql);
			$temp['cust_name'] = $t['ant_name'];
			$result[] = $temp;
		}
		return $result;
	}
	function shop_info($id) {
		$sql = "SELECT * FROM " . $GLOBALS['cfm']->table("shop") . " WHERE `shop_id` = $id LIMIT 1";
		$r = $GLOBALS['db']->getRow($sql);
		$result['shop_name'] = $r['shop_name'];
		$sql = "SELECT * FROM " . $GLOBALS['cfm']->table("providers") . " WHERE `provider_id` = $r['owner_id'] LIMIT 1";
		$r = $GLOBALS['db']->getRow($sql);
		$result['shop_real_name'] = $r['provider_name'];
		$result['sex'] = $r['sex'];
		$result['last_time'] = $r['last_time'];
		$result['last_ip'] = $r['last_ip'];
		$result['pic_url'] = $r['user_pic_url'];
		$phone = $r['mobile_phone'];
		$phone = substr($phone, 0, 3) . "****" . substr($phone, -4);
		$result['phone'] = $phone;
		return $result;
	}
	function switch_good_status($good_id, $good_status) {
		$sql = "UPDATE " . $GLOBALS['cfm']->table("shop_goods") . " SET `onsales` = $good_status WHERE `good_id` = $good_id LIMIT 1";
		$t = $GLOBALS['db']->query($sql);
		$sql = "SELECT * FROM " . $GLOBALS['cfm']->table("shop_goods") . " WHERE `good_id` = $good_id LIMIT 1";
		$t = $GLOBALS['db']->query($sql);
		if (!isset($t['onsales'])) {
			return 0;
		}
		else {
			return $t['onsales'];
		}
	}
	function accept_order($order_id) {
		$sql = "UPDATE " . $GLOBALS['cfm']->table("order_info") . "SET `order_status` = 1 WHERE `order_id` = $order_id LIMIT 1";
		$t = $GLOBALS['db']->query($sql);
		$sql = "SELECT * FROM " . $GLOBALS['cfm']->table("order_info") . " WHERE `order_id` = $order_id LIMIT 1";
		$t = $GLOBALS['db']->query($sql);
		if (!isset($t['order_status'])) {
			return 0;
		}
		else {
			return $t['order_status'];
		}
	}
	function get_food_menu($id) {
		$sql = "SELECT * FROM " . $GLOBALS['cfm']->table("shop_goods") . " WHERE `shop_id` = $id LIMIT 1";
		$t = $GLOBALS['db']->getRow($sql);
		$result['good_name'] = $t['good_name'];
		$result['good_desc'] = $t['good_desc'];
		$result['good_price'] = $t['price'];
		$result['good_status'] = $t['onsales'];
		return $result;
	}
}
