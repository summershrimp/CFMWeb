<?php
if (! defined('IN_CFM')) {
    die('Hacking attempt');
}
require_once './common.class.php';
require_once './Channel.class.php';
require_once '../data/config.php';

class user extends apicommon;
{

    public $user_id;
    private $bae_channel = new Channel(CHANNEL_API_KEY,CHANNEL_SECRET_KEY);
    public function user($wxid)
    {
        $user_id = $this -> check_user($wxid,Role_User);
        if (! $userid) $this -> error_msg(Bad_Pass);
    }


    public function send_confirm($phone_number)
    {
        //TODO:等待短信接口！

    }

    public function confirm_phone($phone_number,$confirm_number)
    {
        //TODO:继续等短信接口
    }

    

    public function get_shop_menu($limit_start=0,$limit_end=20)
    {
        $sql = "SELECT `shop_id`, `shop_name`,`shop_pos` From ".$GLOBALS['cfm']->table('shop').
               "LIMIT $limit_start, $limit_end";
        $arr=$GLOBALS['db']->getAll($sql);
        return $arr;
    }

    public function get_shop_count()
    {
        $sql = "SELECT Conut(*) From ".$GLOBALS['cfm']->table('shop');
        $count = $GLOBALS['db']->getOne($sql);
        return $count;
    }

    public function get_address( )
    {
        $sql = "SELECT * FROM " . $GLOBALS['cfm']->table('user_address').
               " Where `user_id` = " . $this -> user_id . " LIMIT 1";
        $arr = $GLOBALS["db"] -> getALL($sql);
        return $arr;
    }

    public function place_order($carts, $address, $tips)
    {
        $order_id = $this -> makeNewOrder($address,$tips);
        foreach ($carts as $goodid => $goodcount) {
            $sql="Select `good_name`, `price` From ".$GLOBALS['cfm']->table('shop_goods').
            "Where `good_id` = '".$goodid."'";
            $arr=$GLOBALS['db']->getRow($sql);
            $good_price=$arr['price'];
            $good_name=$arr['good_name'];

            $sql="Insert INTO ".GLOBALS['cfm']->table('order_details').
            " (`order_id`, `good_id`,`good_name`,`good_number`,`good_price`) 
             VALUES('".$order_id."','".$goodid."','"$good_name"', '".$goodcount."',
               '".$good_price."' )";
            $GLOBALS['db']->query($sql);
            $rec_id=$GLOBALS['db']->insert_id();

        }
        return $order_id;
    }
    public function cancel_order($order_id)
    {
        $sql="UPDATE ".$GLOBALS[cfm]->table('order_info')."SET `order_status` = 0 
        Where `order_id` = ".$order_id." LIMIT 1";
        $GLOBALS['db']->query($sql);
        if(!$GLOBALS['db']->error())
            return true;
        else return false;
    }

    public function confirm_sent($order_id)
    {
        $sql="UPDATE ".$GLOBALS[cfm]->table('order_info')."SET `shipping_status` = 2 
        Where `order_id` = ".$order_id." LIMIT 1";
        $GLOBALS['db']->query($sql);
        if(!$GLOBALS['db']->error())
            return true;
        else return false;
    }

    public function pay($order_id)
    {
        //TODO:看完接口再写
    }
    private function make_new_order($address, $tips)
    {
        $ordersn = date("Ymd") + substr(str_pad(20, time()), '0', STR_PAD_LEFT, 12, 20);
        $sql = "Insert INTO " . $GLOBALS['cfm']->table('order_info')." (`order_sn`, `user_id`,`order_status`,`shipping_status`,`pay_status`,`address`,`user_phone`,`tips_amount`) " . "VALUES ('" . $ordersn . "','" . $address['user_id'] . "',1,0,0,'" . $address['address'] . "','" . $address['user_phone'] . "','" . $tips . "')";
        $GLOBALS['db'] -> query($sql);
        $order_id=$GLOBALS['db'] -> insert_id();
        return $order_id;
    }
}