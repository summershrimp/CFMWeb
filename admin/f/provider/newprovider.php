<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
mt_srand((double) microtime() * 1000000);
$salt = mt_rand(0, 2147483647);
$password = md5("123456" . $salt);
$t = $db->insert("providers", "'0','" . $_POST['email'] . "','" . $_POST['provider_name'] . "','$password','','','" .
	$_POST['sex'] . "','0000-00-00','0','0','0000-00-00 00:00:00','0:0:0:0','0','0','$salt','0','0','','" .
	$_POST['qq'] . "','" . $_POST['mobile_phone'] . "','0','0.00','','','','',''");
if ($t == false) {
	echo "<div class='returnerror'>插入失败，请检查输入数据！</div>";
}
else {
	echo "<div class='returnsuccess'>插入成功！</div>";
}
?>
