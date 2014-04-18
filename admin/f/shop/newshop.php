<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$data = array("owner_id", "shop_name", "shop_desc", "shop_pos", "shop_phone");
$getpost = get_post($data);
$t = $GLOBALS['db']->insert("shop", $data, $getpost);
if ($t == false) {
	echo "<div class='return error'>插入失败，请检查输入数据！</div>";
}
else {
	echo "<div class='return success'>插入成功！</div>";
}
?>
