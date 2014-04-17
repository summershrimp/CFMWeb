<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$data = array("shop_id", "price", "onsales", "good_name", "good_desc");
$getpost = get_post($data);
$t = $db->insert("shop_goods", $data, $getpost);
if ($t == false) {
	echo "<div class='return error'>插入失败，请检查输入数据！</div>";
}
else {
	echo "<div class='return success'>插入成功！</div>";
}
?>
