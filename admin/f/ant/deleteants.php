<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
if (isset($_POST['chk'])) {
	foreach ($_POST['chk'] as $e) {
		$db->delete("ants", "`ant_id`='" . $e . "'", 1);
	}
	echo "<div class='returnsuccess'>批量删除成功！</div>";	
}
else {
	echo "<div class='returnerror'>未指定Ant！</div>";
}
?>
