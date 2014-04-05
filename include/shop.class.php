<?php
if (!defined('IN_CFM')) {
	die('Hacking attempt');
}

require "init.inc.php";
require "include/common.class.php";

class Shop extends apicommon {
	function shop_login($shop_user, $shop_pass) {
		return  $this->login($shop_user, $shop_pass, Role_Shop);
	}
	function get_shop_info() {
		$firstday = $GLOBALS['db']->getAll("SELECT date_add(date_add(last_day(CURDATE()),interval 1 day),interval -1 month)");
		$r = $this->history(, Role_Shop, $firstday, CURDATE())
	}
	function get_shop_items() {
	
	}
	function add_item($content) {
		
	}
	function change_item($content) {
		
	}
}
