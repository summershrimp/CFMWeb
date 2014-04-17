<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$_POST['order_sn'] = date("Ymd") . '0' . substr(str_pad(time(), 20, '0', STR_PAD_LEFT), 15, 20);
$data = array(
	"order_sn", "user_id", "ant_id", "address", "order_status", "ant_status",
	"confirm_status", "shipping_status", "taking_status", "pay_status", "pay_id", "add_date"
);
$getpost = get_post($data);
$t = $db->insert("order_info", $data, $getpost);
if ($t == false) {
	echo "<div class='return error'>插入失败，请检查输入数据！</div>";
}
else {
	echo "<div class='return success'>插入成功！</div>";
}
?>
