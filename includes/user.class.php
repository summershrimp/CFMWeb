<?php

if (! defined('IN_CFM'))
{
    die('Hacking attempt');
}

require_once ROOT_PATH . 'includes/common.class.php';
require_once ROOT_PATH . 'includes/modules/sms/sms.class.php';
class user extends apicommon
{

    public $user_id;

    public function user($accesscode = NULL)
    {
        if ($accesscode!=NULL)
        {
            $ans = $this->check_access_code($accesscode);
            if ($ans['status'] == STATUS_SUCCESS)
                $this->user_id = $ans['id'];
        }
    }

    public function send_confirm($phone_number)
    {
        $sms=new sms();
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

    public function check_unpaid()
    {
        $sql = "SELECT `order_id` From " . $GLOBALS['cfm']->table('order_info') . " Where `pay_status` = 0";
        $arr = $GLOBALS['db']->getOne($sql);
        if (isset($arr))
            return $arr;
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
        $sql = "SELECT * From " . $GLOBALS[cfm]->table('shop_goods') . "Where `onsale` = '1' LIMIT $limit_start , $limit_end ";
        $arr = $GLOBALS['db']->getAll($sql);
        return $arr;
    }
    public function get_hot_count()
    {
        $sql = "SELECT Count(*) From " . $GLOBALS[cfm]->table('shop_goods') . "Where `onsale` = '1' ";
        $count = $GLOBALS['db']->getOne($sql);
        return intval($count);
    }
    public function get_address()
    {
        $sql = "SELECT * FROM " . $GLOBALS['cfm']->table('user_address') . " Where `user_id` = " . $this->user_id . " LIMIT 1";
        $arr = $GLOBALS["db"]->getRow($sql);
        return $arr;
    }

    public function place_order($carts, $address, $tips)
    {
        $order_id = $this->make_new_order($address, $tips);
        if($order_id<=0)
            return false;
        foreach ($carts as $good)
        {
            $sql = "Select `good_name`, `price`, `unavail` From " . $GLOBALS['cfm']->table('shop_goods') . " Where `good_id` = '" . trim($good['good_id']) . "'";
            $arr = $GLOBALS['db']->getRow($sql);
            if(!isset($arr['unavail']))
                $arr['unavail']=1;
            if($arr['unavail']==1)
            {
                $this->delete_new_order($order_id);
                return false;
            }
            $good_price = $arr['price'];
            $good_name = $arr['good_name'];
            
            $sql = "Insert INTO " . $GLOBALS['cfm']->table('order_details') . " (`order_id`, `good_id`,`good_name`,`good_number`,`good_price`) 
             VALUES('" . $order_id . "','" . $good['good_id'] . "','" . $good_name . "', '" . $good['amount'] . "',
               '" . $good_price . "' )";
            $GLOBALS['db']->query($sql);
            
        }
        return $order_id;
    }

    public function cancel_order($order_id)
    {
        $sql = "UPDATE " . $GLOBALS['cfm']->table('order_info') . "SET `order_status` = 0 Where `order_id` = ' $order_id ' AND `ant_status` = 0 AND `order_status` = 1 LIMIT 1";
        $GLOBALS['db']->query($sql);
        if (! $GLOBALS['db']->affected_rows())
            return false;
        else
            return true;
    }

    public function confirm_sent($order_id)
    {
        $sql = "UPDATE " . $GLOBALS['cfm']->table('order_info') . " SET `shipping_status` = 1 Where `order_id` = ' $order_id ' AND `shipping_status` = 0 LIMIT 1";
        $GLOBALS['db']->query($sql);
        if (! $GLOBALS['db']->affected_rows())
            return false;
        else
            return true;
    }

    public function pay($order_id)
    {
        // TODO:看完接口再写
    }

    private function make_new_order($address, $tips)
    {
        //$order_sn = date("Ymd") + substr(str_pad(20, time()), '0', STR_PAD_LEFT, 12, 20);
        $order_sn="20142342234";
        $sql = "Insert INTO " . $GLOBALS['cfm']->table('order_info') . " (`order_sn`, `user_id`, `user_realname`, `order_status`,`address`,`user_phone`,`tips_amount`) VALUES ('$order_sn', '$this->user_id', '".$address['user_realname']."', 1, '".$address['address']."', '".$address['user_phone']."', '$tips')";
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