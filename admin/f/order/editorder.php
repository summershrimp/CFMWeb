<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$t = $GLOBALS['db']->update("order_info", "`user_id`='" . $_POST['user_id'] .
	"' , `ant_id`='" . $_POST['ant_id'] .
	"' , `address`='" . $_POST['address'] .
	"' , `order_status`='" . $_POST['order_status'] .
	"' , `ant_status`='" . $_POST['ant_status'] .
	"' , `confirm_status`='" . $_POST['confirm_status'] .
	"' , `shipping_status`='" . $_POST['shipping_status'] .
	"' , `taking_status`='" . $_POST['taking_status'] .
	"' , `pay_status`='" . $_POST['pay_status'] .
	"' , `pay_id`='" . $_POST['pay_id'] .
	"' , `add_date`='" . $_POST['add_date'] . "'",
	"`order_id`='" . $_GET['detail'] . "'", 1
);
if ($t == false) {
	echo "<div class='return error'>修改失败，请检查输入数据！</div>";
}
else {
	echo "<div class='return success'>修改成功！</div>";
}
?>
