<?php
if (! defined ( 'IN_CFM' ))
{
    die ( 'Hacking attempt' );
}

class user
{
	public $user_id;
    public function user($wxid)
    {
    	$user_id=$this->checkLogin($wxid);
        if(!$userid) $this->ErrorMSG(BADPASS);
    }
    
    public function getAddress()
    {
    	$sql="SELECT * FROM ".$GLOBALS["db"]."user_address Where `user_id` = ".$this->user_id." LIMIT 1";
    	$arr=$GLOBALS["db"]->getALL($sql);
    	return $arr;
    }
    
    
    
    
    public function placeOrder($carts,$address,$tips)
    {
    	$order_id=$this->makeNewOrder($address);
    }
    
    public function makeNewOrder($address)
    {
    	
    }
    
}