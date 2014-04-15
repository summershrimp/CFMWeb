<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$t = $db->insert("shop", "'0','" . $_POST['owner'] . "','" . $_POST['name'] . "','" .
	$_POST['desc'] . "','" . $_POST['pos'] . "','" . $_POST['phone'] . "',NULL,NULL,NULL");
if ($t == false) {
	echo "<div class='returnerror'>插入失败，请检查输入数据！</div>";
}
else {
	echo "<div class='returnsuccess'>插入成功！</div>";
}
?>
