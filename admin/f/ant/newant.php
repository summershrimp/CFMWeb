<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
mt_srand((double) microtime() * 1000000);
$_POST['salt'] = mt_rand(0, 2147483647);
$_POST['password'] = md5("123456" . $_POST['salt']);
$data = array("ant_name", "email", "ant_real_name", "sex", "mobile_phone", "password", "salt");
$getpost = get_post($data);
$t = $db->insert("ants", $data, $getpost);
if ($t == false) {
	echo "<div class='return error'>插入失败，请检查输入数据！</div>";
}
else {
	echo "<div class='return success'>插入成功！</div>";
}
?>
