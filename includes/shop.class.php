<?php

/*
	Author: Rex Zeng
	Describtion: Shop class
*/

if (!defined('IN_CFM')) {
	die('Hacking attempt');
}

require "includes/init.inc.php";
require "includes/defines.inc.php";
require "includes/common.class.php";

class Shop extends apicommon {
	/**
	 * 统计销售总额
	 */
	function get_amount($r) {
		$result = 0;
		foreach ($r as $item) {
			$t = $this->order_details($item['order_id']);
			$result += $t['goods_price'];
		}
		return $result;
	}
	/**
	 * 商店信息（销售数量和销售总额）
	 */
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
	/**
	 * 获取一段时间的历史记录
	 */
	function shop_history($id, $start, $end) {
		$r = $this->history($id, Role_Shop, $start, $end);
		$result = array();
		foreach ($r as $item) {
			$t = $this->order_details($item['order_id']);
			$temp['order_id'] = $t['order_id'];
			$temp['price'] = $t['goods_price'];
			$temp['time'] = $item['pay_time'];
			$sql = "SELECT `ant_name` FROM " . $GLOBALS['cfm']->table("providers") . "WHERE `provider_id` = " . $item['user_id'];
			$t = $GLOBALS['db']->getOne($sql);
			$temp['shop_name'] = $t['provider_name'];
			$sql = "SELECT `ant_name` FROM " . $GLOBALS['cfm']->table("ants") . "WHERE `ant_id` = " . $item['ant_id'] . "LIMIT 1";
			$t = $GLOBALS['db']->getRow($sql);
			$temp['cust_name'] = $t['ant_name'];
			$result[] = $temp;
		}
		return $result;
	}
	/**
	 * 获取商店业主信息
	 */
	function shop_info($id) {
		$sql = "SELECT * FROM " . $GLOBALS['cfm']->table("shop") . " WHERE `shop_id` = $id LIMIT 1";
		$r = $GLOBALS['db']->getRow($sql);
		$result['shop_name'] = $r['shop_name'];
		$sql = "SELECT * FROM " . $GLOBALS['cfm']->table("providers") . " WHERE `provider_id` = " . $r['owner_id'] . "LIMIT 1";
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
	/**
	 * 切换商品状态
	 */
	function switch_good_status($good_id, $good_status) {
		$sql = "UPDATE " . $GLOBALS['cfm']->table("shop_goods") . " SET `onsales` = $good_status WHERE `good_id` = $good_id LIMIT 1";
		$t = $GLOBALS['db']->query($sql);
		$sql = "SELECT * FROM " . $GLOBALS['cfm']->table("shop_goods") . " WHERE `good_id` = $good_id LIMIT 1";
		$t = $GLOBALS['db']->getRow($sql);
		if (!isset($t['onsales'])) {
			return 0;
		}
		else {
			return $t['onsales'];
		}
	}
	/**
	 * 商店接单
	 */
	function accept_order($order_id) {
		$sql = "SELECT * FROM " . $GLOBALS['cfm']->table("order_info") . " WHERE `order_id` = $order_id AND `order_status` = 0 LIMIT 1";
		$t = $GLOBALS['db']->getRow($sql);
		if ($t == false || empty($t)) {
			return 0;
		}
		else {
			$sql = "UPDATE " . $GLOBALS['cfm']->table("order_info") . "SET `order_status` = 1 WHERE `order_id` = $order_id LIMIT 1";
			$t = $GLOBALS['db']->query($sql);
			return 1;
		}
	}
}
