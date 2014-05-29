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
	public function shop_static()//TODO:统计函数存在问题，待修改
	{
	    $date = date("Y-m-d");  //当前日期
	    $first=1; //$first =1 表示每周星期一为开始时间 0表示每周日为开始时间
	    $w = date("w", strtotime($date));  //获取当前周的第几天 周日是 0 周一 到周六是 1 -6
	    $d = $w ? $w - $first : 6;  //如果是周日 -6天
	    $now_start = date("Y-m-d", strtotime("$date -".$d." days")); //本周开始时间
	    $now_end = date("Y-m-d", strtotime("$now_start +6 days"));  //本周结束时间
	    $last_start = date('Y-m-d',strtotime("$now_start - 7 days"));  //上周开始时间
	    $last_end = date('Y-m-d',strtotime("$now_start - 1 days"));  //上周结束时间
	    
	    $end=date("Y-m-d");
	    $start = $now_start;
	    $sql="Select Count(*) as total ,Sum(goods_amount) as amount From".$GLOBALS['cfm']->table('order_info').
	    " Where `shop_id` = '$this->shop_id' And `add_date` Between '$start' And '$end' ";
	    $arr = $GLOBALS['db']->getRow($sql);
	    $return["week_count"] = $arr['total'];
	    $return["week_amount"] = $arr['amount'];
	   
	    $end=$last_end;
	    $start = $last_start;
	    $sql="Select Count(*) as total ,Sum(goods_amount) as amount From".$GLOBALS['cfm']->table('order_info').
	    " Where `shop_id` = '$this->shop_id' And `add_date` Between '$start' And '$end' ";
	    $arr = $GLOBALS['db']->getRow($sql);
	    $return["last_week_count"] = $arr['total'];
	    $return["last_week_amount"] = $arr['amount'];
	    
	    
	    $end=date("Y-m-d");
	    $sql="Select Count(*) as total ,Sum(goods_amount) as amount From".$GLOBALS['cfm']->table('order_info').
	    " Where `shop_id` = '$this->shop_id' And `add_date` = '$end' ";
	    $arr = $GLOBALS['db']->getRow($sql);
	    $return["day_count"] = $arr['total'];
	    $return["day_amount"] = $arr['amount'];
	
	    $end=date("Y-m-d");
	    $start = date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y")));
	    $sql="Select Count(*) as total ,Sum(goods_amount) as amount From".$GLOBALS['cfm']->table('order_info').
	    " Where `shop_id` = '$this->shop_id' And `add_date` Between '$start' And '$end' ";
	    $arr = $GLOBALS['db']->getRow($sql);
	    $return["month_count"] = $arr['total'];
	    $return["month_amount"] = $arr['amount'];
	    
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
	function get_shop_info() {

		$sql = "SELECT * FROM " . $GLOBALS['cfm']->table("shop") . " WHERE `shop_id` = $this->shop_id LIMIT 1";
		$r1 = $GLOBALS['db']->getRow($sql);
		$sql = "SELECT `last_time`, `last_ip`, `mobile_phone`, `sex` FROM " . $GLOBALS['cfm']->table("providers") . " WHERE `provider_id` = " . $r1['owner_id'] . " LIMIT 1";
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
	function accept_order($order_id, $disp_id) { 
		$sql = "UPDATE " . $GLOBALS['cfm']->table("order_info") . "SET `confirm_status` = 1 AND `disp_id` = $disp_id WHERE `order_id` = $order_id AND `order_status` = 1 AND `shop_id` = '$this->shop_id'  LIMIT 1";
		$GLOBALS['db']->query($sql);
		if($GLOBALS['db']->affected_rows()==1)
		{
		    $sql = "Select `ant_id` From ".$GLOBALS['cfm']->table('order_info')." Where `order_id` = $order_id LIMIT 1";
		    $ant_id = $GLOBALS['db']->getOne($sql);
		    $this->push_to_ant($ant_id, $order_id, 1,$disp_id);
		    return 1;
		}
		else return 0;
	}
	
	function cancel_order($order_id) {
	    $sql = "UPDATE " . $GLOBALS['cfm']->table("order_info") . "SET `order_status` = -1 WHERE `order_id` = $order_id AND `order_status` = 0 AND `shop_id` = '$shop_id' LIMIT 1";
	    $t = $GLOBALS['db']->query($sql);
	    if($GLOBALS['db']->affected_rows()==1)
	    {
	        $sql = "Select `ant_id` From ".$GLOBALS['cfm']->table('order_info')." Where `order_id` = $order_id LIMIT 1";
	        $ant_id = $GLOBALS['db']->getOne($sql);
	        $this->push_to_ant($ant_id, $order_id, -1);
	        return -1;
	    }
	    else return 0;
	}
	
	
	private function push_to_ant($ant_id, $order_id, $order_status, $disp_id = -1)
	{
	    $sql = "Select `channel_id`,`channel_user_id` From ".$GLOBALS['ecs']->table('ants')." Where `ant_id` = $ant_id LIMIT 1";
	    $arr = $GLOBALS['db']->getRow($sql);
	    $channel = new Channel(CHANNEL_API_KEY,CHANNEL_SECRET_KEY);
	    $options[Channel::USER_ID] = $arr['channel_user_id'];
	    $options[Channel::CHANNEL_ID] = $arr['channel_id'];
	    $message = Array(
	        'act'=>'new_order_confirm',
	        'disp_id'=>$disp_id,
	        'order_id'=>$order_id,
	        'order_status'=>$order_status
	    );
	    $channel->pushMessage(Channel::PUSH_TO_USER, $messages, 'toAntConfirm'.$order_id,$options);
	
	    return $order_id;
	}
	
	public function shop_reg_channel($channel_id,$channel_user_id)
	{
	    return $this->reg_channel(Role_Shop,$this->shop_id,$channel_id,$channel_user_id);
	}
	
	public function switch_shop_status($status)
	{
	    $sql = "UPDATE " . $GLOBALS['cfm']->table('shop') . " SET `isopen` = '$status' Where `shop_id` = '$this->shop_id' LIMIT 1";
	    $GLOBALS['db']->query($sql);
	    return $status;
	}
	public function shop_good_menu($limit_s=0,$limit_e=20)
	{
	    return $this->get_good_menu($this->shop_id,$limit_s,$limit_e);
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
	public function add_feedback($content)
	{
	    $this->feedback($this->shop_id,Role_Shop,$content);
	}
	
}
