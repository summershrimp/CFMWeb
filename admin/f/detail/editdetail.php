<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$t = $db->update("order_details", "`order_id`='" . $_POST['order_id'] .
	"' , `good_id`='" . $_POST['good_id'] .
	"' , `good_name`='" . $_POST['good_name'] .
	"' , `good_number`='" . $_POST['good_number'] .
	"' , `good_price`='" . $_POST['good_price'] . "'",
	"`rec_id`='" . $_GET['detail'] . "'", 1
);
if ($t == false) {
	echo "<div class='return error'>修改失败，请检查输入数据！</div>";
}
else {
	echo "<div class='return success'>修改成功！</div>";
}
?>
