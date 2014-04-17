<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$t = $db->update("shop_goods", "`shop_id`='" . $_POST['shop_id'] .
	"' , `price`='" . $_POST['price'] .
	"' , `onsales`='" . $_POST['onsales'] .
	"' , `good_name`='" . $_POST['good_name'] .
	"' , `good_desc`='" . $_POST['good_desc'] . "'",
	"`good_id`='" . $_GET['detail'] . "'", 1
);
if ($t == false) {
	echo "<div class='return error'>修改失败，请检查输入数据！</div>";
}
else {
	echo "<div class='return success'>修改成功！</div>";
}
?>
