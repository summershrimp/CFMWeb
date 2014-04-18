<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$t = $GLOBALS['db']->update("user_address", "`user_id`='" . $_POST['user_id'] .
	"' , `user_realname`='" . $_POST['user_realname'] .
	"' , `user_phone`='" . $_POST['user_phone'] .
	"' , `address`='" . $_POST['address'] . "'",
	"`addr_id`='" . $_GET['detail'] . "'", 1
);
if ($t == false) {
	echo "<div class='return error'>修改失败，请检查输入数据！</div>";
}
else {
	echo "<div class='return success'>修改成功！</div>";
}
?>
