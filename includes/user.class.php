<?php
if (! defined('IN_CFM')) {
    die('Hacking attempt');
}

class user
{

    public $user_id;

    public function user($wxid)
    {
        $user_id = $this -> checkLogin($wxid);
        if (! $userid) $this -> ErrorMSG(BADPASS);
    }

    public function getAddress( )
    {
        $sql = "SELECT * FROM " . $GLOBALS["db"] -> prefix . "user_address Where `user_id` = " . $this -> user_id . " LIMIT 1";
        $arr = $GLOBALS["db"] -> getALL($sql);
        return $arr;
    }

    public function placeOrder($carts, $address, $tips)
    {
        $order_id = $this -> makeNewOrder($address);
        
    }

    public function makeNewOrder($address, $tips)
    {
        $ordersn = date("Ymd") + substr(str_pad(20, time()), '0', STR_PAD_LEFT, 12, 20);
        $sql = "Insert INTO " . $GLOBALS["db"] -> prefix . "order_info (`order_sn`, `user_id`,`order_status`,`shipping_status`,`pay_status`,`address`,`user_phone`,`tips_amount`) " . "VALUES ('" . $ordersn . "','" . $address['user_id'] . "',1,0,0,'" . $address['address'] . "','" . $address['user_phone'] . "','" . $tips . "')";
        $GLOBALS['db'] -> query($sql);
        return $GLOBALS['db'] -> insert_id();
    }
}