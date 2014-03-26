<?php
if (!defined('IN_CFM')) {
	die('Hacking attempt');
}

class Shop {
	private $shop_id;
	private $shop_name;
	function Shop($shop_id) {
		$this->shop_id = $shop_id;
		$sql = "SELECT * From " . $GLOBALS['cfm']->table('shop') . " Where `shop_id` = " . $shop_id;
		$result = $GLOBALS['db']->getAll($sql);
	}
	function shop_login($shop_user, $shop_pass) {
		
	}
	function get_shop_info() {
		
	}
	function get_shop_items() {
	
	}
	function add_item($content) {
		
	}
	function change_item($content) {
		
	}
}
