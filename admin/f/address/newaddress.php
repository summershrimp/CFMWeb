<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$data = array("user_id", "user_realname", "user_phone", "address");
$getpost = get_post($data);
$t = $GLOBALS['db']->insert("user_address", $data, $getpost);
if ($t == false) {
	echo "<div class='return error'>插入失败，请检查输入数据！</div>";
}
else {
	echo "<div class='return success'>插入成功！</div>";
}
?>
