<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$all_success = true;
$list = "";
if (isset($_POST['chk'])) {
	foreach ($_POST['chk'] as $e) {
		$result = $GLOBALS['db']->select("user_id", "customers", "`user_id`='$e'", 1);
		if ($result == false || $GLOBALS['db']->fetch($result) == false) {
			$list .= ($list == "" ? "" : ", ") . $e;
			$all_success = false;
		}
		else {
			$GLOBALS['db']->delete("customers", "`user_id`='$e'", 1);
		}
	}
	if ($all_success == true) {
		echo "<div class='return success'>批量删除成功！</div>";
	}
	else {
		echo "<div class='return warning'>部分用户未找到！ID：" . safe_output($list) . "</div>";
	}
}
else {
	echo "<div class='return error'>未指定用户！</div>";
}
?>
