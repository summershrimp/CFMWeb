<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$t = $db->update("shop", "`shop_name`='" . $_POST['name'] .
	"' , `shop_phone`='" . $_POST['phone'] .
	"' , `shop_pos`='" . $_POST['pos'] .
	"' , `shop_desc`='" . $_POST['desc'] . "'",
	"`shop_id`='" . $_GET['detail'] . "'", 1
);
if ($t == false) {
	echo "<div class='returnerror'>修改失败，请检查输入数据！</div>";
}
else {
	echo "<div class='returnsuccess'>修改成功！</div>";
}
?>
