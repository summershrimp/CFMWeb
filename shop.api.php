<?php
/**
 * Shop登录
 */
function ShopLogin($act = "ShopLogin", $username, $password) {
	$result['status'] = "";
	$result['accesscode'] = "";
	$result['usernick'] = "";
	$result['userpicurl'] = "";
	return $result;
}
/**
 * 获取Shop端统计信息
 */
function ShopStatic($act = "ShopStatic", $accesscode) {
	$result['status'] = "";
	$result['daycount'] = "";
	$result['dayamount'] = "";
	$result['weekcount'] = "";
	$result['weekamount'] = "";
	$result['monthcount'] = "";
	$result['monthamount'] = "";
	return $result;
}
/**
 * 获取Shop端历史概览
 */
function ShopHistory($act = "ShopHistory", $accesscode, $periodstart, $periodend) {
	$result['status'] = "";
	$result['orders']['orderid'] = "";
	$result['orders']['price'] = "";
	$result['orders']['time'] = "";
	$result['orders']['shop_name'] = "";
	$result['orders']['cust_name'] = "";
	return $result;
}
/**
 * 获取每一单详情
 */
function OrderDetails($act = "OrderDetails", $accesscode, $orderid, $orderdetail) {
	$result['status'] = "";
	$result['orderid'] = "";
	$result['shop_name'] = "";
	$result['cust_name'] = "";
	$result['price'] = "";
	$result['time'] = "";
	$result['orderstat'] = "";
	$result['goods']['good_name'] = "";
	$result['goods']['good_desc'] = "";
	$result['goods']['good_price'] = "";
	$result['goods']['good_amount'] = "";
	return $result;
}
/**
 * 获取Shop信息
 */
function ShopInfo($act = "ShopInfo", $accesscode) {
	$result['status'] = "";
	$result['shopid'] = "";
	$result['shopname'] = "";
	$result['shoprealname'] = "";
	$result['sex'] = "";
	$result['lasttime'] = "";
	$result['lastip'] = "";
	$result['picurl'] = "";
	$result['phone'] = "";
	return $result;
}
/**
 * 切换Shop商品状态
 */
function SwitchGoodStatus($act = "SwitchGoodStatus", $accesscode, $goodid, $goodstatus) {
	$result['status'] = "";
	$result['goodid'] = "";
	$result['antstatus'] = "";
	return $result;
}
/**
 * Shop接单
 */
function AcceptOrder($act = "AcceptOrder", $accesscode, $orderid) {
	$result['status'] = "";
	$result['takestatus'] = "";
	return $result;
}
/**
 * Shop获取商品列表
 */
function GetGoodMenu($act = "GetGoodMenu", $accesscode) {
	$result['goodname'] = "";
	$result['gooddesc'] = "";
	$result['goodprice'] = "";
	$result['goodstatus'] = "";
	return $result;
}
?>
