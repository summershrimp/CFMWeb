<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$t = $GLOBALS['db']->delete("shop_goods", "`good_id`='" . $_GET['detail'] . "'", 1);
if ($t == false) {
	echo "<div class='return error'>删除失败！</div>";
}
else {
	echo "<div class='return success'>删除成功！</div>";	
}
?>
