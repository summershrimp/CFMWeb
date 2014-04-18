<?php
if (!defined("IN_CFM")) {
	exit("Hacking attempt");
}
$all_success = true;
$list = "";
if (isset($_POST['chk'])) {
	foreach ($_POST['chk'] as $e) {
		$result = $GLOBALS['db']->select("good_id", "shop_goods", "`good_id`='$e'", 1);
		if ($result == false || $GLOBALS['db']->fetch($result) == false) {
			$list .= ($list == "" ? "" : ", ") . $e;
			$all_success = false;
		}
		else {
			$GLOBALS['db']->delete("shop_goods", "`good_id`='$e'", 1);
		}
	}
	if ($all_success == true) {
		echo "<div class='return success'>批量删除成功！</div>";
	}
	else {
		echo "<div class='return warning'>部分商品未找到！ID：$list</div>";
	}
}
else {
	echo "<div class='return error'>未指定商品！</div>";
}
?>
