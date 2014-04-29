<?php

/*
	Author: Rex Zeng
	Describtion: Shop class
*/

if (!defined('IN_CFM')) {
	die('Hacking attempt');
}

require_once "includes/init.inc.php";
require_once "includes/defines.inc.php";
require_once "includes/common.class.php";

class shop extends apicommon {
	
    private $shop_id;
    
    public function shop($accesscode = NULL)
    {
        if ($accesscode!=NULL)
        {
            $ans = $this->check_access_code($accesscode);
            if ($ans['status'] == STATUS_SUCCESS)
                $this->shop_id = intval($ans['id']);
            else die(json_encode($ans));
        }
    }
    
	/**
	 * 统计销售总额
	 */
    /*
	function get_amount($r) {
		$result = 0;
		foreach ($r as $item) {
			$t = $this->details($item['order_id']);
			$result += $t['goods_price'];
		}
		return $result;
	}
	*/
	public function shop_static()
	{
	    $end=date("Y-m-d");
	    $start = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-7,date("Y")));
	    $sql="Select Count(*) as total ,Sum(tips_amount) as amount From".$GLOBALS['cfm']->table('order_info').
	    " Where `shop_id` = '$this->shop_id' And `add_date` Between '$start' And '$end' ";
	    $arr = $GLOBALS['db']->getRow($sql);
	    $return["week_count"] = $arr['total'];
	    $return["week_tips"] = $arr['amount'];
	
	    $end=date("Y-m-d");
	    $sql="Select Count(*) as total ,Sum(tips_amount) as amount From".$GLOBALS['cfm']->table('order_info').
	    " Where `shop_id` = '$this->shop_id' And `add_date` = '$end' ";
	    $arr = $GLOBALS['db']->getRow($sql);
	    $return["day_count"] = $arr['total'];
	    $return["day_tips"] = $arr['amount'];
	
	    $end=date("Y-m-d");
	    $start = date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y")));
	    $sql="Select Count(*) as total ,Sum(tips_amount) as amount From".$GLOBALS['cfm']->table('order_info').
	    " Where `shop_id` = '$this->shop_id' And `add_date` Between '$start' And '$end' ";
	    $arr = $GLOBALS['db']->getRow($sql);
	    $return["month_count"] = $arr['total'];
	    $return["month_tips"] = $arr['amount'];
	
	    return $return;
	}
	
	/**
	 * 商店信息（销售数量和销售总额）
	 */
	/*
	function get_shop_info($id) {
		$cur_date = $GLOBALS['db']->getRow("SELECT CURDATE() result");
		$cur_date = $cur_date['result'];date("Y-m-d");
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
	*/
	/**
	 * 获取一段时间的历史记录
	 */
	function shop_history($p_start, $p_end)
	{
	   return $this->history($this->shop_id, Role_Shop, $p_start, $p_end);
	}
	
	/*
	function shop_history($id, $start, $end) {
		$r = $this->history($id, Role_Shop, $start, $end);
		$result = array();
		foreach ($r as $item) {
			$t = $this->details($item['order_id']);
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
	*/
	
	/**
	 * 获取商店业主信息
	 */
	function get_shop_info($id) {
		$sql = "SELECT * FROM " . $GLOBALS['cfm']->table("shop") . " WHERE `shop_id` = $id LIMIT 1";
		$r1 = $GLOBALS['db']->getRow($sql);
		$result['shop_name'] = $r1['shop_name'];
		$sql = "SELECT `last_time`, `last_ip`, `mobile_phone`, `sex` FROM " . $GLOBALS['cfm']->table("providers") . " WHERE `provider_id` = " . $r1['owner_id'] . "LIMIT 1";
		$r2 = $GLOBALS['db']->getRow($sql);
		$result = $r2;
		$result = $r1;
		return $result;
	}
	/**
	 * 切换商品状态
	 */
	function switch_good_status($good_id, $good_status) {
		$sql = "UPDATE " . $GLOBALS['cfm']->table("shop_goods") . " SET `onsale` = $good_status WHERE `good_id` = $good_id LIMIT 1";
		$t = $GLOBALS['db']->query($sql);
		if($GLOBALS['db']->affected_rows()==1)
		    return $good_status;
		else return !$good_status;
	}
	/**
	 * 商店接单
	 */
	function accept_order($order_id) {
		$sql = "UPDATE " . $GLOBALS['cfm']->table("order_info") . "SET `order_status` = 1 WHERE `order_id` = $order_id AND `order_status` = 0 LIMIT 1";
		$t = $GLOBALS['db']->query($sql);
		if($GLOBALS['db']->affected_rows()==1)
		    return 1;
		else return 0;
	}
	
	public function switch_shop_status($status)
	{
	    $sql = "UPDATE " . $GLOBALS['cfm']->table('shop') . " SET `isopen` = '$status' Where `shop_id` = '$this->shop_id' LIMIT 1";
	    $GLOBALS['db']->query($sql);
	    if($GLOBALS['db']->affected_rows()==1)
	        return true;
	    return false;
	}
	
}
