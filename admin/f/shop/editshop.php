<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$t = $GLOBALS['db']->update("shop", "`shop_name`='" . $_POST['shop_name'] .
	"' , `shop_phone`='" . $_POST['shop_phone'] .
	"' , `owner_id`='" . $_POST['owner_id'] .
	"' , `shop_pos`='" . $_POST['shop_pos'] .
	"' , `shop_desc`='" . $_POST['shop_desc'] .
	"' , `isopen`='" . $_POST['isopen'] . "'",
	"`shop_id`='" . $_GET['detail'] . "'", 1
);
if ($t == false) {
	echo "<div class='return error'>修改失败，请检查输入数据！</div>";
}
else {
	echo "<div class='return success'>修改成功！</div>";
}
?>
