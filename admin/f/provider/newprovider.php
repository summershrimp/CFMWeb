<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
mt_srand((double) microtime() * 1000000);
$_POST['salt'] = mt_rand(0, 9999);
$_POST['password'] = md5("123456" . $_POST['salt']);
$data = array("provider_name", "email", "password", "salt", "sex", "qq", "mobile_phone");
$getpost = get_post($data);
$t = $GLOBALS['db']->insert("providers", $data, $getpost);
if ($t == false) {
	echo "<div class='return error'>插入失败，请检查输入数据！</div>";
}
else {
	echo "<div class='return success'>插入成功！</div>";
}
?>
