<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$t = $db->delete("shop", "`shop_id`='" . $_GET['detail'] . "'", 1);
if ($t == false) {
	echo "<div class='returnerror'>删除失败！</div>";
}
else {
	echo "<div class='returnsuccess'>删除成功！</div>";	
}
?>
