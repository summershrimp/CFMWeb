<?php

if (! defined('IN_CFM'))
{
    die('Hacking attempt');
}

require_once ROOT_PATH . 'includes/common.class.php';
require_once ROOT_PATH . 'includes/modules/sms/sms.class.php';
require_once ROOT_PATH . 'includes/modules/channel/Channel.class.php';

class user extends apicommon
{

    private $user_id;
    
    
    public function user($accesscode = NULL)
    {
        if ($accesscode!=NULL)
        {
            $ans = $this->check_access_code($accesscode);
            if ($ans['status'] == STATUS_SUCCESS)
            $this->user_id = intval($ans['id']);
            else die(json_encode($ans));
        }
    }

    public function send_confirm($phone_number)
    {
        $sms=new sms(SMS_APP_ID,SMS_APP_SEC);
        $verify_code = rand(100000,999999);
        $sql="UPDATE ".$GLOBALS['cfm']->table("customers")." SET `verify_code` = '$verify_code' , `mobile_phone` = '$phone_number' Where `user_id` = '$this->user_id' LIMIT 1";
        $GLOBALS['db']->query($sql);
        if( $sms->send_sms($phone_number, $verify_code))
            return true;
        return false;
    }

    public function confirm_phone($phone_number, $confirm_number)
    {
        $sql = "SELECT `mobile_phone`, `verify_code` From ".$GLOBALS['cfm']->table("customers")."Where `user_id` = '$this->user_id' LIMIT 1";
        $arr = $GLOBALS['db']->getRow($sql);
        if($arr['verify_code']==$confirm_number&&$arr['mobile_phone']==$phone_number)
        {
            $sql="UPDATE ".$GLOBALS['cfm']->table("customers")." SET `is_validated` = '1' Where `user_id` = '$this->user_id' LIMIT 1";
            $GLOBALS['db']->query($sql);
            return true;
        }
        else return false;
    }
    
    public function check_verify()
    {
        $sql = "Select `mobile_phone` From ".$GLOBALS['cfm']->table('customers')." Where `user_id` = '$this->user_id' LIMIT 1";
        $arr = $GLOBALS['db']->getRow($sql);
        if(isset($arr['mobile_phone'])&&$arr['mobile_phone']!="")
            return true;
        else 
            return false;
    }
    
    public function check_unpaid($nonce = NULL)
    {
        $sql = "SELECT `order_id`,`nonce` From " . $GLOBALS['cfm']->table('order_info') . " Where `pay_status` = 0 AND `order_status` = 1 AND `user_id` = '$this->user_id' ";
        $arr = $GLOBALS['db']->getRow($sql);
        if( isset($arr['nonce']) && $arr['nonce'] == $nonce)
            return false;
        if (isset($arr['order_id']))
            return $arr['order_id'];
        else
            return false;
    }

    public function get_shop_menu($limit_start = 0, $limit_end = 20)
    {
        $sql = "SELECT * From " . $GLOBALS['cfm']->table('shop') . "LIMIT $limit_start, $limit_end";
        $arr = $GLOBALS['db']->getAll($sql);
        return $arr;
    }

    public function get_shop_count()
    {
        $sql = "SELECT Count(*) From " . $GLOBALS['cfm']->table('shop');
        $count = $GLOBALS['db']->getOne($sql);
        return intval($count);
    }
    
    public function get_hot_menu($limit_start , $limit_end )
    {
        $sql = "SELECT * From " . $GLOBALS['cfm']->table('shop_goods') . "Where `onsale` = '1' and `unavail` = '0' LIMIT $limit_start , $limit_end ";
        $arr = $GLOBALS['db']->getAll($sql);
        return $arr;
    }
    public function get_hot_count()
    {
        $sql = "SELECT Count(*) From " . $GLOBALS['cfm']->table('shop_goods') . "Where `onsale` = '1' ";
        $count = $GLOBALS['db']->getOne($sql);
        return intval($count);
    }
    public function get_address()
    {
        $sql = "SELECT * FROM " . $GLOBALS['cfm']->table('user_address') . " Where `user_id` = " . $this->user_id . " LIMIT 1";
        $arr = $GLOBALS["db"]->getRow($sql);
        return $arr;
    }

    public function place_order($carts, $address, $tips, $nonce)
    {
    	if(!$this->check_unpaid($nonce) && $this->check_verify())
    	{
	        $sql = "Select `order_id` From ". $GLOBALS['cfm']->table('order_info') ." Where `nonce` = '$nonce' ";
	        $query = $GLOBALS['db']->query($sql);
	        if(($GLOBALS['db']->num_rows($query))>0)
	        {
	            $arr = $GLOBALS['db']->fetchRow($query);
	            return $arr['order_id'];
	        }
	        $order_id = $this->make_new_order($address, $tips,$nonce);
	        if($order_id<=0)
	            return false;
	        $total_price = 0;
	        $last_id = -1;
	        foreach ($carts as $good_id => $good_amount)
	        {
	            $sql = "Select `good_name`, `price`, `unavail`, `shop_id` From " . $GLOBALS['cfm']->table('shop_goods') . " Where `good_id` = '" . trim($good_id) . "'";
	            $arr = $GLOBALS['db']->getRow($sql);
	            if($last_id = -1) $last_id = $arr['shop_id'];
	            if(!isset($arr['unavail']))
	                $arr['unavail']=0;
	            if($arr['unavail']==1||$last_id!=$arr['shop_id'])
	            {
	                $this->delete_new_order($order_id);
	                return false;
	            }
	            $good_price = $arr['price'];
	            $good_name = $arr['good_name'];
	            if($last_id = -1) $last_id = $arr['shop_id'];
	            $total_price+=(floatval($good_price) * intval($good_amount));
	            
	            $sql = "Insert INTO " . $GLOBALS['cfm']->table('order_details') . " (`order_id`, `good_id`,`good_name`,`good_number`,`good_price`) 
	             VALUES('" . $order_id . "','" . $good_id . "','" . $good_name . "', '" . $good_amount . "','" . $good_price . "' )";
	            $GLOBALS['db']->query($sql);
	            $last_id = $arr['shop_id'];
	            
	        }
	        $sql="UPDATE ".$GLOBALS['cfm']->table('order_info')." Set `goods_amount` = $total_price , `shop_id` = '$last_id' Where `order_id` = '$order_id' LIMIT 1 ";
	        $GLOBALS['db']->query($sql);
	        if($GLOBALS['db']->affected_rows()>0)
	        {
	            $channel = new Channel(CHANNEL_API_KEY,CHANNEL_SECRET_KEY);
	            $options[Channel::TAG_NAME] = 'ants';
	            $messages = Array(
	            	'act'=>'new_order',
	            	'order_id'=>$order_id,
	                'tips'=>$tips ,
	                'address'=>$address['address']
	            );
	            $channel->pushMessage(Channel::PUSH_TO_TAG, $messages, 'toAnt'.$order_id,$options);
	            
	            return $order_id;
	        }
	        else 
	        {
	            $this->delete_new_order($order_id);
	            return false;
	        }
    	}
    	else return false;
    }

    public function cancel_order($order_id)
    {
        $sql = "UPDATE " . $GLOBALS['cfm']->table('order_info') . "SET `order_status` = 0 Where `order_id` = ' $order_id ' AND `ant_status` = 0 AND `order_status` = 1 AND `user_id` = $this->user_id LIMIT 1";
        $GLOBALS['db']->query($sql);
        if (! $GLOBALS['db']->affected_rows())
            return false;
        else
            return true;
    }

    public function confirm_sent($order_id)
    {
        $sql = "UPDATE " . $GLOBALS['cfm']->table('order_info') . " SET `shipping_status` = 1 ,`shipping_time` = CURRENT_TIMESTAMP Where `order_id` = ' $order_id ' AND `shipping_status` = 0 LIMIT 1";
        $GLOBALS['db']->query($sql);
        if (! $GLOBALS['db']->affected_rows())
            return false;
        else
            return true;
    }
    
    public function get_history($p_start, $p_end)
    {
        return $this->history($this->user_id, Role_User, $p_start, $p_end);
    }
    
    public function check_status($order_id)
    {
    	$GLOBALS['db']->query("START TRANSCATION");
    	$sql = "Select `order_status`, `ant_status`, `confirm_status`, `order_time_ms` From " . $GLOBALS['cfm']->table('order_info') . " Where `order_id` = '$order_id' LIMIT 1";
    	$result = $GLOBALS['db']->query($sql);
    	
    	if (($GLOBALS['db']->num_rows($result))<1)
    		return false;
    	$arr = $GLOBALS['db']->fetchRow($result);
    	$ms = intval($arr['order_time_ms']);
    	if((time()-$ms)>90 && $arr['ant_status'] == 0)
    	{
    		$sql = "Update ". $GLOBALS['cfm']->table('order_info') ." SET `order_status` = '0' Where `order_id` = '$order_id' AND `order_status` = '1' AND `ant_status` = '0' LIMIT 1 ";
    		$GLOBALS['db']->query($sql);
    		$arr['order_status'] = 0;
    	}
    	$GLOBALS['db']->query("COMMIT");
    	unset($arr['order_time_ms']);
    	return $arr;
    }
    
    public function pay($order_id)
    {
        // TODO:看完接口再写
    }
    
    public function add_feedback($content)
    {
        $this->feedback($this->user_id,Role_User,$content);
    }
    
    private function make_new_order($address, $tips, $nonce)
    {
        $sql = "Select * From ".$GLOBALS['cfm']->table('user_address')." Where `user_id` = '$this->user_id' LIMIT 1";
        $query = $GLOBALS['db']->query($sql);
        if($GLOBALS['db']->num_rows($query)<1)
            $sql = "Insert INTO ".$GLOBALS['cfm']->table('user_address')." (`user_realname`,`user_phone`,`user_id`,`address`) VALUES ('".$address['user_realname']."','".$address['user_phone']."','$this->user_id','".$address['address']."')";
        else 
            $sql = "Update ".$GLOBALS['cfm']->table('user_address')." SET `user_realname`='".$address['user_realname']."', `user_phone`='".$address['user_phone']."', `address`='".$address['address']."' Where `user_id` = '$this->user_id' LIMIT 1";
        $query = $GLOBALS['db']->query($sql);
        srand(time());
        $order_sn =  date("Ymd").substr(time(true), -5) . rand(1000, 9999) . (intval($this->user_id)%8999 + 1001);
        $sql = "Insert INTO " . $GLOBALS['cfm']->table('order_info') . " (`order_sn`, `user_id`, `user_realname`, `order_status`,`address`,`user_phone`,`tips_amount`, `order_time_ms`, `add_date`,`nonce`) VALUES ('$order_sn', '$this->user_id', '".$address['user_realname']."', 1, '".$address['address']."', '".$address['user_phone']."', '$tips', '".time()."','".date("Y-m-d")."','$nonce') ";
        $GLOBALS['db']->query($sql);
        $order_id = $GLOBALS['db']->insert_id();
        return $order_id;
    }
    
    private function delete_new_order($order_id)
    {
        $sql="DELETE From ".$GLOBALS['cfm']->table('order_details')." Where `order_id` = '$order_id' ";
        $GLOBALS['db']->query($sql);
        $sql="DELETE From ".$GLOBALS['cfm']->table('order_info')." Where `order_id` = '$order_id' ";
        $GLOBALS['db']->query($sql);
    }
}
?>