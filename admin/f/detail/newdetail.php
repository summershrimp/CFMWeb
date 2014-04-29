<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$data = array("order_id", "good_id", "good_name", "good_number", "good_price");
$getpost = get_post($data);
$t = $GLOBALS['db']->insert("order_details", $data, $getpost);
if ($t == false) {
	echo "<div class='return error'>插入失败，请检查输入数据！</div>";
}
else {
	echo "<div class='return success'>插入成功！</div>";
}
?>
