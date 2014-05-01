<?php

/*
	Author: Rex Zeng
	Describtion: Shop class
*/

if (!defined('IN_CFM')) {
	die('Hacking attempt');
}

require_once ROOT_PATH . 'includes/common.class.php';

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
    /**
     * 商店信息（销售数量和销售总额）
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
	 * 获取一段时间的历史记录
	 */
	function shop_history($p_start, $p_end)
	{
	   return $this->history($this->shop_id, Role_Shop, $p_start, $p_end);
	}
	
	
	/**
	 * 获取商店业主信息
	 */
	function get_shop_info($id) {
		$sql = "SELECT * FROM " . $GLOBALS['cfm']->table("shop") . " WHERE `shop_id` = $id LIMIT 1";
		$r1 = $GLOBALS['db']->getRow($sql);
		$result['shop_name'] = $r1['shop_name'];
		$sql = "SELECT `last_time`, `last_ip`, `mobile_phone`, `sex` FROM " . $GLOBALS['cfm']->table("providers") . " WHERE `provider_id` = " . $r1['owner_id'] . "LIMIT 1";
		$r2 = $GLOBALS['db']->getRow($sql);
		$result = array_merge($r1, $r2);
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
	
	public function change_shop_pass($old_pass,$new_pass)
	{
	    return $this->change_password($this->id, $old_pass, $new_pass, Role_Shop);
	}
	
	public function send_verify_code_shop($phone)
	{
	    $this->send_verify_code(Role_Shop,$phone);
	}
	public function reset_shop_shop($phone,$verify_code,$new_pass)
	{
	    $this->reset_password($phone,$verify_code,$new_pass);
	} 
	
}
