<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$salt = rand();
$password = md5("123456");
$password = md5($password . $salt);
$content = "'0','" . $_POST['email'] . "','" . $_POST['name'] . "','$password','" .
	$_POST['real_name'] . "','','','" . $_POST['sex'] .
	"','1900-00-00','0','0','0','0','0','0000-00-00 00:00:00', '', NULL, '$salt', '0', '0', '','" .
	$_POST['mobile'] . "', '0', NULL, NULL, '', '', NULL";
$t = $db->insert("ants", $content);
if ($t == false) {
	echo "<div class='returnerror'>插入失败，请检查输入数据！</div>";
}
else {
	echo "<div class='returnsuccess'>插入成功！</div>";
}
?>
